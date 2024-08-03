<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class advertController extends Controller
{
    // //
    public function index()
    {
        $advert = DB::table('advertisement_data')->get();

        return view('admin/tables/advert', compact('advert'));
    }

    public function create(){
        return view('admin/form/advertForm');
    }
    
    public function insert(Request $request)
    {

    // dd($request);
    $request->validate([
        'advertisement_name' => 'required',
        'advertisement_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'required'
    ],
    
    [
        'advertisement_name.required' => 'กรุณากรอกชื่อสินค้า',
        'advertisement_image.required' => 'กรุณาเลือกรูปภาพสินค้า',
        'advertisement_image.image' => 'กรุณาเลือกไฟล์ภาพ',
        'description.required' => 'กรุณากรอกราคาทุน'
    ]);
    

    $advertisement_image = $request->file('advertisement_image')->getClientOriginalName();
    $request->file('advertisement_image')->storeAs('public/advert', $advertisement_image);
    
    $data = [
        'advertisement_name' => $request->advertisement_name,
        'advertisement_image' => $advertisement_image, // เก็บชื่อไฟล์ในฐานข้อมูล
        'description' => $request->description
    ];
    
    DB::table('advertisement_data')->insert($data);
    
    return redirect('admin/tables/advert');
    }

    public function delete($id){
        DB::table('advertisement_data')->where('advertisement_id',$id)->delete();
        return redirect('admin/tables/advert');
    }


    public function edit($id){
        $advert = DB::table('advertisement_data')->where('advertisement_id',$id)->first();
        return view('admin/form/advertEdit', compact('advert'));
    }    
    

   public function update(Request $request,$id){

    $request->validate([
        'advertisement_name' => 'required',
        'advertisement_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'required'
    ],
    
    [
        'advertisement_name.required' => 'กรุณากรอกชื่อสินค้า',
        'advertisement_image.required' => 'กรุณาเลือกรูปภาพสินค้า',
        'advertisement_image.image' => 'กรุณาเลือกไฟล์ภาพ',
        'description.required' => 'กรุณากรอกราคาทุน'
    ]);
    

    $data = [
        'advertisement_name' => $request->advertisement_name,
        'advertisement_image' => $advertisement_image, // เก็บชื่อไฟล์ในฐานข้อมูล
        'description' => $request->description
    ];
        
        DB::table('advertisement_data')->where('advertisement_id',$id)->update($data);;
        return redirect('admin/tables/advert');
    }
}


