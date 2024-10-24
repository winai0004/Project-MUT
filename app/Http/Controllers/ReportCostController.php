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
        
        // สร้าง query สำหรับดึงข้อมูลการขาย
        $salesData = DB::table('order_shopping')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if ($salesData->isEmpty()) {
            return view('admin.tables.costreport', [ // เปลี่ยนเป็น 'costreport'
                'costReport' => collect(), // ส่งค่าเป็น collect ว่าง ๆ
                'startDate' => $startDate,
                'endDate' => $endDate,
                'message' => 'ไม่มีข้อมูลการขายในช่วงเวลานี้'
            ]);
        }

        // แปลงข้อมูล order_items
        $reports = $salesData->flatMap(function ($report) {
            $orderItems = collect(json_decode($report->order_items, true));
            return $orderItems->map(function ($item) {
                return [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ];
            });
        });

        // Group by product_id and sum the quantity
        $groupedItems = $reports->groupBy('product_id')
            ->map(function ($group) {
                return [
                    'total_quantity' => $group->sum('quantity'),
                ];
            });

        // ดึงข้อมูลต้นทุนจากตาราง products
        $costReport = $groupedItems->map(function ($item, $productId) {
            $product = DB::table('products')->where('product_id', $productId)->first();
            return [
                'product_id' => $productId,
                'product_name' => $product->product_name ?? 'ไม่พบชื่อสินค้า', // เพิ่มการตรวจสอบ
                'cost_price' => $product->cost_price ?? 0,
                'total_cost' => ($product->cost_price ?? 0) * $item['total_quantity'],
                'total_quantity' => $item['total_quantity'],
            ];
        });

        return view('admin.tables.costreport', [ // เปลี่ยนเป็น 'costreport'
            'costReport' => $costReport,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'message' => null
        ]);
    }
}
