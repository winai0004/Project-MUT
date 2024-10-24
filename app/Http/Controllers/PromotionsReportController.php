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
        $selectedDate = $request->input('day', Carbon::now()->toDateString());

        // ดึงข้อมูลจาก order_shopping ที่มีการสร้างในวันที่เลือก
        $soldProducts = DB::table('order_shopping')
            ->whereDate('created_at', $selectedDate)
            ->get()
            ->flatMap(function ($report) {
                $orderItems = collect(json_decode($report->order_items, true));
                return $orderItems->map(function ($item) {
                    return [
                        'product_id' => $item['product_id'] ?? null,
                        'quantity' => $item['quantity'] ?? 0,
                        'image' => $item['image'] ?? null,
                    ];
                });
            });

        // ดึงข้อมูลสินค้าทั้งหมดจาก stock_items และ products
        $allProducts = DB::table('stock_items')
            ->join('products', 'stock_items.product_id', '=', 'products.product_id') // Join กับตาราง products
            ->select('stock_items.stock_id', 'stock_items.quantity', 'products.product_name') // ลบฟิลด์ image ออก
            ->get();

        // ดึงข้อมูลโปรโมชั่น
        $promotions = DB::table('promotion_data')->get();

        // กรองสินค้าที่ไม่ได้ถูกขาย
        $unsoldProducts = $allProducts->filter(function ($product) use ($soldProducts) {
            $soldQuantity = $soldProducts->where('product_id', $product->stock_id)->sum('quantity');
            return $soldQuantity == 0; // หากจำนวนที่ขายเป็น 0
        });

        // เตรียมข้อมูลเพื่อส่งไปยัง view โดยใช้ $unsoldProducts
        $groupedItems = $unsoldProducts->map(function ($product) use ($promotions) {
            // ค้นหาส่วนลดและชื่อโปรโมชั่นสำหรับสินค้านั้น ๆ
            $promotion = $promotions->firstWhere('stock_id', $product->stock_id);

            return [
                'product_id' => $product->stock_id,
                'product_name' => $product->product_name,
                'image' => 'default.jpg', // ใช้ default.jpg หากไม่มีภาพ
                'quantity' => $product->quantity,
                'discount' => $promotion ? $promotion->discount : 0, // ตรวจสอบว่า $promotion ไม่เป็น null ก่อนเข้าถึง discount
            ];
        });

        return view('admin.tables.promotionsreport', compact('groupedItems', 'selectedDate'));
    }
}
