<?php

    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;
    
    class ReportCostController extends Controller
    {
        public function index(Request $request)
        {
            // รับค่าวันที่เริ่มต้นและวันที่สิ้นสุดจากแบบฟอร์ม
            $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
            $endDate = $request->input('end_date', Carbon::now()->toDateString());
    
            // สร้าง query สำหรับดึงข้อมูลการขายจาก order_shop_detail
            $salesData = DB::table('order_shop_detail')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
    
            // ตรวจสอบว่ามีข้อมูลหรือไม่
            if ($salesData->isEmpty()) {
                return view('admin.tables.costreport', [
                    'costReport' => collect(),
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'message' => 'ไม่มีข้อมูลการขายในช่วงเวลานี้'
                ]);
            }
    
            // แปลงข้อมูล order_shop_detail
            $reports = $salesData->map(function ($report) {
                return [
                    'product_id' => $report->name, // ใช้ชื่อที่เป็นรหัสสินค้า
                    'total_quantity' => $report->total_quantity,
                ];
            });
    
            // Group by product_id and sum the total_quantity
            $groupedItems = $reports->groupBy('product_id')
                ->map(function ($group) {
                    return [
                        'total_quantity' => $group->sum('total_quantity'),
                    ];
                });
    
            // ดึงข้อมูลต้นทุนจากตาราง products
            $costReport = $groupedItems->map(function ($item, $productId) {
                // แก้ไขการค้นหาให้ตรงตาม product_id ที่ถูกต้อง
                $product = DB::table('products')->where('product_name', $productId)->first(); // แก้ไขตรงนี้ให้ใช้ product_name
    
                return [
                    'product_id' => $productId,
                    'product_name' => $product->product_name ?? 'ไม่พบชื่อสินค้า',
                    'cost_price' => $product->cost_price ?? 0,
                    'total_cost' => ($product->cost_price ?? 0) * $item['total_quantity'],
                    'total_quantity' => $item['total_quantity'],
                ];
            });
    
            return view('admin.tables.costreport', [
                'costReport' => $costReport,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'message' => null
            ]);
        }
    }
    