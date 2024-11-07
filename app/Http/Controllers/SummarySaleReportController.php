<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class SummarySaleReportController extends Controller
{
    public function index(Request $request)
    {
        // รับค่า start_date และ end_date จากฟอร์ม หรือใช้วันที่เริ่มต้นปีและปัจจุบัน
        $startDate = $request->input('start_date', Carbon::now()->startOfYear()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());
    
        // ดึงข้อมูลจาก order_shop_detail โดยใช้ join กับ products และ item_orders
$salesData = DB::table('order_shop_detail')
    ->join('item_orders', 'order_shop_detail.user_id', '=', 'item_orders.user_id') // ใช้ user_id แทน
    ->join('products', 'item_orders.product_id', '=', 'products.product_id') // เชื่อมกับ products
    ->whereBetween('order_shop_detail.created_at', [$startDate, $endDate]) // กรองข้อมูลตามช่วงวันที่
    ->select(
        'products.product_name', // ชื่อสินค้า
        'item_orders.total_quantity', // จำนวนสินค้าที่ขาย
        'products.selling_price' // ราคาขายของสินค้า
    )
    ->get();

        // หากไม่มีข้อมูลให้ส่งค่ากลับเป็น array ว่างๆ
        if ($salesData->isEmpty()) {
            return view('admin.tables.sumreport', [
                'groupedSalesData' => [],
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);
        }
    
        // คำนวณข้อมูลยอดขายรวมและจำนวนคำสั่งซื้อโดยการ group ข้อมูลตามชื่อสินค้า
        $groupedSalesData = $salesData->groupBy('product_name')->map(function ($group) {
            return [
                'product_name' => $group[0]->product_name, // ชื่อสินค้า
                'total_orders' => $group->count(),  // จำนวนคำสั่งซื้อทั้งหมด
                'total_sales' => $group->sum(function ($item) {
                    return $item->total_quantity * $item->selling_price;  // คำนวณยอดขายรวม
                }),
                'total_quantity' => $group->sum('total_quantity'),  // จำนวนสินค้าที่ขายรวม
            ];
        });
    
        // ส่งข้อมูลไปยัง View
        return view('admin.tables.sumreport', [
            'groupedSalesData' => $groupedSalesData,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
