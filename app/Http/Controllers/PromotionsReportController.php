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
                    ];
                });
            });
    
        // ดึงข้อมูลโปรโมชั่น
        $promotions = DB::table('promotion_data')->get();
    
        // สร้างกลุ่มของข้อมูลสินค้า
        $groupedItems = $promotions->map(function ($promotion) {
            // ดึงชื่อสินค้าจากตาราง products
            $product = DB::table('products')->where('product_id', $promotion->product_id)->first();
    
            return [
                'product_id' => $product ? $product->product_id : null,
                'product_name' => $product ? $product->product_name : 'ไม่พบสินค้า',
                'discount' => $promotion->discount,
            ];
        });
    
        // ส่งข้อมูลไปยัง view
        return view('admin.tables.promotionsreport', compact('groupedItems', 'selectedDate'));
    }
}
