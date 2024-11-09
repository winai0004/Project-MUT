
@extends('layouts_frontend.app')

@section('title','Clothing Shop')
@section('content')


<header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-1">
                <div class="text-center text-white" >
                    <h1 class="display-4 fw-bolder" >Welcome to Clothing Shops</h1>
                    {{-- <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage Clothing Shops</p> --}}
                </div>
            </div>
        </header>
        
        <div style="background: linear-gradient(180deg, rgba(159,159,159,1) 0%, rgba(214,214,214,1) 100%, rgba(255,255,255,1) 100%, rgba(255,255,255,1) 100%);">
            <!-- ส่วนของการแสดงโฆษณา -->
            <section class="pt-3">
                <div class="container px-lg-5 ">
                    <h2 class="text-start text-white fw-bolder" >Advertisement</h2>
                    <div class="row gx-4 gx-lg-5 justify-content-center">
                        @foreach($advert as $item)
                            <div class="col-md-4 mb-5 h-50 " style="width:300px;">
                                <div class="card h-30" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#advertModal{{ $item->advertisement_id }}">
                                    <img src="{{ asset('storage/advert/' . $item->advertisement_image) }}" class="img-fluid " alt="{{ $item->advertisement_name }}" style=" object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->advertisement_name }}</h5>
                                        <p class="card-text">{{ $item->description }}</p>
                                    </div>
                                </div>
                            </div>
        
                            <!-- Modal สำหรับโฆษณา -->
                            <div class="modal fade" id="advertModal{{ $item->advertisement_id }}" tabindex="-1" aria-labelledby="advertModalLabel{{ $item->advertisement_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="advertModalLabel{{ $item->advertisement_id }}">{{ $item->advertisement_name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ asset('storage/advert/' . $item->advertisement_image) }}" class="img-fluid" alt="{{ $item->advertisement_name }}">
                                            <p class="mt-3">{{ $item->description }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        @endforeach
                    </div>
                </div>
            </section>
            
        </div>

        <div class="container">
    <!-- ส่วนของการแสดงรายการสินค้า -->
    <section class="">
       <h1 class="mt-4 fw-bolder">Our Products</h1>
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach($products as $product)
                <!-- ส่วนของแสดงรายการสินค้าแต่ละรายการ -->
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <img class="card-img-top object-fit-fill "  src="{{ asset('images/' . $product->product_img) }}" alt="Product Image" height='200px'>
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder">{{ $product->product_name }}</h5>
                                <!-- Product price-->
                               {{ $product->selling_price }} ฿
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{ route('detail', $product->product_id) }}">View options</a></div>
                            
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <p>*หมายเหตุ: ต้องการยกเลิกการสั่งซื้อกรุณาติดต่อแอดมิน โทร 044-555555</p>
    </section>
    
    <!-- ส่วนของการแสดง pagination links -->
    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
<script>
    // เก็บค่าใน sessionStorage หรือ localStorage
    @if(session('id'))
        // เก็บค่าที่ส่งมาจาก Controller ลงใน sessionStorage
        sessionStorage.setItem('userId', '{{ session('id') }}');
    @endif
</script>

 
@endsection