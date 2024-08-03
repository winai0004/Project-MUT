@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
    <div class="container ">
    <h5 class="text-center">ฟอร์มเพิ่มข้อมูลโปรชั่น</h5>

    <div class="row d-flex justify-content-center">
        <div class="col-md-9  ">
            <div class="form">
                <form method="post" action="{{ route('insert_promotion') }}" class="mt-5 border p-4 bg-light shadow">
                @csrf
                    <h4 class="mb-3 text-secondary">เพิ่มข้อมูลโปรชั่น</h4>
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label>โปรโมชั่น<span class="text-danger">*</span></label>
                            <input type="text" name="promotion_name" class="form-control" >
                        </div>
                        @error('title')
                            <div class="mb-1">
                                <span class="text-danger">{{$message}}</span>
                            </div>
                        @enderror
                        <div class="mb-3 col-md-6">
                            <label>ลดราคา<span class="text-danger">*</span></label>
                            <input type="number" name="discount_price" class="form-control">
                            @error('discount_price')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary float-end" type="submit" >บันทึก</button>
                             <a href="{{route('promotion')}}"><button class="btn btn-danger float-end me-2" type="button">กลับ</button></a>
                         </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 
</div>



@endsection

