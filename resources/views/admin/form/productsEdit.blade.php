@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
    <div class="container ">
    <h5 class="text-center">ฟอร์มแก้ไขข้อมูลสินค้า</h5>
    <div class="row d-flex justify-content-center">
        <div class="col-md-9  ">
            <div class="form">
                <form method="post" action="{{route('update_products',$products->product_id)}}" class="mt-5 border p-4 bg-light shadow" enctype="multipart/form-data">
                @csrf
                    <h4 class="mb-3 text-secondary">แก้ไขข้อมูลสินค้า</h4>
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label>ชื่อสินค้า<span class="text-danger">*</span></label>
                            <input type="text" name="product_name" class="form-control" value="{{ $products->product_name}}" >
                            @error('product_name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label>ราคาทุน<span class="text-danger">*</span></label>
                                <input type="number" name="cost_price" class="form-control" value="{{ $products->cost_price}}" >
                                @error('cost_price')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label>ราคาขาย<span class="text-danger">*</span></label>
                                <input type="number" name="selling_price" class="form-control" value="{{ $products->selling_price}}">
                                @error('selling_price')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label>ประเภท<span class="text-danger">*</span></label>
                              
                            <select name="category_id" class="form-select" aria-label="Default select example">
                                 <option selected disabled>เลือกประเภทสินค้า</option>
                                   @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}" @if($category->category_id == $productCategoryID) selected @endif>{{ $category->category_name }}</option>
                                  @endforeach
                            </select>
                                                                    
                                @error('category_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="mb-3 col-md-6">
                                <label>ประเภท<span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select" aria-label="Default select example">
                                    <option selected>เลือกประเภทสินค้า</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>                                                              
                                @error('category_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                        </div> --}}
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label>ไซส์<span class="text-danger">*</span></label>
                                <select name="size_id" class="form-select" aria-label="Default select example">
                                    <option selected disabled>เลือกไซส์</option>
                                      @foreach($sizes as $size)
                                       <option value="{{ $size->size_id }}" @if($size->size_id == $sizeId) selected @endif>{{ $size->size_name }}</option>
                                     @endforeach
                               </select>                           
                                @error('size_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                        </div>
                            <div class="mb-3 col-md-6">
                                <label>สี<span class="text-danger">*</span></label>
                                <select name="color_id" class="form-select" aria-label="Default select example">
                                    <option selected disabled>เลือกสี</option>
                                      @foreach($colors as $color)
                                       <option value="{{ $color->color_id }}" @if($color->color_id == $colorId) selected @endif>{{ $color->color_name }}</option>
                                     @endforeach
                               </select>
                                @error('color_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3 col-md-12">
                            <label>เปลี่ยนรูปภาพ<span class="text-danger">*</span></label>
                            <input type="file" name="product_img" class="form-control">
                            @error('product_img')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                           <button class="btn btn-primary float-end" type="submit" >บันทึก</button>
                            <a href="{{route('products')}}"><button class="btn btn-danger float-end me-2" type="button">กลับ</button></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 
</div>

@endsection
