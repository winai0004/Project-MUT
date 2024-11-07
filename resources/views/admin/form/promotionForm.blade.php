@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5">
    <div class="container">
        <h5 class="text-center">ฟอร์มเพิ่มข้อมูลโปรโมชั่น</h5>

        <div class="row d-flex justify-content-center">
            <div class="col-md-9">
                <div class="form">
                    <form method="post" action="{{ route('insert_promotion') }}" class="mt-5 border p-4 bg-light shadow">
                        @csrf
                        <h4 class="mb-3 text-secondary">เพิ่มข้อมูลลดราคาสินค้าโปรโมชั่น</h4>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label>ชื่อสินค้า <span class="text-danger">*</span></label>
                                <select id="productSelect" name="product_id" class="form-select" aria-label="Default select example">
                                    <option selected>เลือกชื่อสินค้า</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>                                                              
                                @error('product_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                                
                            <div class="mb-3 col-md-12">
                                <label>สินค้าลดราคา (คิดเป็นเปอร์เซนต์)<span class="text-danger">*</span></label>
                                <input type="number" name="discount" class="form-control">
                                @error('discount')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-12">
                                <label>วันที่เริ่มต้นโปรโมชั่น <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                                @error('start_date')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-12">
                                <label>วันที่สิ้นสุดโปรโมชั่น <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                                @error('end_date')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <button class="btn btn-primary float-end" type="submit">บันทึก</button>
                                <a href="{{ route('promotion') }}">
                                    <button class="btn btn-danger float-end me-2" type="button">กลับ</button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
