<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SummarySaleReportController extends Controller
{
    public function index(Request $request)
    {
        // รับค่าจากฟอร์ม
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query เพื่อดึงข้อมูลยอดขายตามวันที่กำหนด
        $salesData = DB::table('order_shopping')
            ->select(
                DB::raw('DATE(created_at) as sale_date'),
                DB::raw('COUNT(order_id) as total_orders'),
                DB::raw('SUM(total_price) as total_sales'),
                DB::raw('SUM(total_quantity) as total_quantity')
            )
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('created_at', '<=', $endDate);
            })
            ->groupBy('sale_date')
            ->orderBy('sale_date')
            ->get();

        return view('admin.tables.sumreport', compact('salesData', 'startDate', 'endDate'));
    }
}
