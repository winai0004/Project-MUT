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
        // รับค่าวันที่ที่เลือกจากแบบฟอร์ม หรือค่าเริ่มต้นเป็นวันที่ปัจจุบัน
        $selectedDate = $request->input('day', Carbon::now()->toDateString()); // ใช้วันที่ปัจจุบันถ้าไม่มีการเลือก

        // ดึงข้อมูลจากตาราง stock_items และกรองตามวันที่ที่เลือกหรือวันที่ปัจจุบัน
        $reports = DB::table('stock_items')
            ->whereDate('created_at', $selectedDate)  // กรองตามวันที่ที่เลือกหรือวันที่ปัจจุบัน
            ->get()
            ->map(function ($stockItem) {
                return [
                    'stock_id' => $stockItem->stock_id,
                    'name' => $stockItem->name,
                    'stock_order' => $stockItem->stock_order,
                    'price' => $stockItem->price,
                    'quantity' => $stockItem->quantity,
                ];
            });

        // จัดกลุ่มตาม stock_id และรวมจำนวน quantity
        $groupedItems = $reports->groupBy('stock_id')
            ->map(function ($group) {
                return [
                    'name' => $group->first()['name'],
                    'total_quantity' => $group->sum('quantity'),
                    'stock_order' => $group->first()['stock_order'],
                    'price' => $group->first()['price'],
                ];
            })
            ->sortByDesc('total_quantity') // เรียงตามจำนวนสินค้าที่สั่งซื้อมากที่สุด
            ->take(5); // จำกัดการแสดงผลที่ 5 รายการ

        // ส่งข้อมูลไปที่ View
        return view('admin.tables.reportstock', compact('groupedItems', 'selectedDate'));
    }
}
