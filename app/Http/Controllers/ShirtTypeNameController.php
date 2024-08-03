<?php

// namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;   // copy ส่วนนี้ไปใช้ทุกไฟล์ของ controller


// class ShirtTypeNameController extends Controller
// {
//     //
//     public function index(){
//         $shirts = DB::table('product_category_data')->get();
 
//         return view('admin/tables/shirtTypeName', compact('shirts'));
//     }

//     public function create(){
//         return view('admin/form/shirtTypeNameForm');
//     }
    
//     public function insert(Request $request)
//     {
//         $request->validate([
//             'category_name' => 'required',
//         ],
//         [
//             'category_name.required' => 'กรุณากรอกประเภทชุด',
//         ]);

//         $data = [
//             'category_name'=>$request->category_name,
//         ];
        
//         DB::table('product_category_data')->insert($data);
        
//         return redirect('admin/tables/shirtTypeName');
//     }

//     public function delete($id){
//     //    dd($id);
//         // dd(DB::table('shirt_type_names')->where('ShirtType_ID',$id)->get());
//         DB::table('product_category_data')->where('	category_id',$id)->delete();
//         return redirect('admin/tables/shirtTypeName');
//     }


//     public function edit($id){
//         $shirt = DB::table('product_category_data')->where('category_id',$id)->first();
//         return view('admin/form/shirtTypeNameEdit',compact('shirt'));
//     }

//     public function update(Request $request,$id){

//      $request->validate([
//             'category_name' => 'required',
//         ], [
//             'category_name.required' => 'กรุณากรอกประเภทชุด',
//         ]);
                
//         $data = [
//             'category_name'=>$request->category_name,
//         ];
        
//         DB::table('product_category_data')->where('category_id',$id)->update($data);;
//         return redirect('admin/tables/shirtTypeName');
//     }
// }


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShirtTypeNameController extends Controller
{
    //
    public function index(){
        $shirts = DB::table('product_category_data')->get();
        return view('admin/tables/shirtTypeName', compact('shirts'));
    }

    public function create(){
        return view('admin/form/shirtTypeNameForm');
    }
    
    public function insert(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ], [
            'category_name.required' => 'กรุณากรอกประเภทชุด',
        ]);

        $data = [
            'category_name' => $request->category_name,
        ];
        
        DB::table('product_category_data')->insert($data);
        
        return redirect('admin/tables/shirtTypeName');
    }

    public function delete($id){

        try{
            DB::table('product_category_data')->where('category_id', $id)->delete();
        } catch (\Exception $e) {
            
            // something went wrong
        }
        // อัปเดต category_id เป็น null ในตาราง products ก่อนลบ
        // DB::table('products')->where('category_id', $id)->update(['category_id' => null]);
        // ลบข้อมูลจากตาราง product_category_data
        
        return redirect('admin/tables/shirtTypeName');
    }

    public function edit($id){
        $shirt = DB::table('product_category_data')->where('category_id', $id)->first();
        return view('admin/form/shirtTypeNameEdit', compact('shirt'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'category_name' => 'required',
        ], [
            'category_name.required' => 'กรุณากรอกประเภทชุด',
        ]);
                
        $data = [
            'category_name' => $request->category_name,
        ];
        
        DB::table('product_category_data')->where('category_id', $id)->update($data);
        return redirect('admin/tables/shirtTypeName');
    }
}
