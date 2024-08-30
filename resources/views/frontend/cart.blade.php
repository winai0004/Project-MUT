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
                        <tbody id="cart-items">
                            @if ($cartItems->isEmpty())
                                <tr>
                                    <td colspan="7">Your cart is empty.</td>
                                </tr>
                            @else
                                @foreach($cartItems as $index => $item)

                                <input type="hidden" id="cartItems" data-cart-items="{{ json_encode($cartItems) }}">
                                @if ($item->user_id !== Auth::user()->id)
                                        <tr>
                                            <td colspan="7">Items belong to another user.</td>
                                        </tr>
                                        @break
                                    @else
                                        <tr data-index="{{ $index }}">
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->color }}</td>
                                            <td>{{ $item->size }}</td>
                                            <td class="price" data-price="{{ $item->price }}">฿{{ number_format($item->price, 2) }}</td>
                                            <td>
                                                <button type="button" class="btn btn-dark mx-2 btn-increment" data-cart-id="{{ $item->cart_id }}">+</button>
                                                <span class="quantity">{{ $item->quantity }}</span>
                                                <button type="button" class="btn btn-dark mx-2 btn-decrement"  data-cart-id="{{ $item->cart_id }}">-</button>
                                            </td>
                                            <td class="total-price">฿{{ number_format($item->price * $item->quantity, 2) }}</td>
                                            <td>                        
                                                <button type="button" class="btn btn-danger btn-delete" data-cart-id="{{ $item->cart_id }}">Delete</button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                        
                        
                    </table>
                </div>
                

                <div class="flex-1 w-50 " style="height: auto; margin-left:1rem; background:#F0EAD6;">
                <div class="p-4">
                
                    <h6 class="fw-bolder">
                            Order Summary
                    </h6>
                    <h6 class="mt-3">
                        Quantity: <span class="float-end total_quantity">{{ $totalQuantity }} ชิ้น</span>
                        </h6>
                        <h6 class="mt-3">
                            Total: <span class="float-end total_price">฿ {{ number_format($totalPrice, 2) }}</span>
                        </h6>
                    

                    <h6 class="mt-4 fw-bolder">
                        Shopping infomation
                    </h6>

                    <div >
                            <div class="form-group mb-1">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" id="fullname" >
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
                                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="ธนาคารกรุงเทพ,8888-888" checked>

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
                                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="ธนาคารกรุงไทย,9999-888">

                                        <div class="d-flex">
                                                <div class="me-1">ธนาคารกรุงไทย</div>
                                                <div>9999-888</div>     
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
                        <button type="button" class="btn btn-dark w-100" id="btn_checkout" data-href="{{ route('checkout-view') }}">Checkout</button>
                    </div>       

            
                    </div>
                </div>        
            </div>
    </div>

</section>

<script>

