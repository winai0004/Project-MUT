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
        // รับค่าวันที่ที่เลือกจากแบบฟอร์ม หรือค่าเริ่มต้นเป็นวันที่ปัจจุบัน
        $selectedDate = $request->input('day', Carbon::now()->toDateString()); // ใช้วันที่ปัจจุบันถ้าไม่มีการเลือก

        // ดึงข้อมูลจาก order_shopping ที่มีการสร้างในวันที่เลือก
        $soldProducts = DB::table('order_shopping')
            ->whereDate('created_at', $selectedDate)  // กรองตามวันที่ที่เลือกหรือวันที่ปัจจุบัน
            ->get()
            ->flatMap(function ($report) {
                $orderItems = collect(json_decode($report->order_items, true));
                return $orderItems->map(function ($item) {
                    return [
                        'product_id' => $item['product_id'] ?? null, // ใช้ null หากไม่มีการตั้งค่า
                        'quantity' => $item['quantity'] ?? 0, // เริ่มต้นที่ 0 หากไม่มีการตั้งค่า
                        'image' => $item['image'] ?? null, // เพิ่มฟิลด์ image 
                    ];
                });
            });

        // ดึงข้อมูลสินค้าทั้งหมดจาก stock_items
        $allProducts = DB::table('stock_items')->get();

        // กรองสินค้าที่ไม่ได้ถูกขาย
        $unsoldProducts = $allProducts->filter(function ($product) use ($soldProducts) {
            $soldQuantity = $soldProducts->where('product_id', $product->stock_id)
                ->sum('quantity');

            return $soldQuantity == 0; // หากจำนวนที่ขายเป็น 0
        });

        // เตรียมข้อมูลเพื่อส่งไปยัง view
        $groupedItems = $unsoldProducts->map(function ($product) {
            return [
                'product_id' => $product->stock_id, // ใช้ stock_id แทน product_id
                'product_name' => $product->name,
                // 'image' => $product->image ?? 'default.jpg',
                'image' => isset($product->image) ? $product->image : 'default.jpg',
                'quantity' => $product->quantity, // จำนวนที่มีอยู่ใน Stock
            ];
        });

        return view('admin.tables.reportunsold', compact('groupedItems', 'selectedDate'));
    }
}
