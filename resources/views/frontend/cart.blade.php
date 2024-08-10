@extends('layouts_frontend.app')

@section('title', 'Cart')

@section('content')

<section class="py-5">

    <div class="container px-4 px-lg-5">

        <h1>Shopping Cart</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(count($cartItems) > 0)
        <div class="d-flex align-items-start flex-row ">
            <div class="flex-1 w-100 mt-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->color }}</td>
                                <td>{{ $item->size }}</td>
                                <td>฿{{ number_format($item->price, 2) }}</td>
                                <td> 
                                    <button type="button" class="btn btn-dark mx-2 btn-increment">+</button>
                                    <span class="quantity">{{ $item->quantity }}</span>
                                    <button type="button" class="btn btn-dark mx-2 btn-decrement">-</button>
                                </td>
                                <td id="total_price">฿{{ number_format($item->price * $item->quantity, 2) }}</td>
                                <td><button type="button" class="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>

            <div class="flex-1 w-50 " style="height: auto; margin-left:1rem; background:#F0EAD6;">
               <div class="p-4">
                <form>
                   <h6 class="fw-bolder">
                        Order Summary
                   </h6>
                   <h6 class="mt-3">
                        Quantity: <span id="quantityDisplay" class="float-end">ชิ้น</span>
                   </h6>
                   <h6 class="mt-3">
                        Total: <span id="total" class="float-end">฿</span>
                   </h6>

                   <h6 class="mt-4 fw-bolder">
                    Shopping infomation
                   </h6>

                   <div >
                        <div class="form-group mb-1">
                          <label for="exampleInputEmail1">Name</label>
                          <input type="text" class="form-control" id="name" >
                        </div>

                        <div class="form-group mb-1">
                          <label for="exampleInputEmail1">Tel</label>
                          <input type="text" class="form-control" id="telephone" >
                        </div>
                        
                        <div class="form-group">
                            <label for="Address">Address</label>
                            <textarea class="form-control" id="address" rows="3"></textarea>
                          </div>
                          
                                      
                   </div>

                   <h6 class="mt-4 fw-bolder">
                        Payment Method
                   </h6>

                   <div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-check">
                                <div class="d-flex justify-content-between ">
                                    <label class="form-check-label" for="exampleRadios1">
                                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>

                                       <div class="d-flex">
                                            <div class="me-1">ธนาคารกรุงเทพ</div>
                                            <div>8888-888</div>     
                                        </div> 
                                    </label>

                                    <div class="me-2 ">
                                        <img src="{{asset('images/t1.png')}}" width="35px">
                                    </div>
                                </div>
                              </div>
                        </div>
                      </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-check">
                                <div class="d-flex justify-content-between ">
                                    <label class="form-check-label" for="exampleRadios2">
                                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">

                                       <div class="d-flex">
                                            <div class="me-1">ธนาคารกรุงไทย</div>
                                            <div>8888-888</div>     
                                        </div> 
                                    </label>

                                    <div class="me-2 ">
                                        <img src="{{asset('images/t2.jpg')}}" width="35px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                      
                   </div>

                   <div class="mt-3">
                    <label for="formFile" class="form-label fw-bolder">Upload Slip</label>
                    <input class="form-control" type="file" id="formFile">
                  </div>

                   <div class="mt-4">
                    <button type="button" class="btn btn-dark w-100" id="btn_checkout"  data-href="{{URL::to('checkout')}}">Checkout</button>
                 </div>       

                </form>
               </div>
            </div>

           
        </div>
           
        @else
            <p>Your cart is empty.</p>
        @endif

    </div>

</section>

<script>

$(document).ready(function(){
    var rs_total = parseFloat($('#total_price').text().replace('฿', '').replace(',', ''));

    // ดึงค่า quantity เริ่มต้น
    let initialQuantity = parseInt($('.quantity').text());
    // ดึงค่า total_price จาก text และแปลงเป็นตัวเลข
    var rs_total = parseFloat($('#total_price').text().replace('฿', '').replace(',', ''));

    // แสดงค่าเริ่มต้นของ quantityDisplay และ total
    $('#quantityDisplay').text(initialQuantity + ' ชิ้น');
    $('#total').text('฿' + (initialQuantity * rs_total).toFixed(2));

    // เพิ่มค่าเมื่อคลิกปุ่ม increment
    $('.btn-increment').click(function() {
        let quantityElement = $(this).siblings('.quantity');
        let currentQuantity = parseInt(quantityElement.text());
        let newQuantity = currentQuantity + 1;
        
        quantityElement.text(newQuantity);
        $('#quantityDisplay').text(newQuantity + ' ชิ้น');
        $('#total').text('฿' + (newQuantity * rs_total).toFixed(2));
    });

    // ลดค่าเมื่อคลิกปุ่ม decrement
    $('.btn-decrement').click(function() {
        let quantityElement = $(this).siblings('.quantity');
        let currentQuantity = parseInt(quantityElement.text());
        
        if (currentQuantity > 1) {
            let newQuantity = currentQuantity - 1;
            quantityElement.text(newQuantity);
            $('#quantityDisplay').text(newQuantity + ' ชิ้น');
            $('#total').text('฿' + (newQuantity * rs_total).toFixed(2));
        }
    });

    $("#btn_checkout").click(function() {
        let name = $('#name').val();
        let telephone = $('#telephone').val();
        let address = $('#address').val();
        let exampleRadios1 = $('#exampleRadios1').is(':checked');
        let exampleRadios2 = $('#exampleRadios2').is(':checked');
        let formFile = $('#formFile').val();

        if (!name || !telephone || !address || (!exampleRadios1 && !exampleRadios2) || !formFile) {
            alert('กรุณากรอกข้อมูลให้ครบ');
        }else{
            window.location.href =  $(this).data('href');
        }
    });

});

</script>


@endsection

