<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShirtSizeController extends Controller
{
    //
    public function index()
    {
        $shirtsize = DB::table('shirt_size_data')->get();

        return view('admin/tables/shirtsize', compact('shirtsize'));
    }
    public function create(){
        return view('admin/form/shirtSizeForm');
    }
    
    public function insert(Request $request)
    {
        $request->validate([
            'size_name' => 'required',
        ],
        [
            'size_name.required' => 'กรุณากรอกไซส์เสื้อ',
        ]);

        $data = [
            'size_name'=>$request->size_name,
        ];
        
        DB::table('shirt_size_data')->insert($data);
        
        return redirect('admin/tables/shirtsize');
    }
    

    public function delete($id){
        
        try{
            DB::table('shirt_size_data')->where('size_id',$id)->delete();
        } catch (\Exception $e) {
            
            // something went wrong
        }
        return redirect('admin/tables/shirtsize');
    }


    public function edit($id){
        $shirtsize = DB::table('shirt_size_data')->where('size_id',$id)->first();
        return view('admin/form/shirtSizeEdit', compact('shirtsize'));
    }    
    

    public function update(Request $request,$id){

     $request->validate([
            'size_name' => 'required',
        ], [
            'size_name.required' => 'กรุณากรอกไซส์สื้อ',
        ]);
                
        $data = [
            'size_name'=>$request->size_name,
        ];
        
        DB::table('shirt_size_data')->where('size_id',$id)->update($data);;
        return redirect('admin/tables/shirtsize');
    }
}
