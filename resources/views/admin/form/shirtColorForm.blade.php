@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
    <div class="container ">
    <h5 class="text-center">ฟอร์มเพิ่มข้อมูลสี</h5>

    <div class="row d-flex justify-content-center">
        <div class="col-md-9  ">
            <div class="form">
                <form method="post" action="{{ route('insert_shirtcolor') }}" class="mt-5 border p-4 bg-light shadow">
                @csrf
                    <h4 class="mb-3 text-secondary">เพิ่มข้อมูลสี</h4>
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label>สีเสื้อ<span class="text-danger">*</span></label>
                            <input type="text" name="color_name" class="form-control" >
                        </div>
                        @error('title')
                            <div class="mb-1">
                                <span class="text-danger">{{$message}}</span>
                            </div>
                        @enderror
                        <div class="col-md-12">
                           <button class="btn btn-primary float-end" type="submit" >บันทึก</button>
                            <a href="{{route('shirtcolor')}}"><button class="btn btn-danger float-end me-2" type="button">กลับ</button></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 
</div>



@endsection
