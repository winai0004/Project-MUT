@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5">
    <h5 class="text-center">ตารางแสดงข้อมูลการสั่งซื้อสินค้า</h5>

<<<<<<< HEAD
<div class="overflow-auto p-3 bg-light" style=" max-height: 600px;">
    
    <table id="example" class="table table-striped border" style="width:100%">
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Created At</th>
            <th>Status</th>
            <th>View</th>
            <th>Delete</th>
        </tr>
    </thead>
        <tbody>
            @foreach($orders as $item)
                <tr>
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
                    <td style="width:50px;"><a href="{{ route('order_view',$item->user_id )}}" class="btn btn-info btn-sm">view</a></td>  
                    <td style="width:50px;">
                        <button class="btn btn-danger btn-sm delete-order" data-order-id="{{ $item->user_id  }}" data-order-name="{{ $item->fullname }}">delete</button>
                    </td>
                            
=======
    <div class="overflow-auto p-3 bg-light" style="max-height: 600px;">
        <table id="example" class="table table-striped border" style="width:100%">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Customer</th>
                    <th>Order DateTime</th>
                    <th>Status</th>
                    <th>View</th>
                    <th>Delete</th>
>>>>>>> 0f3ab96d29a8836b962947b892e48a04285e2fc9
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $item)
                    <tr>
                        <td>{{ $item->order_number }}</td>
                        <td>{{ $item->fullname }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td style="width: 100px;">
                            @if($item->status == 0)
                                <a href="#" class="btn btn-warning btn-sm">Pending</a>
                            @elseif($item->status == 1)
                                <a href="#" class="btn btn-success btn-sm">Success</a>
                            @elseif($item->status == 2)
                                <a href="#" class="btn btn-danger btn-sm">Failed</a>
                            @endif
                        </td>                    
                        <td style="width: 50px;">
                            <a href="{{ route('order_view', $item->order_id) }}" class="btn btn-info btn-sm">View</a>
                        </td>  
                        <td style="width: 50px;">
                            <button class="btn btn-danger btn-sm delete-order" data-order-id="{{ $item->order_id }}" data-order-number="{{ $item->order_number }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable();

        $('.delete-order').click(function(e) {
            e.preventDefault();
            
            var orderId = $(this).data('order-id');
            var orderName = $(this).data('order-name'); // ดึง fullname
            var row = $(this).closest('tr'); // ค้นหาแถวของปุ่มที่คลิก

            if (confirm('คุณต้องการลบ Order ของคุณ' + orderName + ' หรือไม่?')) {
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
                            alert('Order #' + orderNumber + ' ถูกลบเรียบร้อยแล้ว');
                        } else {
                            alert('เกิดข้อผิดพลาดในการลบ Order #' + orderNumber);
                        }
                    },
                    error: function() {
                        alert('เกิดข้อผิดพลาดในการลบ Order #' + orderNumber);
                    }
                });
            }
        });
    });
</script>

@endsection
