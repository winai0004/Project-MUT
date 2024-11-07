<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UnsoldProductsReportController extends Controller
{
    public function index(Request $request)
    {
        // รับค่า start_date และ end_date จาก form หรือใช้ค่าวันปัจจุบันเป็นค่าเริ่มต้น
        $startDate = $request->input('start_date', Carbon::now()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());
        $selectedCategory = $request->input('category_id'); // รับค่า category_id ที่ถูกเลือกจาก form
    
        // ดึงข้อมูลประเภทสินค้าทั้งหมด
        $categories = DB::table('product_category_data')->select('category_id', 'category_name')->get();
    
        // ดึงข้อมูลสินค้าที่ถูกขายในช่วงวันที่ที่เลือกจาก item_orders
        $soldProducts = DB::table('item_orders')  
            ->join('order', 'item_orders.order_id', '=', 'order.order_id') // เชื่อมโยงกับตาราง order
            ->join('order_shop_detail', 'item_orders.order_id', '=', 'order_shop_detail.order_id') // ตรวจสอบว่าการเชื่อมโยงถูกต้อง
            ->whereBetween('order_shop_detail.created_at', [$startDate, $endDate]) // เช็คช่วงเวลาจากตาราง order_shop_detail
            ->select('item_orders.product_id', DB::raw('SUM(item_orders.total_quantity) as total_quantity'))
            ->groupBy('item_orders.product_id')
            ->get();
    
        // ดึงข้อมูลสินค้าทั้งหมดจากตาราง products
        $allProducts = DB::table('products')
            ->join('product_category_data as c', 'products.category_id', '=', 'c.category_id')
            ->select('products.product_id', 'products.product_name', 'c.category_name', 'products.category_id')
            ->get();
    
        // กรองสินค้าที่ไม่ได้ขายในช่วงเวลานั้น
        $unsoldProducts = $allProducts->filter(function ($product) use ($soldProducts) {
            $soldQuantity = $soldProducts->where('product_id', $product->product_id)->sum('total_quantity');
            return $soldQuantity == 0; // สินค้าที่ไม่ได้ขาย
        });
    
        // กรองตามประเภทสินค้า หากมีการเลือก
        if ($selectedCategory) {
            $unsoldProducts = $unsoldProducts->filter(function ($product) use ($selectedCategory) {
                return $product->category_id == $selectedCategory;
            });
        }
    
        // เตรียมข้อมูลเพื่อส่งไปยัง view
        $groupedItems = $unsoldProducts->map(function ($product) {
            return [
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'category_name' => $product->category_name,
            ];
        });
    
        // ส่งข้อมูลไปยัง view
        return view('admin.tables.reportunsold', compact('groupedItems', 'startDate', 'endDate', 'categories', 'selectedCategory'));
    }
}    