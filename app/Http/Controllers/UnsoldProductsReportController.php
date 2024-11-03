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

        $categories = DB::table('product_category_data')->select('category_id', 'category_name')->get();

        // ดึงข้อมูลสินค้าที่ขายในช่วงวันที่ที่เลือก
        $soldProducts = DB::table('order_shop_detail')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->flatMap(function ($report) {
                $orderItems = collect(json_decode($report->order_items, true));
                return $orderItems->map(function ($item) {
                    return [
                        'product_id' => $item['product_id'] ?? null,
                        'quantity' => $item['quantity'] ?? 0,
                    ];
                });
            });

        // ดึงข้อมูลสินค้าทั้งหมดจาก stock_items และ products
        $allProducts = DB::table('stock_items')
            ->join('products', 'stock_items.product_id', '=', 'products.product_id')
            ->select('stock_items.product_id', 'stock_items.quantity', 'products.product_name', 'products.category_id')
            ->get();

        // กรองสินค้าที่ขายไม่ออก
        $unsoldProducts = $allProducts->filter(function ($product) use ($soldProducts) {
            $soldQuantity = $soldProducts->where('product_id', $product->product_id)->sum('quantity');
            return $soldQuantity == 0;
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
                'quantity' => $product->quantity,
            ];
        });

        return view('admin.tables.reportunsold', compact('groupedItems', 'startDate', 'endDate', 'categories', 'selectedCategory'));
    }
}
