{{-- @extends('layouts_frontend.app')

@section('title', 'Product Details')

@section('content')
<style>
    .product-detail-wrapper {
        padding: 2rem;
        margin: 0 auto;
        height: 100vh;
        
    }

    .product-detail-container {
        display: flex;
        gap: 2rem;
    }

    .product-image {
        flex: 1;
    }

    .product-image img {
        max-width: 100%;
    }

    .product-info {
        flex: 1;
    }

    .product-info h1 {
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .price {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .product-options {
        margin-bottom: 1rem;
    }

    .option {
        margin-bottom: 0.5rem;
    }

    .option button {
        padding: 0.5rem 1rem;
        margin-right: 0.5rem;
        border: 1px solid #ccc;
        background-color: #fff;
        cursor: pointer;
    }

    .option button.selected {
        background-color: #000;
        color: #fff;
    }

    .add-to-cart-btn {
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
        background-color: #000;
        color: #fff;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
    }
</style>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="product-detail-wrapper">
            <div class="product-detail-container">
                <!-- แสดงรูปภาพสินค้า -->
                <div class="product-image">
                    <img src="{{ asset('images/' . $product->product_img) }}" alt="Product Image" height="400px" width="600px">
                </div>
                <!-- แสดงข้อมูลสินค้า -->
                <div class="product-info">
                    <!-- แสดงชื่อสินค้า -->
                    <h1>{{ $product->product_name }}</h1>
                    <!-- แสดงราคาสินค้า -->
                    <p class="price">{{ $product->selling_price }} Bath</p>
                    <!-- แสดงแบบฟอร์มสำหรับเพิ่มสินค้าในตะกร้า -->
                    <form action="#" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                        <input type="hidden" name="name" value="{{ $product->product_name }}">
                        <input type="hidden" name="price" value="{{ $product->selling_price }}">
                        <!-- แสดงตัวเลือกสีของสินค้า -->
                        @if(isset($product->color_name))
                           
                        <div class="option">
                            <label>Color:</label>
                            <br>
                            @foreach($colors as $color)                            
                            <button type="button" class="color-btn mb-3" data-color="{{ $color->color_name }}">{{ $color->color_name }}</button>
                            <input type="hidden" name="color" value="{{ $color->color_name }}">
                            @endforeach
                        </div>
                        @endif

                        <!-- แสดงตัวเลือกไซส์ของสินค้า -->
                        @if(isset($product->size_name))
                        <div class="option">
                            <label>Size:</label>
                            <br>
                            @foreach($sizes as $size)
                            <button type="button" class="size-btn mb-3" data-size="{{ $size->size_name }}">{{ $size->size_name }}</button>
                            <input type="hidden" name="size" value="{{ $size->size_name }}">
                            @endforeach
                        </div>


                        @endif
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
   

    // Size button click event
    document.querySelectorAll('.color-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            document.querySelector('input[name="color"]').value = this.getAttribute('data-color');
            document.querySelectorAll('.color-btn').forEach(function(btn) {
                btn.classList.remove('selected');
            });
            this.classList.add('selected');
        });
    });

    document.querySelectorAll('.size-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            document.querySelector('input[name="size"]').value = this.getAttribute('data-size');
            document.querySelectorAll('.size-btn').forEach(function(btn) {
                btn.classList.remove('selected');
            });
            this.classList.add('selected');
        });
    });
</script>
@endsection --}}

@extends('layouts_frontend.app')

@section('title', 'Product Details')

@section('content')
<style>
    .product-detail-wrapper {
        padding: 2rem;
        margin: 0 auto;
        height: 100vh;
        
    }

    .product-detail-container {
        display: flex;
        gap: 2rem;
    }

    .product-image {
        flex: 1;
    }

    .product-image img {
        max-width: 100%;
    }

    .product-info {
        flex: 1;
    }

    .product-info h1 {
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .price {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .product-options {
        margin-bottom: 1rem;
    }

    .option {
        margin-bottom: 0.5rem;
    }

    .option button {
        padding: 0.5rem 1rem;
        margin-right: 0.5rem;
        border: 1px solid #ccc;
        background-color: #fff;
        cursor: pointer;
    }

    .option button.selected {
        background-color: #000;
        color: #fff;
    }

    .add-to-cart-btn {
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
        background-color: #000;
        color: #fff;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
    }
</style>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="product-detail-wrapper">
            <div class="product-detail-container">
                <!-- แสดงรูปภาพสินค้า -->
                <div class="product-image">
                    <img src="{{ asset('images/' . $product->product_img) }}" alt="Product Image" height="400px" width="600px">
                </div>
                <!-- แสดงข้อมูลสินค้า -->
                <div class="product-info">
                    <!-- แสดงชื่อสินค้า -->
                    <h1>{{ $product->product_name }}</h1>
                    <!-- แสดงราคาสินค้า -->
                    <p class="price">{{ $product->selling_price }} Bath</p>
                    <!-- แสดงแบบฟอร์มสำหรับเพิ่มสินค้าในตะกร้า -->
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                        <input type="hidden" name="name" value="{{ $product->product_name }}">
                        <input type="hidden" name="price" value="{{ $product->selling_price }}">
                        <!-- แสดงตัวเลือกสีของสินค้า -->
                        @if(isset($product->color_name))
                           
                        <div class="option">
                            <label>Color:</label>
                            <br>
                            @foreach($colors as $color)                            
                            <button type="button" class="color-btn mb-3" data-color="{{ $color->color_name }}">{{ $color->color_name }}</button>
                            <input type="hidden" name="color" value="{{ $color->color_name }}">
                            @endforeach
                        </div>
                        @endif

                        <!-- แสดงตัวเลือกไซส์ของสินค้า -->
                        @if(isset($product->size_name))
                        <div class="option">
                            <label>Size:</label>
                            <br>
                            @foreach($sizes as $size)
                            <button type="button" class="size-btn mb-3" data-size="{{ $size->size_name }}">{{ $size->size_name }}</button>
                            <input type="hidden" name="size" value="{{ $size->size_name }}">
                            @endforeach
                        </div>


                        @endif
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Color button click event
    document.querySelectorAll('.color-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            document.querySelector('input[name="color"]').value = this.getAttribute('data-color');
            document.querySelectorAll('.color-btn').forEach(function(btn) {
                btn.classList.remove('selected');
            });
            this.classList.add('selected');
        });
    });

    // Size button click event
    document.querySelectorAll('.size-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            document.querySelector('input[name="size"]').value = this.getAttribute('data-size');
            document.querySelectorAll('.size-btn').forEach(function(btn) {
                btn.classList.remove('selected');
            });
            this.classList.add('selected');
        });
    });
</script>
@endsection
