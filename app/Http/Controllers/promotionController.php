<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PromotionController extends Controller
{
    public function index()
    {
        $currentDate = Carbon::now();
        $promotions = DB::table('promotion_data')
            ->join('products', 'promotion_data.product_id', '=', 'products.product_id')
            ->select('promotion_data.*', 'products.product_name as product_name')
            ->where('promotion_data.start_date', '<=', $currentDate)
            ->where('promotion_data.end_date', '>=', $currentDate)
            ->get();
    
        return view('admin/tables/promotion', compact('promotions'));  // ใช้ตัวแปร $promotions
    }
    

    public function create()
    {
        $stockProductIds = DB::table('promotion_data')->pluck('product_id')->toArray();
        $products = DB::table('products')
            ->whereNotIn('product_id', $stockProductIds)
            ->get();

        return view('admin/form/promotionForm', compact('products'));
    }

    public function insert(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'discount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $data = [
            'product_id' => $request->product_id,
            'discount' => $request->discount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ];

        DB::table('promotion_data')->insert($data);

        return redirect('admin/tables/promotion');
    }

    public function delete($id)
    {
        DB::table('promotion_data')->where('promotion_id', $id)->delete();
        return redirect('admin/tables/promotion');
    }

    public function edit($id)
    {
        $promotion = DB::table('promotion_data')
            ->join('products', 'promotion_data.product_id', '=', 'products.product_id')
            ->select('promotion_data.*', 'products.product_name as product_name')
            ->where('promotion_data.promotion_id', $id)
            ->first();

        $products = DB::table('products')->get();

        return view('admin/form/promotionEdit', compact('promotion', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required',
            'discount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $data = [
            'product_id' => $request->product_id,
            'discount' => $request->discount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ];

        DB::table('promotion_data')->where('promotion_id', $id)->update($data);
        return redirect('admin/tables/promotion');
    }
}
