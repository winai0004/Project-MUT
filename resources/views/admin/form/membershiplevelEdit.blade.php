@extends('layouts_admin.app_admin')

 @section('content')
 
 <div class="container px-5 my-5 ">
     <div class="container ">
         <h5 class="text-center">ฟอร์มแก้ไขข้อมูลระดับสมาชิก</h5>
         <div class="row d-flex justify-content-center">
             <div class="col-md-9  ">
                 <div class="form">
                     <form method="post" action="{{route('update_membershiplevel',$membershiplevel->membership_level_id)}}" class="mt-5 border p-4 bg-light shadow">
                         @csrf
                         <h4 class="mb-3 text-secondary">แก้ไขข้อมูลระดับสมาชิก</h4>
                         <div class="row">
                             <div class="mb-3 col-md-12">
                                 <label>ชื่อระดับสมาชิก<span class="text-danger">*</span></label>
                                 <input type="text" name="membership_level_name" class="form-control" value="{{$membershiplevel->membership_level_name}}" >
                                 @error('membership_level_name')
                                     <span class="text-danger">{{$message}}</span>
                                 @enderror
                             </div>
                         </div>
                         <div class="row">
                             <div class="mb-3 col-md-6">
                                 <label>คะแนนเริ่มต้น<span class="text-danger">*</span></label>
                                 <input type="number" name="minscore" class="form-control" value="{{ $membershiplevel->minscore }}">
                                 @error('minscore')
                                     <span class="text-danger">{{$message}}</span>
                                 @enderror
                             </div>
                             <div class="mb-3 col-md-6">
                                 <label>คะแนนสูงสุด<span class="text-danger">*</span></label>
                                 <input type="number" name="maxscore" class="form-control" value="{{ $membershiplevel->maxscore }}">
                                 @error('maxscore')
                                     <span class="text-danger">{{$message}}</span>
                                 @enderror
                             </div>

                             <div class="col-md-12">
                                <button class="btn btn-primary float-end" type="submit" >บันทึก</button>
                                <a href="{{route('membershiplevel')}}"><button class="btn btn-danger float-end me-2" type="button">กลับ</button></a>
                            </div>
                         </div>

                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>
 @endsection
 