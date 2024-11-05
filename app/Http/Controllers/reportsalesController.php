<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportSalesController extends Controller
{
    public function index(Request $request)
    {
        // รับค่าจากฟอร์ม
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());
        $categoryId = $request->input('category_id');
    
        // ดึงข้อมูลประเภทสินค้าสำหรับ dropdown
        $categories = DB::table('product_category_data')->get();
    
        // ดึงข้อมูลสินค้าขายดีตามช่วงวันที่และประเภทสินค้า
        $topSellingItems = DB::table('item_orders')
            ->join('products', 'item_orders.name', '=', 'products.product_name')
            ->select('products.product_name as product_name', DB::raw('SUM(item_orders.total_quantity) as total_quantity'), DB::raw('MIN(products.product_img) as image'))
            ->whereBetween('item_orders.created_at', [$startDate, $endDate])
            ->when($categoryId, function($query) use ($categoryId) {
                return $query->where('products.category_id', $categoryId);
            })
            ->groupBy('products.product_name')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();
    
        // ส่งข้อมูลไปยัง View
        return view('admin.tables.report', compact('topSellingItems', 'startDate', 'endDate', 'categoryId', 'categories'));
    }
}    
