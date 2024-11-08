<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportStockController extends Controller
{
    public function index(Request $request)
    {
    //     // รับค่าวันที่เริ่มต้นและสิ้นสุดจากแบบฟอร์ม
    //     $startDate = $request->input('start_date', Carbon::now()->toDateString());
    //     $endDate = $request->input('end_date', Carbon::now()->toDateString());
    //     $selectedCategory = $request->input('category');

    //     // ดึงประเภทสินค้าทั้งหมดเพื่อใช้ใน dropdown
    //    // ดึงประเภทสินค้าทั้งหมดเพื่อใช้ใน dropdown
    //     $categories = DB::table('product_category_data')->select('category_id', 'category_name')->get();

    //     //ดึงข้อมูลจากตาราง stock_items และกรองตามช่วงวันที่และประเภทสินค้า
    //     $reports = DB::table('stock_items')
    //         ->join('products', 'stock_items.product_id', '=', 'products.product_id') // ใช้ product_id ของ products แทน
    //         ->whereBetween('stock_items.created_at', [$startDate, $endDate]); // กรองตามช่วงวันที่ที่เลือก

    //     // ถ้ามีการเลือกประเภทสินค้าให้กรองด้วย
    //     if ($selectedCategory) {
    //         $reports->where('products.category_id', $selectedCategory); // เปลี่ยน 'category_id' เป็นชื่อจริงของฟิลด์ที่เก็บประเภทสินค้าในตาราง products
    //     }

    //     $reports = $reports->select('stock_items.stock_id', 'products.product_name as product_name', 'stock_items.quantity', 'stock_items.cost_price as price')
    //         ->get();

    //     // จัดกลุ่มตาม stock_id และรวมจำนวน quantity
    //     $groupedItems = $reports->groupBy('stock_id')
    //         ->map(function ($group) {
    //             return [
    //                 'name' => $group[0]->product_name,
    //                 'total_quantity' => $group->sum('quantity'),
    //                 'price' => $group[0]->price,
    //             ];
    //         })
    //         ->sortByDesc('total_quantity')
    //         ->take(5);


    //     // ส่งข้อมูลไปที่ View
    //     return view('admin.tables.reportstock', compact('groupedItems', 'startDate', 'endDate', 'categories', 'selectedCategory'));
    $startDate = $request->input('start_date', Carbon::now()->toDateString());
$endDate = $request->input('end_date', Carbon::now()->toDateString());
$selectedCategory = $request->input('category');

// ดึงประเภทสินค้าทั้งหมดเพื่อใช้ใน dropdown
$categories = DB::table('product_category_data')->select('category_id', 'category_name')->get();

// ดึงข้อมูลจากตาราง stock_items ณ วันที่ที่เลือก
$reports = DB::table('stock_items')
    ->join('products', 'stock_items.product_id', '=', 'products.product_id') // ใช้ product_id ของ products แทน
    ->whereBetween('stock_items.created_at', [$startDate, $endDate]); // กรองตามช่วงวันที่ที่เลือก

// ถ้ามีการเลือกประเภทสินค้าให้กรองด้วย
if ($selectedCategory) {
    $reports->where('products.category_id', $selectedCategory);
}

// เลือกข้อมูลที่ต้องการใช้งาน
$reports = $reports->select('stock_items.stock_id', 'products.product_name as product_name', 'stock_items.quantity', 'stock_items.cost_price as price')
    ->get();

// คัดลอกข้อมูลจาก stock_items ณ ช่วงเวลานั้น และจัดกลุ่มตาม stock_id
$groupedItems = $reports->groupBy('stock_id')
    ->map(function ($group) {
        return [
            'name' => $group[0]->product_name,
            'total_quantity' => $group->sum('quantity'),
            'price' => $group[0]->price,
        ];
    })
    ->sortByDesc('total_quantity')
    ->take(5);

// ส่งข้อมูลไปที่ View
return view('admin.tables.reportstock', compact('groupedItems', 'startDate', 'endDate', 'categories', 'selectedCategory'));

    }
}
