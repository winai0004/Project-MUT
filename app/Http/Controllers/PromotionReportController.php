<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PromotionReportController extends Controller
{
    public function index(Request $request)
    {
        // รับค่าวันที่เริ่มต้นและวันที่สิ้นสุดจากแบบฟอร์ม
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        // ตรวจสอบว่า table promotion_data มีคอลัมน์ status หรือไม่
        $columns = DB::getSchemaBuilder()->getColumnListing('promotion_data');
        if (!in_array('status', $columns)) {
            return redirect()->back()->withErrors(['status' => 'Column "status" not found in promotion_data table.']);
        }

        // ดึงข้อมูลโปรโมชั่นที่ใช้งานอยู่
        $promotions = DB::table('promotion_data')
            ->where('status', 1) // ใช้เฉพาะโปรโมชั่นที่ใช้งานอยู่
            ->get();

        // ดึงข้อมูลยอดขายที่เกี่ยวข้องกับโปรโมชั่นในช่วงวันที่เลือก
        $sales = DB::table('order_shopping')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->flatMap(function ($order) {
                $orderItems = collect(json_decode($order->order_items, true));
                return $orderItems->map(function ($item) {
                    return [
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'promotion_id' => $item['promotion_id'] ?? null, // เพิ่ม promotion_id ถ้ามี
                    ];
                });
            });

        // สรุปยอดขายตามโปรโมชั่น
        $promotionSummary = $sales->groupBy('promotion_id')->map(function ($group, $promotionId) {
            return [
                'promotion_id' => $promotionId,
                'total_quantity' => $group->sum('quantity'),
            ];
        });

        // เตรียมข้อมูลเพื่อส่งไปยัง view
        return view('admin.tables.reportpromotion', compact('promotions', 'promotionSummary', 'startDate', 'endDate'));
    }
}
