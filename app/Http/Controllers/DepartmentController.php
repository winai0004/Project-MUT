<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    // แสดงข้อมูลแผนก
    public function index()
    {
        $department = DB::table('department')
            ->join('employee_permission_data', function ($join) {
                $join->on('department.permission_id', 'like', DB::raw('concat("%", employee_permission_data.permission_id, "%")'));
            })
            ->select('department.*', 'employee_permission_data.permission_name')  
            ->get();

        return view('admin/tables/department', compact('department'));
    }

    // ฟอร์มเพิ่มแผนกใหม่
    public function create(){
        $permission = DB::table('employee_permission_data')->get();

        return view('admin/form/departmentForm', compact('permission'));
    }

    // เพิ่มแผนกใหม่
    public function insert(Request $request)
    {
        $request->validate([
            'department_name' => 'required',
            'permission_id' => 'required|array'
        ], [
            'department_name.required' => 'กรุณากรอกแผนก',
            'permission_id.required' => 'กรุณาเลือกสิทธิ์',
            'permission_id.array' => 'สิทธิ์ต้องเป็นอาร์เรย์'
        ]);

        // เก็บ permission_id หลายตัวในรูปแบบ comma-separated string
        $permission_id = implode(',', $request->permission_id);

        $data = [
            'department_name' => $request->department_name,
            'permission_id' => $permission_id  // เก็บ permission_ids หลายตัว
        ];

        DB::table('department')->insert($data);

        return redirect('admin/tables/department');
    }

    // ลบแผนก
    public function delete($id){
        DB::table('department')->where('department_id', $id)->delete();
        return redirect('admin/tables/department');
    }

    // แก้ไขแผนก
    public function edit($id){
        $department = DB::table('department')->where('department_id', $id)->first();
        $permissionIds = explode(',', $department->permission_id); // แปลง permission_ids กลับเป็นอาร์เรย์
        $permission = DB::table('employee_permission_data')->get();

        return view('admin/form/departmentEdit', compact('department', 'permissionIds', 'permission'));
    }

    // อัพเดตแผนก
    public function update(Request $request, $id)
    {
        $request->validate([
            'department_name' => 'required',
            'permission_id' => 'required|array'
        ], [
            'department_name.required' => 'กรุณากรอกแผนก',
            'permission_id.required' => 'กรุณาเลือกสิทธิ์',
            'permission_id.array' => 'สิทธิ์ต้องเป็นอาร์เรย์'
        ]);

        // เก็บ permission_id หลายตัวในรูปแบบ comma-separated string
        $permission_id = implode(',', $request->permission_id);

        $data = [
            'department_name' => $request->department_name,
            'permission_id' => $permission_id  // เก็บ permission_ids หลายตัว
        ];

        DB::table('department')->where('department_id', $id)->update($data);

        return redirect('admin/tables/department');
    }
}
