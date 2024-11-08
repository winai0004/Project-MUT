<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class SummarySaleReportController extends Controller
{
    public function index(Request $request)
    {
        // รับปีเริ่มต้นและปีสิ้นสุดจากฟอร์ม
        $startYear = $request->input('start_year', Carbon::now()->year); // default ปีเริ่มต้นคือปีปัจจุบัน
        $endYear = $request->input('end_year', Carbon::now()->year); // default ปีสิ้นสุดคือปีปัจจุบัน

        // ดึงข้อมูลจาก order_shop_detail โดยใช้ join กับ products และ item_orders พร้อมกับการดึงข้อมูลปี
        $salesData = DB::table('order_shop_detail')
            ->join('item_orders', 'order_shop_detail.user_id', '=', 'item_orders.user_id')
            ->join('products', 'item_orders.product_id', '=', 'products.product_id')
            ->select(
                'products.product_name', // ชื่อสินค้า
                'item_orders.total_quantity', // จำนวนสินค้าที่ขาย
                'products.selling_price', // ราคาขายของสินค้า
                DB::raw('YEAR(order_shop_detail.created_at) as year') // ดึงข้อมูลปี
            )
            ->whereBetween(DB::raw('YEAR(order_shop_detail.created_at)'), [$startYear, $endYear]) // กรองข้อมูลตามช่วงปีที่เลือก
            ->get();

        // หากไม่มีข้อมูลให้ส่งค่ากลับเป็น array ว่างๆ
        if ($salesData->isEmpty()) {
            return view('admin.tables.sumreport', [
                'groupedSalesData' => [],
                'years' => range($startYear, $endYear),
            ]);
        }

        // ดึงปีทั้งหมดที่อยู่ในข้อมูล
        $years = range($startYear, $endYear);

        // จัดกลุ่มข้อมูลตามชื่อสินค้าและปี
        $groupedSalesData = $salesData->groupBy('product_name')->map(function ($group) use ($years) {
            $yearlyData = [];
            foreach ($years as $year) {
                $yearlyGroup = $group->where('year', $year);
                $yearlyData[$year] = [
                    'total_sales' => $yearlyGroup->sum(function ($item) {
                        return $item->total_quantity * $item->selling_price;
                    }),
                    'total_quantity' => $yearlyGroup->sum('total_quantity')
                ];
            }
            return $yearlyData;
        });

        // ส่งข้อมูลไปยัง View
        return view('admin.tables.sumreport', [
            'groupedSalesData' => $groupedSalesData,
            'years' => range($startYear, $endYear),
        ]);
    }
}
