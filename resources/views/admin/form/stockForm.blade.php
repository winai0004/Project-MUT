@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
    <div class="container ">
        <h5 class="text-center">ฟอร์มเพิ่มข้อมูลสต็อกสินค้า</h5>      

        <div class="row d-flex justify-content-center">
            <div class="col-md-9  ">
                <div class="form">
                    <form method="post" action="{{ route('stock_add') }}" class="mt-5 border p-4 bg-light shadow" enctype="multipart/form-data">
                        @csrf
                        <h4 class="mb-3 text-secondary">เพิ่มข้อมูลสินค้า</h4>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label>ชื่อสินค้า<span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control">
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label>ราคาทุน<span class="text-danger">*</span></label>
                                    <input type="number" name="price" class="form-control">
                                    @error('price')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label>จำนวน<span class="text-danger">*</span></label>
                                    <input type="number" name="quantity" class="form-control">
                                    @error('quantity')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label>ชื่อพนักงาน<span class="text-danger">*</span></label>
                                <input type="text" name="employee_name" class="form-control">
                                @error('employee_name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label>วันที่เข้ารับสินค้า<span class="text-danger">*</span></label>
                                    <input type="date" name="date_receiving" class="form-control">
                                    @error('date_receiving')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label>เวลาที่รับสินค้า<span class="text-danger">*</span></label>
                                    <input type="time" name="time_receiving" class="form-control">
                                    @error('time_receiving')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>สถานะสต็อกสินค้า<span class="text-danger">*</span></label>
                                <select class="form-select" name="status" aria-label="Default select example">
                                    <option value="0">Pending</option>
                                    <option value="1">Success</option>
                                    <option value="2">Failed</option>
                                </select>
                                
                            </div>

                           
                            
                            <div class="col-md-12">
                                <button class="btn btn-primary float-end" type="submit">บันทึก</button>
                                <a href="{{ route('stock_items')}}"><button class="btn btn-danger float-end me-2" type="button">กลับ</button></a>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
