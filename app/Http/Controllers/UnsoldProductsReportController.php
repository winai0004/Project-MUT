<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class UnsoldProductsReportController extends Controller
{
    public function index(Request $request)
    {
        // กำหนดช่วงเวลาที่ต้องการตรวจสอบ
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->toDateString()); // ค่าเริ่มต้นเป็นเดือนก่อนหน้า
        $endDate = $request->input('end_date', Carbon::now()->toDateString()); // ค่าวันที่ปัจจุบัน
    
        // ดึงข้อมูลประเภทสินค้า
        $categories = DB::table('product_category_data')->get();
    
        // ดึงข้อมูลสินค้าที่ไม่ได้ขายในช่วงเวลาที่กำหนดและกรองตามประเภทที่เลือก
        $unsoldProducts = DB::table('products as p')
            ->leftJoin('item_orders as io', 'p.product_id', '=', 'io.product_id')
            ->leftJoin('product_category_data as c', 'p.category_id', '=', 'c.category_id')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereNull('io.product_id')
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('io.total_quantity', 0)
                              ->whereBetween('io.created_at', [$startDate, $endDate]);
                    });
            })
            ->when($request->input('category_id'), function ($query) use ($request) {
                return $query->where('p.category_id', $request->input('category_id'));
            })
            ->select('p.product_id', 'p.product_name', 'c.category_name')
            ->get();
    
        // ส่งผลลัพธ์ไปยัง view
        return view('admin.tables.reportunsold', compact('unsoldProducts', 'startDate', 'endDate', 'categories'));
    }
}    