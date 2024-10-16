@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
    <div class="container ">
        <h5 class="text-center">ฟอร์มเพิ่มข้อมูลสินค้า</h5>      

        <div class="row d-flex justify-content-center">
            <div class="col-md-9  ">
                <div class="form">
                    <form method="post" action="{{ route('insert_products') }}" class="mt-5 border p-4 bg-light shadow" enctype="multipart/form-data">
                        @csrf
                        <h4 class="mb-3 text-secondary">เพิ่มข้อมูลสินค้า</h4>
                        <div class="row">

                            <div class="mb-3 col-md-12">
                                <label>ชื่อสินค้า <span class="text-danger">*</span></label>
                                <select id="productSelect" name="stock_id" class="form-select" aria-label="Default select example">
                                    <option selected>เลือกชื่อสินค้า</option>
                                    @foreach($stocks as $stock)
                                        <option value="{{ $stock->stock_id }}">{{ $stock->name }}</option> <!-- ใช้ stock_id แทน id -->
                                    @endforeach
                                </select>                                                              
                                @error('product_name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>


                            
                            <div class="row">
                               <div class="mb-3 col-md-6">
                                    <label>ราคาทุน <span class="text-danger">*</span></label>
                                    <select id="priceSelect" name="cost_price" class="form-select">
                                        <option selected>เลือกราคาทุน</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label>ราคาขาย<span class="text-danger">*</span></label>
                                    <input type="number" name="selling_price" class="form-control">
                                    @error('selling_price')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label>ประเภท<span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-select" aria-label="Default select example">
                                        <option selected>เลือกประเภทสินค้า</option>
                                        @foreach($categories as $category)
                                            {{-- <option value="{{ $category->category_id }}" @if($category->category_id == $products->category_id) selected @endif>{{ $category->category_name }}</option> --}}
                                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>                                                              
                                    @error('category_id')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                           
                            
                            <div class="mb-3 col-md-12">
                                <label>รูปสินค้า<span class="text-danger">*</span></label>
                                <input type="file" name="product_img" class="form-control">
                                @error('product_img')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-12">
                                <button class="btn btn-primary float-end" type="submit">บันทึก</button>
                                <a href="{{route('products')}}"><button class="btn btn-danger float-end me-2" type="button">กลับ</button></a>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('#productSelect').change(function() {
        var productId = $(this).val(); // ดึง stock_id ของสินค้าที่เลือก

        if(productId) {
            $.ajax({
                url: '/get-product-price/' + productId, // เรียกใช้ route เพื่อติดต่อ controller
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#priceSelect').empty(); 

                    if (data.price) {
                        var formattedPrice = parseFloat(data.price).toFixed(2); // แปลง int เป็น double (2 ตำแหน่งทศนิยม)

                        $('#priceSelect').append('<option value="' + formattedPrice + '">' + formattedPrice + '</option>');
                    } else {
                        $('#priceSelect').append('<option selected>ไม่พบข้อมูลราคา</option>');
                    }
                },
                error: function() {
                    $('#priceSelect').empty(); // กรณีเกิดข้อผิดพลาด
                    $('#priceSelect').append('<option selected>ไม่พบข้อมูลราคา</option>');
                }
            });
        } else {
            $('#priceSelect').empty();
            $('#priceSelect').append('<option selected>เลือกราคาทุน</option>');
        }
    });
});


</script>

@endsection


