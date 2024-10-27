<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SummarySaleReportController extends Controller
{
    public function index(Request $request)
    {
        // รับค่าจากฟอร์ม
        $startDate = $request->input('start_date', Carbon::now()->startOfYear()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        // ดึงข้อมูลคำสั่งซื้อที่อยู่ในช่วงวันที่ที่เลือก
        $salesData = DB::table('order_shopping')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->flatMap(function ($order) {
                // ตรวจสอบว่ามี order_items หรือไม่
                if (empty($order->order_items)) {
                    return collect(); // ส่งกลับ collect ว่างถ้าไม่มี order_items
                }

                $orderItems = collect(json_decode($order->order_items, true));

                // ดึงข้อมูลจากตาราง products เพื่อให้ได้ product_name
                return $orderItems->map(function ($item) use ($order) {
                    $product = DB::table('products')->where('product_id', $item['product_id'])->first();

                    return [
                        'product_id' => $item['product_id'],
                        'product_name' => $product ? $product->product_name : 'ไม่พบชื่อสินค้า',
                        'quantity' => $item['quantity'],
                        'total_price' => $order->total_price, // รวมยอดขาย
                    ];
                });
            });

        // รวมข้อมูลตาม product_id และคำนวณผลรวมของ quantity
        $groupedSalesData = $salesData->groupBy('product_id')
            ->map(function ($group) {
                return [
                    'product_name' => $group->first()['product_name'],
                    'total_orders' => $group->count(), // จำนวนคำสั่งซื้อ
                    'total_quantity' => $group->sum('quantity'),
                    'total_sales' => $group->sum('total_price'), // ยอดขายรวม
                ];
            });

        // ส่งข้อมูลไปยัง view
        return view('admin.tables.sumreport', compact('groupedSalesData', 'startDate', 'endDate'));
    }
}