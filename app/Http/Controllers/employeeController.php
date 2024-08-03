<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class employeeController extends Controller
{
    //
    public function index()
    {
        $employee = DB::table('employee_data')
        ->join('department', 'employee_data.department_id', '=', 'department.department_id')
        ->select('employee_data.*', 'department.department_name')  
        ->get();

        return view('admin/tables/employee', compact('employee'));
    }

    public function create()
    {
    $department = DB::table('department')->get();

    return view('admin/form/employeeForm', compact('department'));
    }
    // public function create(){
    //     return view('admin/form/employeeForm');
    // }
    
    public function insert(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required', // เพิ่มการตรวจสอบให้ตรงกับชื่อฟิลด์ในฐานข้อมูล
            'username' => 'required',
            'password' => 'required',
            'phone_number' => 'required',
            'department_id' => 'required'
        ],
        [
            'first_name.required' => 'กรุณากรอกชื่อพนักงาน',
            'last_name.required' => 'กรุณากรอกนามสกุลของพนักงาน', // ปรับเปลี่ยนข้อความแจ้งเตือนให้เหมาะสม
            'username.required' => 'กรุณากรอกชื่อผู้ใช้ของพนักงาน',
            'password.required' => 'กรุณากรอกรหัสผ่านของพนักงาน',
            'phone_number.required' => 'กรุณากรอกเบอร์โทรของพนักงาน',
            'department_id.required' => 'กรุณาเลือกแผนก',
        ]);
    
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'password' => $request->password,
            'phone_number' => $request->phone_number,
            'department_id' => $request->department_id
        ];
    
        DB::table('employee_data')->insert($data);
    
        return redirect('admin/tables/employee');
    }
    
    
    public function delete($id){
        DB::table('employee_data')->where('employee_id',$id)->delete();
        return redirect('admin/tables/employee');
    }


    public function edit($id){
        $employee = DB::table('employee_data')->where('employee_id',$id)->first();
        $departmentId = $employee->department_id;
        $department = DB::table('department')->get();
        return view('admin/form/employeeEdit', compact('employee','departmentId','department'));
    }    
    
    public function update(Request $request,$id){

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required', // เพิ่มการตรวจสอบให้ตรงกับชื่อฟิลด์ในฐานข้อมูล
            'username' => 'required',
            'password' => 'required',
            'phone_number' => 'required',
            'department_id' => 'required'
        ],
        [
            'first_name.required' => 'กรุณากรอกชื่อพนักงาน',
            'last_name.required' => 'กรุณากรอกนามสกุลของพนักงาน', // ปรับเปลี่ยนข้อความแจ้งเตือนให้เหมาะสม
            'username.required' => 'กรุณากรอกชื่อผู้ใช้ของพนักงาน',
            'password.required' => 'กรุณากรอกรหัสผ่านของพนักงาน',
            'phone_number.required' => 'กรุณากรอกเบอร์โทรของพนักงาน',
            'department_id.required' => 'กรุณาเลือกแผนก',
        ]);
    
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'password' => $request->password,
            'phone_number' => $request->phone_number,
            'department_id' => $request->department_id
        ];
           
        DB::table('employee_data')->where('employee_id',$id)->update($data);;
        return redirect('admin/tables/employee');
    }
    
}
