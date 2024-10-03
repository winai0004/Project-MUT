@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5">
    <div class="container">
        <h5 class="text-center">ฟอร์มแก้ไขข้อมูลโปรโมชั่น</h5>

        <div class="row d-flex justify-content-center">
            <div class="col-md-9">
                <div class="form">
                    <form method="post" action="{{ route('update_promotion', $promotion->promotion_id ) }}" class="mt-5 border p-4 bg-light shadow">
                        @csrf
                        @method('PUT')
                        
                        <h4 class="mb-3 text-secondary">แก้ไขข้อมูลลดราคาสินค้าโปรโมชั่น</h4>
                        
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label>ชื่อสินค้า <span class="text-danger">*</span></label>
                                <select id="productSelect" name="stock_id" class="form-select" aria-label="Default select example">
                                    <option selected>เลือกชื่อสินค้า</option>
                                    @foreach($stocks as $stock)
                                        <option value="{{ $stock->stock_id }}" {{ $stock->stock_id == $promotion->stock_id ? 'selected' : '' }}>
                                            {{ $stock->name }}
                                        </option> <!-- แสดงสินค้าที่เลือกแล้ว -->
                                    @endforeach
                                </select>
                                @error('stock_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-12">
                                <label>สินค้าลดราคา (คิดเป็นเปอร์เซนต์) <span class="text-danger">*</span></label>
                                <input type="number" name="discount" class="form-control" value="{{ old('discount', $promotion->discount) }}"> <!-- แสดงส่วนลดที่เลือก -->
                                @error('discount')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-12">
                                <button class="btn btn-primary float-end" type="submit">บันทึก</button>
                                <a href="{{route('promotion')}}"><button class="btn btn-danger float-end me-2" type="button">กลับ</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
