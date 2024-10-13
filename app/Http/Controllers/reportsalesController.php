<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class ReportSalesController extends Controller
{
    //
    public function index(Request $request)
{
    // Get the selected date from the form or default to the current date
    $selectedDate = $request->input('day', Carbon::now()->toDateString()); // Use current date if none selected

    // Filter reports by selected or current date
    $reports = DB::table('order_shopping')
        ->whereDate('created_at', $selectedDate)  // Filter by the selected date or current date
        ->get()
        ->flatMap(function ($report) {
            $orderItems = collect(json_decode($report->order_items, true));
            return $orderItems->map(function ($item) {
                return [
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'image' => $item['image'], // เพิ่มฟิลด์ image ที่นี่
                ];
            });
        });

    // Group by product_id and sum the quantity
    $groupedItems = $reports->groupBy('product_id')
        ->map(function ($group) {
            return [
                'product_name' => $group->first()['product_name'],
                'total_quantity' => $group->sum('quantity'),
                'image' => $group->first()['image'], // ดึงฟิลด์ image
            ];
        })
        ->sortByDesc('total_quantity') 
        ->take(5); 

    return view('admin.tables.report', compact('groupedItems', 'selectedDate'));
}

}

