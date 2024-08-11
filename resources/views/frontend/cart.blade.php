@extends('layouts_frontend.app')

@section('title', 'Cart')

@section('content')

<section class="py-5">

    <div class="container px-4 px-lg-5">

        <h1>Shopping Cart</h1>

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
                    <tbody id="cartItemsContainer">
                        <!-- Cart items will be injected here by jQuery -->
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
     

    </div>

</section>

<script>

$(document).ready(function(){
    var user_id = '{{ Auth::user()->id }}'; 
    var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

    function updateCartUI() {
        $('#cartItemsContainer').empty();

        if (cartItems.length > 0) {
        let itemsFound = false;

        cartItems.forEach(function(item, index) {
            if (user_id == item.user) { 
                itemsFound = true;
                var itemTotalPrice = (item.price * item.quantity).toFixed(2);
                var itemHtml = `
                    <tr data-index="${index}">
                        <td>${item.name}</td>
                        <td>${item.color}</td>
                        <td>${item.size}</td>
                        <td>฿${parseFloat(item.price).toFixed(2)}</td>
                        <td> 
                            <button type="button" class="btn btn-dark mx-2 btn-increment">+</button>
                            <span class="quantity">${item.quantity}</span>
                            <button type="button" class="btn btn-dark mx-2 btn-decrement">-</button>
                        </td>
                        <td class="total-price">฿${itemTotalPrice}</td>
                        <td><button type="button" class="btn btn-danger btn-delete">Delete</button></td>
                    </tr>
                `;
                $('#cartItemsContainer').append(itemHtml);
            }
        });

        if (!itemsFound) {
            $('#cartItemsContainer').html('<tr><td colspan="7">Items belong to another user.</td></tr>');
        }
    } else {
        $('#cartItemsContainer').html('<tr><td colspan="7">Your cart is empty.</td></tr>');
    }
    }

    updateCartUI();

    $(document).on('click', '.btn-increment', function() {
        var index = $(this).closest('tr').data('index');
        cartItems[index].quantity++;
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        updateCartUI();
    });

    $(document).on('click', '.btn-decrement', function() {
        var index = $(this).closest('tr').data('index');
        if (cartItems[index].quantity > 1) {
            cartItems[index].quantity--;
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            updateCartUI();
        }
    });

   


    var total_price = 0;
    var total_quantity = 0;

 
   function calculate(){
    if (cartItems.length > 0) {
        cartItems.forEach(function(item) {
            total_price += parseFloat(item.price) * parseInt(item.quantity);
            total_quantity += parseInt(item.quantity);
        });
    }
    updateBoxCartUI();
   }

    calculate();


    function updateBoxCartUI() {
        $('#quantityDisplay').text(total_quantity + ' ชิ้น');
        $('#total').text('฿' + total_price.toFixed(2));
    }

   
    $(document).on('click', '.btn-delete', function() {
        var index = $(this).closest('tr').data('index');

        total_price -= cartItems[index].price * cartItems[index].quantity;
        total_quantity -= cartItems[index].quantity;

        cartItems.splice(index, 1);

        localStorage.setItem('cartItems', JSON.stringify(cartItems));

        updateCartUI();

        if (total_price < 0) total_price = 0;
        if (total_quantity < 0) total_quantity = 0;

        updateBoxCartUI();
    });



    $(document).on('click', '.btn-increment', function() {
        total_quantity++;
        updateCalulatePrice();
    });

    $(document).on('click', '.btn-decrement', function() {
        let quantityElement = $(this).siblings('.quantity');
        let currentQuantity = parseInt(quantityElement.text());
        
        if (currentQuantity > 1) {
            total_quantity--;
            updateCalulatePrice();
        }
    });

    function updateCalulatePrice(){
        var list = [];
        cartItems.forEach(function(item) {
            var item_total = item.price * item.quantity;
            total_price += item_total;
            list.push(item_total)
        });

        total_price = list.reduce((a, b) => a + b, 0);

        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        updateBoxCartUI();

    }


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

