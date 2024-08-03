<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function index(){
        $blogs = DB::table('blogs')->get();
 
        return view('blog', compact('blogs'));
    }

    public function create(){
        return view('form');
    }
    
    public function insert(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ],
        [
            'title.required' => 'กรุณากรอกชื่อบทความ',
            'content.required' => 'กรุณากรอกเนื้อหาบทความ'           
        ]);

        $data = [
            'title'=>$request->title,
            'content'=>$request->content
        ];
        
        DB::table('blogs')->insert($data);
        
        return redirect('blog');
    }

    public function delete($id){
    //    dd($id);
        // dd(DB::table('blogs')->where('id',$id)->get());
        DB::table('blogs')->where('id',$id)->delete();
        return redirect('blog');
    }


    public function edit($id){
        $blog = DB::table('blogs')->where('id',$id)->first();
        return view('edit',compact('blog'));
    }

    public function update(Request $request,$id){

     $request->validate([
            'title' => 'required',
            'content' => 'required'
        ], [
            'title.required' => 'กรุณากรอกชื่อบทความ',
            'content.required' => 'กรุณากรอกเนื้อหาบทความ'
        ]);
                
        $data = [
            'title'=>$request->title,
            'content'=>$request->content
        ];
        
        DB::table('blogs')->where('id',$id)->update($data);;
        return redirect('blog');
    }


}
