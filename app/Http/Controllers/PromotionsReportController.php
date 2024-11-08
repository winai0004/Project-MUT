<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PromotionsReportController extends Controller
{

    public function index(Request $request)
    {
        // รับค่าวันที่เริ่มต้นและสิ้นสุดจากฟอร์ม
        $startDate = $request->input('start_date', '2024-09-01');
        $endDate = $request->input('end_date', '2024-11-30');

        // Query ข้อมูลจากฐานข้อมูล
        $reports = DB::table('item_orders as io')
            ->join('promotion_data as pd', 'io.product_id', '=', 'pd.product_id')
            ->join('products as p', 'pd.product_id', '=', 'p.product_id')
            ->select(
                'p.product_name',
                'pd.discount',
                DB::raw('SUM(io.total_quantity) AS total_quantity'),
                DB::raw('SUM(io.total_price) AS total_price'),
                DB::raw('p.cost_price * (1 - pd.discount / 100) AS discount_price'),
                DB::raw('SUM(io.total_quantity) * (p.cost_price * (1 - pd.discount / 100)) AS total_sales')
            )
            ->whereBetween('io.created_at', [$startDate, $endDate])
            ->groupBy('p.product_name', 'pd.discount', 'p.cost_price')
            ->orderByDesc('total_sales')
            ->limit(25)
            ->get();

        // ส่งข้อมูลไปที่ view
        return view('admin.tables.promotionsreport', compact('reports'));
    }
}