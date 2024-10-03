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
        // ดึงข้อมูลจากตาราง promotion_data พร้อมเชื่อมกับ stock_items โดยใช้ stock_id
        $promotion = DB::table('promotion_data')
        ->join('stock_items', 'promotion_data.stock_id', '=', 'stock_items.stock_id') // เชื่อมด้วย stock_id
        ->select('promotion_data.*', 'stock_items.name as stock_name') // ดึงข้อมูลจาก promotion_data และชื่อ stock
        ->get();
    
        return view('admin/tables/promotion', compact('promotion'));
    }
    

    public function create(){
        $stocks = DB::table('stock_items')->get();

        
        return view('admin/form/promotionForm',compact('stocks'));
    }
    
    public function insert(Request $request)
    {
        $request->validate([
            'stock_id' => 'nullable',
            'discount' => 'nullable'
        ]);

        $data = [
            'stock_id'=>$request->stock_id,
            'discount'=>$request->discount
        ];
        
        DB::table('promotion_data')->insert($data);
        
        return redirect('admin/tables/promotion');
    }
    

    public function delete($id){
        DB::table('promotion_data')->where('promotion_id',$id)->delete();
        return redirect('admin/tables/promotion');
    }


    public function edit($id) {
        // ดึงข้อมูลโปรโมชันพร้อมชื่อสินค้าที่เกี่ยวข้อง
        $promotion = DB::table('promotion_data')
            ->join('stock_items', 'promotion_data.stock_id', '=', 'stock_items.stock_id') // เชื่อมด้วย stock_id
            ->select('promotion_data.*', 'stock_items.name as stock_name') // ดึงข้อมูล promotion_data และชื่อสินค้าจาก stock_items
            ->where('promotion_data.promotion_id', $id)
            ->first();
    
        // ดึงรายการสินค้าทั้งหมดจาก stock_items สำหรับแสดงใน select box
        $stocks = DB::table('stock_items')->get();
    
        return view('admin/form/promotionEdit', compact('promotion', 'stocks')); // ส่งทั้ง promotion และ stocks ไปที่ view
    }
    

    public function update(Request $request,$id){

        $request->validate([
            'stock_id' => 'nullable',
            'discount' => 'nullable'
        ]);

        $data = [
            'stock_id'=>$request->stock_id,
            'discount'=>$request->discount
        ];
        
        
        DB::table('promotion_data')->where('promotion_id',$id)->update($data);;
        return redirect('admin/tables/promotion');
    }
}
