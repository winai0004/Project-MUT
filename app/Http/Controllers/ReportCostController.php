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
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());
    
        // ดึงข้อมูลการขาย
        $salesData = DB::table('item_orders')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
    
        // ตรวจสอบข้อมูลการขาย
        if ($salesData->isEmpty()) {
            return view('admin.tables.costreport', [
                'costReport' => collect(),
                'startDate' => $startDate,
                'endDate' => $endDate,
                'message' => 'ไม่มีข้อมูลการขายในช่วงเวลานี้'
            ]);
        }
    
        // ดึงข้อมูล product_id ที่มีอยู่ใน salesData
        $productIds = $salesData->pluck('product_id')->unique();
    
        // ดึงข้อมูลจาก products
        $products = DB::table('products')
            ->whereIn('product_id', $productIds)
            ->get()
            ->keyBy('product_id');
    
        // สร้างรายงานต้นทุนสินค้า
        $reports = $salesData->groupBy('product_id')->map(function ($group, $productId) {
            return [
                'total_quantity' => $group->sum('total_quantity'),
            ];
        });
    
        // สร้าง cost report
        $costReport = $reports->map(function ($item, $productId) use ($products) {
            // ตรวจสอบว่ามี product_id อยู่ใน products หรือไม่
            if ($products->has($productId)) {
                $product = $products->get($productId);
                return [
                    'product_id' => $productId,
                    'product_name' => $product->product_name,
                    'cost_price' => $product->cost_price,
                    'total_cost' => $product->cost_price * $item['total_quantity'],
                    'total_quantity' => $item['total_quantity'],
                ];
            } else {
                return [
                    'product_id' => $productId,
                    'product_name' => 'ไม่พบชื่อสินค้า',
                    'cost_price' => 0,
                    'total_cost' => 0, // สมมติว่าไม่มีต้นทุนรวมเมื่อไม่มีสินค้า
                    'total_quantity' => $item['total_quantity'],
                ];
            }
        });
    
        // ดึงข้อมูลที่ไม่มี product_id
        $noProductIdReports = $salesData->filter(function ($sale) {
            return is_null($sale->product_id) || $sale->product_id == 0;
        })->groupBy('item_id')->map(function ($group) {
            return [
                'product_id' => 'ไม่มีสินค้า',
                'product_name' => 'ไม่พบชื่อสินค้า',
                'cost_price' => 0,
                'total_cost' => $group->sum('total_price'), // สมมติว่า total_price เป็นราคาต้นทุนรวม
                'total_quantity' => $group->sum('total_quantity'),
            ];
        });
    
        // รวม cost report ทั้งสองกรณี
        $finalCostReport = $costReport->values()->concat($noProductIdReports->values());
    
        return view('admin.tables.costreport', [
            'costReport' => $finalCostReport,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'message' => null
        ]);
    }
}
