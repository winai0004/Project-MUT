@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
    <h5 class="text-center">แสดงข้อมูลการสั่งซื้อสินค้า</h5>

    <div class="overflow-auto p-3 bg-light" style=" max-height: 900px;">
        
        <a href="{{ route('order_shopping') }}" class="btn btn-info btn-sm">Back</a>

        <div class="card mt-4">
            <div class="card-body">
                @if($status == 0)
                    <center><h1>อยู่ระหว่างการสั่งซื้อ</h1></center>
                @elseif($status == 1)
                    <div class="mt-1">
                        <span>ชื่อ {{ $orderDetails->fullname }}</span>
                        <span>วันที่ {{ date('d-m-Y', strtotime($orderDetails->created_at)) }}</span>
                    </div>

                    <div>
                        <span>ธนาคาร {{ $orderDetails->payment_method }} </span>
                        <span>ดูสลิป <a href="{{ asset('storage/' . $orderDetails->slip) }}" target="_blank">ดูสลิป</a> </span>
                    </div>

                    <div>
                        <span>ที่อยู่ {{ $orderDetails->address }} </span>
                    </div>

                    <div class="mt-2">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    {{-- <th scope="col">Order Number</th> --}}
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total Price</th>
                               
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $index => $order)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        {{-- <td>{{ $order->order_number }}</td> --}}
                                        <td>
                                            <img src="{{ asset('images/' . $order->product_img) }}"
                                                 alt="Item Image" 
                                                 style="width:100px; height: auto;">
                                        </td>
                                        <td>{{ $order->product_name }}</td>
                                        <td>{{ $order->color_name }}</td>
                                        <td>{{ $order->size_name }}</td>
                                        <td>{{ $order->total_quantity }}</td>
                                        <td>{{ number_format($order->total_price, 2) }}</td>
                                       
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            <div>Total Price: {{ number_format($orders->sum('total_price'), 2) }} บาท</div>
                            <div>Total Quantity: {{ $orders->sum('total_quantity') }} ชิ้น</div>
                        </div>
                        <div>
                            <select id="orderStatus" data-order-id="{{ $order_id }}" class="form-select form-select-sm">
                                <option value="2" >อนุมัติการสั่งซื้อ</option>
                                <option value="3" >ยกเลิกการสั่งซื้อ</option>
                            </select>
                            
                        </div>
                    </div>
                @else
                    <center><h1>เกิดข้อผิดพลาด</h1></center>

                @endif
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
