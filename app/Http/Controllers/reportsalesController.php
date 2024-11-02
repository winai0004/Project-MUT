<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportSalesController extends Controller
{
    public function index(Request $request)
    {
<<<<<<< HEAD
        // Get the selected date from the form or default to the current date
        $selectedDate = $request->input('day', Carbon::now()->toDateString()); // Use current date if none selected
    
        // Fetch grouped data based on the selected date
        $topSellingItems = DB::table('order_shop_detail')
            ->select('name', DB::raw('SUM(total_quantity) as total_quantity'), DB::raw('MIN(image) as image')) // ดึงรูปภาพด้วย
            ->whereDate('created_at', $selectedDate) 
            ->groupBy('name') 
            ->orderBy('total_quantity', 'desc') 
            ->take(5) 
            ->get();
    
        return view('admin.tables.report', compact('topSellingItems', 'selectedDate'));
    }
    
    

}

=======
        // รับค่า start_date และ end_date จาก form หรือใช้ค่าวันปัจจุบันเป็นค่าเริ่มต้น
        $startDate = $request->input('start_date', Carbon::now()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());
        $selectedCategory = $request->input('category_id'); // รับค่า category_id ที่ถูกเลือกจาก form

        $categories = DB::table('product_category_data')->select('category_id', 'category_name')->get();

        // ดึงข้อมูลคำสั่งซื้อที่อยู่ในช่วงวันที่ที่เลือก
        $reports = DB::table('order_shopping')
            ->whereBetween('order_shopping.created_at', [$startDate, $endDate])
            ->get()
            ->flatMap(function ($report) {
                $orderItems = collect(json_decode($report->order_items, true));

                // ดึงข้อมูลจากตาราง products เพื่อให้ได้ product_name และ category_id ที่ถูกต้อง
                return $orderItems->map(function ($item) {
                    $product = DB::table('products')->where('product_id', $item['product_id'])->first();
                    return [
                        'product_id' => $item['product_id'],
                        'product_name' => $product ? $product->product_name : 'Unknown',
                        'quantity' => $item['quantity'],
                        'image' => $item['image'],
                        'category_id' => $product ? $product->category_id : null, // ดึง category_id จากตาราง products
                    ];
                });
            });

        // กรองตาม category ที่ถูกเลือก
        if ($selectedCategory) {
            $reports = $reports->filter(function ($item) use ($selectedCategory) {
                return $item['category_id'] == $selectedCategory;
            });
        }

        // รวมข้อมูลตาม product_id และคำนวณผลรวมของ quantity
        $groupedItems = $reports->groupBy('product_id')
            ->map(function ($group) {
                return [
                    'product_name' => $group->first()['product_name'],
                    'total_quantity' => $group->sum('quantity'),
                    'image' => $group->first()['image'],
                ];
            })
            ->sortByDesc('total_quantity')
            ->take(5);

        return view('admin.tables.report', compact('groupedItems', 'startDate', 'endDate', 'categories', 'selectedCategory'));
    }
}
>>>>>>> 0f3ab96d29a8836b962947b892e48a04285e2fc9
