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
        $promotion = DB::table('promotion_data')->get();

        return view('admin/tables/promotion', compact('promotion'))
        ->with('promotion',$promotion->map(function($item) {
            $item->discount_price=number_format($item->discount_price, 2);
            return $item;
        }));
    }
    public function create(){
        return view('admin/form/promotionForm');
    }
    
    public function insert(Request $request)
    {
        $request->validate([
            'promotion_name' => 'required',
            'discount_price' => 'required'
        ],
        [
            'promotion_name.required' => 'กรุณากรอกโปรโมชั่น',
            'discount_price.required' => 'กรุณากรอกลดราคา' 
        ]);

        $data = [
            'promotion_name'=>$request->promotion_name,
            'discount_price'=>$request->discount_price
        ];
        
        DB::table('promotion_data')->insert($data);
        
        return redirect('admin/tables/promotion');
    }
    

    public function delete($id){
        DB::table('promotion_data')->where('promotion_id',$id)->delete();
        return redirect('admin/tables/promotion');
    }


    public function edit($id){
        $promotion = DB::table('promotion_data')->where('promotion_id',$id)->first();
        return view('admin/form/promotionEdit', compact('promotion'));
    }    
    

    public function update(Request $request,$id){

        $request->validate([
            'promotion_name' => 'required',
            'discount_price' => 'required'
        ],
        [
            'promotion_name.required' => 'กรุณากรอกโปรโมชั่น',
            'discount_price.required' => 'กรุณากรอกลดราคา' 
        ]);

        $data = [
            'promotion_name'=>$request->promotion_name,
            'discount_price'=>$request->discount_price
        ];
        
        DB::table('promotion_data')->where('promotion_id',$id)->update($data);;
        return redirect('admin/tables/promotion');
    }
}
