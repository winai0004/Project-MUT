@extends('layouts_frontend.app')

@section('title', 'Checkout')

@section('content')

<section class="py-5 vh-100">

    <div class="container px-4 px-lg-5 mt-5 ">
        
        <div class="mx-auto w-50 ">
            <div class="d-flex justify-content-center">
                <h4 class="fw-bolder">ชำระเงินเสร็จสิ้น ขอบคุณที่ใช้บริการ</h4>
              </div>
         
            <div class="me-2 ">
                <img src="{{asset('images/check.png')}}" >
            </div>
           
        </div>
           
       

    </div>

</section>

@endsection
