<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    //
    public function index()
    {
        $department = DB::table('department')
        ->join('employee_permission_data', 'department.permission_id', '=', 'employee_permission_data.permission_id')
        ->select('department.*', 'employee_permission_data.permission_name')  
        ->get();

        return view('admin/tables/department', compact('department'));
    }
    public function create(){
        $permission = DB::table('employee_permission_data')->get();

        return view('admin/form/departmentForm', compact('permission'));
    }
    
    public function insert(Request $request)
    {
        $request->validate([
            'department_name' => 'required',
            'permission_id' => 'required'
        ],
        [
            'department_name.required' => 'กรุณากรอกแผนก',
            'permission_id.required' => 'กรุณาเลือกสิทธิ์'
        ]);

        $data = [
            'department_name'=>$request->department_name,
            'permission_id' => $request->permission_id
        ];
        
        DB::table('department')->insert($data);
        
        return redirect('admin/tables/department');
    }
    

    public function delete($id){
        DB::table('department')->where('department_id',$id)->delete();
        return redirect('admin/tables/department');
    }


    public function edit($id){
        $department = DB::table('department')->where('department_id',$id)->first();
        $permissionId = $department->permission_id;
        $permission = DB::table('employee_permission_data')->get();
        return view('admin/form/departmentEdit', compact('department','permissionId','permission'));
    }    
    

    public function update(Request $request,$id){

     $request->validate([
            'department_name' => 'required',
            'permission_id' => 'required'
        ], [
            'department_name.required' => 'กรุณากรอกแผนก',
            'permission_id.required' => 'กรุณาเลือกสิทธิ์'
        ]);
                
        $data = [
            'department_name'=>$request->department_name,
            'permission_id' => $request->permission_id
        ];
        
        DB::table('department')->where('department_id',$id)->update($data);;
        return redirect('admin/tables/department');
    }
}