$(document).ready(function(){

    var paymentMethod = "ธนาคารกรุงเทพ,8888-888"; 
    var cartItems = $('#cartItems').data('cart-items'); 
    console.log('Cart Items:', cartItems);


    $('input[name="exampleRadios"]').change(function() {
        let selectedId = $(this).attr('id');
        if (selectedId === 'exampleRadios1') {
            paymentMethod = $(this).val(); 
        } else if (selectedId === 'exampleRadios2') {
            paymentMethod = $(this).val(); 
        }
        // console.log("Selected Payment Method: " + paymentMethod); // สำหรับตรวจสอบค่า
    });

    $("#btn_checkout").click(function() {
            var href = $(this).data('href');

            let name = $('#fullname').val();
            let telephone = $('#telephone').val();
            let address = $('#address').val();
            let formFile = $('#formFile')[0].files[0];

            if (!name || !telephone || !address || !formFile) {
                alert('กรุณากรอกข้อมูลให้ครบ');
                return;
            }

            let item = {
                name: name,
                telephone: telephone,
                address: address,
                paymentMethod: paymentMethod,
                cartItems: cartItems, 
                totalPrice: calculateTotalPrice(), 
                totalQuantity: calculateTotalQuantity() 
            };

            let formData = new FormData();
            formData.append('item', JSON.stringify(item));
            formData.append('formFile', formFile);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: '/cart/checkout-add',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if(response.success) {
                        if (href) {
                            window.location.href = href;
                        }
                    }
                },
                error: function(error) {
                    console.log(error);
                    alert('เกิดข้อผิดพลาด');
                }
            });
        });


        
    function calculateTotalPrice() {
        return cartItems.reduce((total, item) => total + (item.price * item.quantity), 0).toFixed(2);
    }   

    function calculateTotalQuantity() {
        return cartItems.reduce((total, item) => total + item.quantity, 0);
    }



    $('.btn-delete').on('click', function() {
        var cartId = $(this).data('cart-id'); // ดึง cart_id จาก data attribute
        var row = $(this).closest('tr'); // ดึง row ที่เกี่ยวข้อง

        if (confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url: '/cart/delete/' + cartId, // ส่งคำขอไปที่เส้นทางนี้
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}' 
                },
                success: function(response) {
                    row.remove(); // ลบ row ออกจากตาราง
                    alert(response.success); 
                    fetchCartTotals();
                },
                error: function(xhr) {
                    alert('An error occurred while trying to delete the item.');
                }
            });
        }
    });

    $(document).on('click', '.btn-increment', function() {
        var cartId = $(this).data('cart-id');
        var $row = $(this).closest('tr');
        var quantitySpan = $row.find('.quantity');
        var price = parseFloat($row.find('.price').data('price'));

        var quantity = parseInt(quantitySpan.text());

        quantity++;
        quantitySpan.text(quantity);

        // คำนวณราคาใหม่
        var newTotalPrice = (price * quantity).toFixed(2);

        // console.log('Quantity:', quantity);
        // console.log('Price:', price);
        // console.log('New Total Price:', newTotalPrice);


        // ใช้ toLocaleString() เพื่อจัดรูปแบบจำนวนเต็มพร้อมทศนิยม
        var formattedPrice = parseFloat(newTotalPrice).toLocaleString('en-US', { minimumFractionDigits: 2 });

        // อัปเดต UI
        $row.find('.total-price').text('฿' + formattedPrice);

        updateCartItem(cartId, quantity);
        fetchCartTotals();

    });

    $(document).on('click', '.btn-decrement', function() {
        var cartId = $(this).data('cart-id');
        var $row = $(this).closest('tr');
        var quantitySpan = $row.find('.quantity');
        var price = parseFloat($row.find('.price').data('price'));

        var quantity = parseInt(quantitySpan.text());

        // ลดจำนวนสินค้า
        if (quantity > 1) {
            quantity--;

            // อัปเดต UI
            quantitySpan.text(quantity);

            var newTotalPrice = (price * quantity).toFixed(2);

            // ดีบักเพื่อตรวจสอบค่า
            // console.log('Quantity:', quantity);
            // console.log('Price:', price);
            // console.log('New Total Price:', newTotalPrice);

            // อัปเดตราคาทั้งหมด
            // แยกส่วนจำนวนเต็มและส่วนทศนิยม
            var newTotalPrice = (price * quantity).toFixed(2);

            // ใช้ toLocaleString() เพื่อจัดรูปแบบจำนวนเต็มพร้อมทศนิยม
            var formattedPrice = parseFloat(newTotalPrice).toLocaleString('en-US', { minimumFractionDigits: 2 });

            // อัปเดต UI
            $row.find('.total-price').text('฿' + formattedPrice);

            updateCartItem(cartId, quantity);
            fetchCartTotals();
        }
    });


    function updateCartItem(cartId, quantity) {
        $.ajax({
            url: '/cart/update',
            type: 'PUT',  // ใช้ PUT สำหรับการอัปเดตข้อมูล
            data: {
                _token: '{{ csrf_token() }}',
                cart_id: cartId,
                quantity: quantity
            },
            success: function(response) {
                console.log('Cart item updated successfully.');
            },
            error: function(xhr) {
                console.log('An error occurred while updating the cart item.');
            }
        });
    }


    // ฟังก์ชันในการอัปเดตข้อมูลใน UI
    function updateCartTotals(totalQuantity, totalPrice) {
        $('.total_quantity').text(totalQuantity + ' ชิ้น');

        var formattedPrice = parseFloat(totalPrice).toLocaleString('en-US', { minimumFractionDigits: 2 });

        $('.total_price').text('฿ ' + formattedPrice);
    }

    function fetchCartTotals() {
        $.ajax({
            url: '/cart/totals',
            type: 'GET',
            success: function(response) {
                if (response.totalQuantity !== undefined && response.totalPrice !== undefined) {
                    updateCartTotals(response.totalQuantity, response.totalPrice);
                }
            },
            error: function(xhr) {
                console.log('An error occurred while fetching cart totals.');
            }
        });
    }


});

</script>


@endsection

