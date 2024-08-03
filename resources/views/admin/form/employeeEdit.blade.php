@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5">
    <div class="container">
        <h5 class="text-center">ฟอร์มแก้ไขข้อมูลพนักงาน</h5>
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="form">
                    <form method="post" action="{{ route('update_employee', $employee->employee_id) }}" class="mt-5 border p-4 bg-light shadow">
                        @csrf
                        <h4 class="mb-3 text-secondary">แก้ไขข้อมูลพนักงาน</h4>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label>ชื่อ<span class="text-danger">*</span></label>
                                <input type="text" name="first_name" class="form-control" value="{{ $employee->first_name }}">
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label>นามสกุล<span class="text-danger">*</span></label>
                                <input type="text" name="last_name" class="form-control" value="{{ $employee->last_name }}">
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label>ชื่อผู้ใช้งาน<span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control" value="{{ $employee->username }}">
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label>รหัสผ่านผู้ใช้งาน<span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" value="{{ $employee->password }}">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label>เบอร์โทร<span class="text-danger">*</span></label>
                                <input type="text" name="phone_number" class="form-control" value="{{ $employee->phone_number }}">
                                @error('phone_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label>แผนก<span class="text-danger">*</span></label>
                                <select name="department_id" class="form-select" aria-label="Default select example">
                                    <option selected disabled>เลือกแผนก</option>
                                    @foreach($department as $departments)
                                       <option value="{{ $departments->department_id }}" @if($departments->department_id == $departmentId) selected @endif>{{ $departments->department_name }}
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                               <button class="btn btn-primary float-end" type="submit">บันทึก</button>
                               <a href="{{ route('employee') }}"><button class="btn btn-danger float-end me-2" type="button">กลับ</button></a>
                           </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
