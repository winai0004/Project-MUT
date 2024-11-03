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
        $topSellingItems = DB::table('order_shop_detail')
            ->select('name as product_name', DB::raw('SUM(total_quantity) as total_quantity'), DB::raw('MIN(image) as image'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when($categoryId, function($query) use ($categoryId) {
                // หากต้องการกรองตามประเภทสินค้า, ต้องตรวจสอบว่ามีการเชื่อมโยงข้อมูลหรือไม่
                return $query->whereExists(function ($query) use ($categoryId) {
                    $query->select(DB::raw(1))
                          ->from('products')
                          ->whereRaw('products.product_name = order_shop_detail.name')
                          ->where('products.category_id', $categoryId);
                });
            })
            ->groupBy('name')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();
    
        // ส่งข้อมูลไปยัง View
        return view('admin.tables.report', compact('topSellingItems', 'startDate', 'endDate', 'categoryId', 'categories'));
    }
}    
