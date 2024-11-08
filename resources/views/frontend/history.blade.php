@extends('layouts_frontend.app')

@section('title', 'Checkout')

@section('content')


<!doctype html>
 <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
 
     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">
 
     <title>@yield('title')</title>
     <!-- Scripts -->
     @vite(['resources/sass/app.scss', 'resources/js/app.js'])
     
     {{-- jquery --}}
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


     <!-- Font Awesome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

      <!-- data table style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />

         <!-- data table -->
         <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
         <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

 </head>
 <body>
<div class="container px-5 my-5">
    <h5 class="text-center">ประวัติการสั่งซื้อสินค้า</h5>

    <div class="overflow-auto p-3 bg-light" style="max-height: 600px;">
        <table id="example" class="table table-striped border" style="width:100%">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Customer User</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>View</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $item)
                  
                    <tr>
                        <td>{{ $item->order_number }}</td>
                        <td>{{ $item->fullname }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td style="width:50px;">
                            @if($item->status == 0)
                                <a href="#" class="btn btn-warning btn-sm">Pending</a>
                            @elseif($item->status == 1)
                                <a href="#" class="btn btn-success btn-sm">Success</a>
                            @elseif($item->status == 2)
                                <a href="#" class="btn btn-danger btn-sm">Failed</a>
                            @endif
                        </td>
                        <td style="width:50px;">
                            <a href="{{ route('order_view', [$item->order_id, $item->order_detail_id , $item->status]) }}" class="btn btn-info btn-sm">view</a>
                        </td>
                          <td style="width:50px;">
                            <button class="btn btn-danger btn-sm delete-order" data-order-id="{{ $item->order_id }}" data-order-name="{{ $item->fullname }}">delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>

<script>
    $(document).ready(function() {
        $('#example').DataTable();

        $('.delete-order').click(function(e) {
            e.preventDefault();
            
            var orderId = $(this).data('order-id');
            var orderName = $(this).data('order-name'); // ดึง fullname
            var row = $(this).closest('tr'); // ค้นหาแถวของปุ่มที่คลิก

            if (confirm('คุณต้องการลบ Order ของคุณ ' + orderName + ' หรือไม่?')) {
                $.ajax({
                    url: '{{ url("order/delete") }}/' + orderId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if(response.success) {
                            row.fadeOut(500, function() { 
                                $(this).remove(); // ลบแถวออกจากตาราง
                            });
                            alert('Order #' + orderId + ' ถูกลบเรียบร้อยแล้ว');
                        } else {
                            alert('เกิดข้อผิดพลาดในการลบ Order #' + orderId);
                        }
                    },
                    error: function() {
                        alert('เกิดข้อผิดพลาดในการลบ Order #' + orderId);
                    }
                });
            }
        });
    });
</script>
</html>

@endsection
