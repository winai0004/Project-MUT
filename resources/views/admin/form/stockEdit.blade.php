@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5">
    <div class="container">
        <h5 class="text-center">ฟอร์มแก้ไขข้อมูลสต็อกสินค้า</h5>      

        <div class="row d-flex justify-content-center">
            <div class="col-md-9">
                <div class="form">
                    <form method="post" action="{{ route('stock_update', $stockItem->stock_id) }}" class="mt-5 border p-4 bg-light shadow" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <h4 class="mb-3 text-secondary">แก้ไขข้อมูลสินค้า</h4>
                        
                        <!-- Product Name Dropdown -->
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label>ชื่อสินค้า<span class="text-danger">*</span></label>
                                <select name="product_id" id="productSelect" class="form-select" aria-label="Default select example">
                                    <option disabled>เลือกชื่อสินค้า</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->product_id }}" data-price="{{ $product->cost_price }}" 
                                            {{ $stockItem->product_id == $product->product_id ? 'selected' : '' }}>
                                            {{ $product->product_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <!-- Cost Price Input -->
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label>ราคาทุน<span class="text-danger">*</span></label>
                                    <input type="text" id="cost_price" name="cost_price" class="form-control" value="{{ old('cost_price', $stockItem->cost_price) }}" readonly>
                                </div>

                                <!-- Quantity Input -->
                                <div class="mb-3 col-md-6">
                                    <label>จำนวน<span class="text-danger">*</span></label>
                                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $stockItem->quantity) }}">
                                    @error('quantity')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                          

                            <!-- Date and Time Receiving -->
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label>วันที่เข้ารับสินค้า<span class="text-danger">*</span></label>
                                    <input type="date" name="date_receiving" class="form-control" value="{{ old('date_receiving', $stockItem->date_receiving) }}">
                                    @error('date_receiving')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label>เวลาที่รับสินค้า<span class="text-danger">*</span></label>
                                    <input type="time" name="time_receiving" class="form-control" value="{{ old('time_receiving', $stockItem->time_receiving) }}">
                                    @error('time_receiving')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                         

                            <!-- Form Buttons -->
                            <div class="col-md-12">
                                <button class="btn btn-primary float-end" type="submit">บันทึกการเปลี่ยนแปลง</button>
                                <a href="{{ route('stock_items') }}"><button class="btn btn-danger float-end me-2" type="button">กลับ</button></a>
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
        var initialPrice = $('#productSelect').find('option:selected').data('price');
        $('#cost_price').val(initialPrice);

        $('#productSelect').on('change', function() {
            var costPrice = $(this).find('option:selected').data('price');
            $('#cost_price').val(costPrice);
        });
    });
</script>

@endsection
