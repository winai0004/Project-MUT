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
        // รับค่าจากฟิลด์ฟอร์ม
        $selectedStartDate = $request->input('start_date') ?: Carbon::now()->startOfMonth()->toDateString();
        $selectedEndDate = $request->input('end_date') ?: Carbon::now()->endOfMonth()->toDateString();
        $selectedCategoryId = $request->input('type'); // รับ category_id จากฟิลด์ type
    
        // Query ข้อมูลสินค้าขายดี โดยใช้ช่วงวันที่และประเภทสินค้า
        $topSellingItems = DB::table('item_orders')
            ->join('products', 'item_orders.product_id', '=', 'products.product_id')
            ->join('product_category_data', 'products.category_id', '=', 'product_category_data.category_id')
            ->select('products.product_name as product_name', DB::raw('SUM(item_orders.total_quantity) as total_quantity'), DB::raw('MIN(products.product_img) as image'))
            ->whereBetween('item_orders.created_at', [$selectedStartDate, $selectedEndDate]);
    
        // เพิ่มเงื่อนไขการกรองประเภท ถ้าผู้ใช้เลือกประเภท
        if ($selectedCategoryId) {
            $topSellingItems->where('products.category_id', $selectedCategoryId);
        }
    
        $topSellingItems = $topSellingItems->groupBy('product_name')
            ->orderBy('total_quantity', 'desc')
            ->take(5)
            ->get();
    
        // Query ข้อมูลประเภทจากตาราง product_category_data
        $categories = DB::table('product_category_data')
                        ->select('category_id', 'category_name')
                        ->get();
    
        // ส่งค่าตัวแปรไปยัง View
        return view('admin.tables.report', compact('topSellingItems', 'selectedStartDate', 'selectedEndDate', 'selectedCategoryId', 'categories'));
    }
    
}    
