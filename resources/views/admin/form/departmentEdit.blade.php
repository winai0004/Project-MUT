@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
    <div class="container ">
    <h5 class="text-center">ฟอร์มเพิ่มข้อมูลแผนก</h5>
    <div class="row d-flex justify-content-center">
        <div class="col-md-9  ">
            <div class="form">
                <form method="post" action="{{route('update_department',$department->department_id)}}" class="mt-5 border p-4 bg-light shadow">
                @csrf
                    <h4 class="mb-3 text-secondary">แก้ไขข้อมูลแผนก</h4>
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label>แผนก<span class="text-danger">*</span></label>
                            <input type="text" name="department_name" class="form-control" value="{{$department->department_name}}" >
                        </div>
                        @error('title')
                            <div class="mb-1">
                                <span class="text-danger">{{$message}}</span>
                            </div>
                        @enderror
                        
                        <!-- ส่วนสำหรับรับข้อมูลสิทธิ์ -->
                        <div id="rights">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label>สิทธิ์<span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        @foreach($permission as $item)
                                            <input type="checkbox" name="permission_id[]" value="{{ $item->permission_id }}" class="form-check-input" id="permission-{{ $item->permission_id }}">
                                            <label class="form-check-label" for="permission-{{ $item->permission_id }}">{{ $item->permission_name }}</label>
                                            <br>
                                        @endforeach
                                    </div>
                                    @error('permission_id')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                           <button class="btn btn-primary float-end" type="submit" >บันทึก</button>
                           <button class="btn btn-secondary float-end me-2" type="button" onclick="addRight()">เพิ่มสิทธิ์</button>
                            <a href="{{route('department')}}"><button class="btn btn-danger float-end me-2" type="button">กลับ</button></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 
</div>



@endsection

