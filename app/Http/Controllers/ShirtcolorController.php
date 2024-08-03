<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShirtcolorController extends Controller
{
    //
    public function index()
    {
        $shirtcolor = DB::table('shirt_color')->get();

        return view('admin/tables/shirtcolor', compact('shirtcolor'));
    }
    public function create(){
        return view('admin/form/shirtColorForm');
    }
    
    public function insert(Request $request)
    {
        $request->validate([
            'color_name' => 'required',
        ],
        [
            'color_name.required' => 'กรุณากรอกสีเสื้อ',
        ]);

        $data = [
            'color_name'=>$request->color_name,
        ];
        
        DB::table('shirt_color')->insert($data);
        
        return redirect('admin/tables/shirtcolor');
    }
    

    public function delete($id){
        try{
            DB::table('shirt_color')->where('color_id',$id)->delete();
        } catch (\Exception $e) {
            
            // something went wrong
        }
        
        return redirect('admin/tables/shirtcolor');
    }




    public function edit($id){
        $shirtcolor = DB::table('shirt_color')->where('color_id',$id)->first();
        return view('admin/form/shirtColorEdit', compact('shirtcolor'));
    }    
    

    public function update(Request $request,$id){

     $request->validate([
            'color_name' => 'required',
        ], [
            'color_name.required' => 'กรุณากรอกสีเสื้อ',
        ]);
                
        $data = [
            'color_name'=>$request->color_name,
        ];
        
        DB::table('shirt_color')->where('color_id',$id)->update($data);;
        return redirect('admin/tables/shirtcolor');
    }
}
