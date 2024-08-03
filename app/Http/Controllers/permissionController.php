<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class permissionController extends Controller
{

    public function index()
    {
        $permission = DB::table('employee_permission_data')->get();

        return view('admin/tables/permission', compact('permission'));
    }

    public function create(){
        $permission = DB::table('employee_permission_data')->get();

        return view('admin/form/permissionForm',compact('permission'));
    }
    
    public function insert(Request $request)
    {
        $request->validate([
            'permission_name' => 'required',
        ],
        [
            'permission_name.required' => 'กรุณากรอกสิทธิ์',
        ]);

        $data = [
            'permission_name'=>$request->permission_name,
        ];
        
        DB::table('employee_permission_data')->insert($data);
        
        return redirect('admin/tables/permission');
    }
    

    public function delete($id){
        DB::table('employee_permission_data')->where('permission_id',$id)->delete();
        return redirect('admin/tables/permission');
    }


    public function edit($id){
        $permission = DB::table('employee_permission_data')->where('permission_id',$id)->first();
        return view('admin/form/permissionEdit', compact('permission'));
    }    
    
    public function update(Request $request, $id){
        $request->validate([
            'permission_name' => 'required',
        ], [
            'permission_name.required' => 'กรุณากรอกสิทธิ์',
        ]);
                    
        $permission = DB::table('employee_permission_data')->where('permission_id', $id)->first();
    
        if (!$permission) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลสิทธิ์ที่ต้องการอัปเดต');
        }
    
        $data = [
            'permission_name'=>$request->permission_name,
        ];
            
        DB::table('employee_permission_data')->where('permission_id', $id)->update($data);
    
        return redirect()->route('permission')->with('success', 'อัปเดตข้อมูลสิทธิ์เรียบร้อยแล้ว');
    }
    
    // public function update(Request $request,$id){

    //  $request->validate([
    //         'permission_name' => 'required',
    //     ], [
    //         'permission_name.required' => 'กรุณากรอกสิทธิ์',
    //     ]);
                
    //     $data = [
    //         'permission_name'=>$request->permission_name,
    //     ];
        
    //     DB::table('employee_permission_data')->where('permission_id',$id)->update($data);;
    //     return redirect('admin/tables/permission');
    // }
}
