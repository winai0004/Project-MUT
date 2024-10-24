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
                                <select name="product_id" id="productSelect" class="form-select" aria-label="Default select example">
                                    <option selected disabled>เลือกชื่อสินค้า</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->product_id }}" data-price="{{ $product->cost_price }}">
                                            {{ $product->product_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </select>
                            </div>
                            
                            
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label>ราคาทุน<span class="text-danger">*</span></label>
                                    <input type="text" id="cost_price" name="cost_price" class="form-control" readonly>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label>จำนวน<span class="text-danger">*</span></label>
                                    <input type="number" name="quantity" class="form-control">
                                    @error('quantity')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
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


<script>
    $(document).ready(function() {
        $('#productSelect').on('change', function() {
            // Get selected product price
            var costPrice = $(this).find('option:selected').data('price');
            
            // Update the cost price field
            $('#cost_price').val(costPrice);
        });
    });
</script>

@endsection


