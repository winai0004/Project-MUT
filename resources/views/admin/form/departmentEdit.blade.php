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
                        
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label>สิทธิ์<span class="text-danger">*</span></label>
                              
                            <select name="permission_id" class="form-select" aria-label="Default select example">
                                 <option selected disabled>เลือกสิทธิ์</option>
                                   @foreach($permission as $permission)
                                    <option value="{{ $permission->permission_id }}" @if($permission->permission_id == $permissionId) selected @endif>{{ $permission->permission_name }}</option>
                                  @endforeach
                            </select>
                                                                    
                                @error('permission_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                           <button class="btn btn-primary float-end" type="submit" >บันทึก</button>
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

