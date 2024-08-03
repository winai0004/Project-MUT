<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MembershiplevelController extends Controller
{
    
    public function index()
    {
        $membershiplevel = DB::table('membership_level_data')->get();

        return view('admin/tables/membershiplevel', compact('membershiplevel'));
    }

    public function create()
    {
    $membershiplevel = DB::table('membership_level_data')->get();

    return view('admin/form/membershiplevelForm', compact('membershiplevel'));
    }

    public function insert(Request $request)
    {
        // dd($request);
        $request->validate([
            'membership_level_name' => 'required',
            'minscore' => 'required',
            'maxscore' => 'required'
        ],
        [
            'membership_level_name.required' => 'กรุณากรอกชื่อระดับสมาชิก',
            'minscore.required' => 'กรุณากรอกระดับคะแนนเริ่มต้น',
            'maxscore.required' => 'กรุณากรอกระดับคะแนนสูงสุุด'
        ]);
    
        $data = [
            'membership_level_name' => $request->membership_level_name,
            'minscore' => $request->minscore,
            'maxscore' => $request->maxscore
        ];
    
        DB::table('membership_level_data')->insert($data);
    
        return redirect('admin/tables/membershiplevel');
    }

    
    public function delete($id){
        DB::table('membership_level_data')->where('membership_level_id',$id)->delete();
        return redirect('admin/tables/membershiplevel');
    }


    public function edit($id){
        $membershiplevel = DB::table('membership_level_data')->where('membership_level_id',$id)->first();
        return view('admin/form/membershiplevelEdit', compact('membershiplevel'));
    }    
    

    public function update(Request $request, $id){
        $request->validate([
            'membership_level_name' => 'required',
            'minscore' => 'required',
            'maxscore' => 'required'
        ], [
            'membership_level_name.required' => 'กรุณากรอกระดับสมาชิก',
            'minscore.required' => 'กรุณากรอกระดับคะแนนเริ่มต้น',
            'maxscore.required' => 'กรุณากรอกระดับคะแนนสูงสุด'
        ]);
                    
        $membershiplevel = DB::table('membership_level_data')->where('membership_level_id', $id)->first();
    
        if (!$membershiplevel) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลสิทธิ์ที่ต้องการอัปเดต');
        }
    
        $data = [
            'membership_level_name'=>$request->membership_level_name,
            'minscore' => $request->minscore,
            'maxscore' => $request->maxscore
        ];
            
        DB::table('membership_level_data')->where('membership_level_id', $id)->update($data);
    
        return redirect()->route('membershiplevel')->with('success', 'อัปเดตข้อมูลสิทธิ์เรียบร้อยแล้ว');
    }
}
