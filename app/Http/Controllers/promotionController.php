<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class promotionController extends Controller
{
    //
    //
    public function index()
    {
        $promotion = DB::table('promotion_data')
            ->join('products', 'promotion_data.product_id', '=', 'products.product_id')
            ->select('promotion_data.*', 'products.product_name as product_name')
            ->get();

        return view('admin/tables/promotion', compact('promotion'));
    }


    //TODO:: แก้ edit ต่อ

    public function create()
    {

        $stockProductIds = DB::table('promotion_data')->pluck('product_id')->toArray();
     
        $products = DB::table('products')
            ->whereNotIn('product_id',  $stockProductIds)
            ->get();

        return view('admin/form/promotionForm', compact('products'));
    }


    public function insert(Request $request)
    {
        $request->validate([
            'product_id' => 'nullable',
            'discount' => 'nullable'
        ]);

        $data = [
            'product_id' => $request->product_id,
            'discount' => $request->discount
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
        // ดึงข้อมูลโปรโมชันพร้อมชื่อสินค้าที่เกี่ยวข้อง
        $promotion = DB::table('promotion_data')
            ->join('products', 'promotion_data.product_id', '=', 'products.product_id')
            ->select('promotion_data.*', 'products.product_name as product_name') // ดึงข้อมูล promotion_data และชื่อสินค้าจาก stock_items
            ->where('promotion_data.promotion_id', $id)
            ->first();

        // ดึงรายการสินค้าทั้งหมดจาก stock_items สำหรับแสดงใน select box
        $products = DB::table('products')->get();

        return view('admin/form/promotionEdit', compact('promotion', 'products')); // ส่งทั้ง promotion และ stocks ไปที่ view
    }


    public function update(Request $request, $id)
    {

        // dd($id);
        $request->validate([
            'product_id' => 'nullable',
            'discount' => 'nullable'
        ]);

        $data = [
            'product_id' => $request->product_id,
            'discount' => $request->discount
        ];


        DB::table('promotion_data')->where('promotion_id', $id)->update($data);;
        return redirect('admin/tables/promotion');
    }
}
