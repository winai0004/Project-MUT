@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
    <h5 class="text-center">แสดงข้อมูลการสั่งซื้อสินค้า</h5>

    <div class="overflow-auto p-3 bg-light" style=" max-height: 900px;">
        
        <a href="{{ route('order_shopping')}}"  class="btn btn-info btn-sm">Back</a>

        <div class="card mt-4">
            <div class="card-body">
                <div class="">
                    Order #{{ $order->order_number }}  
                </div>
                <div class="mt-1">
                    <span>ชื่อ {{ $order->fullname }} </span>
                    <span>วันที่ {{ date('d-m-Y', strtotime($order->created_at)) }}</span>
                    <span>เวลา {{ date('H:i', strtotime($order->created_at)) }}</span>
                </div>
                <div class="mt-1 d-flex">
                    <span class="me-2">
                        {{ $order->payment_method }}
                    </span>

                    <span>
                        <p><a href="{{ asset('storage/' . $order->slip) }}" target="_blank">ดูสลิป</a></p>
                    </span>
                </div>

               
                <div class="mt-2">
                    Item orders
                    <div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">TotalPrice</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Tel</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(json_decode($order->order_items, true) as $index => $item)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>
                                        <img  src="{{ asset('images/' . $item['image']) }}"
                                             alt="Item Image" 
                                             style="width:100px; height: auto;">
                                    </td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['color'] }}</td>
                                    <td>{{ $item['size'] }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>{{ number_format($item['total_price'], 2) }}</td>
                                    <td>{{ $order->address }}</td>
                                    <td>{{ $order->telephone }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
        
                    <div class="d-flex justify-content-between">
                        <div>
                            <div>Total Price: {{ number_format($order->total_price, 2) }} บาท</div>
                            <div>Total Quantity: {{ $order->total_quantity }} ชิ้น</div>
                        </div>
                        <div>
                            <select class="form-select" id="orderStatus" data-order-id="{{ $order->order_id }}" aria-label="Default select example">
                                <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>Pending</option>
                                <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Success</option>
                                <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

 
</div>

<script>
    $(document).ready(function(){
        $('#orderStatus').change(function(){
            var status = $(this).val();
            var order_id = $(this).data('order-id');

            $.ajax({
                url: '{{ route('order.updateStatus') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order_id: order_id,
                    status: status
                },
                success: function(response) {
                    if(response.success) {
                        alert('Order status updated successfully.');
                    } else {
                        alert('Failed to update order status.');
                    }
                }
            });
        });
    });
</script>


@endsection

