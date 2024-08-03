@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
<h5 class="text-center">ตารางแสดงข้อมูลการขายสินค้า</h5>

<div class="overflow-auto p-3 bg-light" style=" max-height: 600px;">
    <div class="mb-2 d-flex justify-content-end">
        <a href="{{route('form_products')}}" class="btn btn-primary btn-sm ">เพิ่มข้อมูล</a>
    </div>
    <table id="example" class="table table-striped border" style="width:100%">
    <thead>
        <tr>
            <th>Sale Product ID</th>
            <th>Sale Date</th>
            <th>Sale Time</th>
            <th>Deliverly Address</th>
            <th>Sale Status</th>
        </tr>
    </thead>
        <tbody>
            @foreach($saleproduct as $item)
                <tr>
                    <td>{{$item->sale_product_id}}</td>
                    <td>{{$item->sale_date}}</td>
                    <td>{{$item->sale_time}}</td>
                    <td>{{$item->deliverly_address}}</td>
                    <td>{{$item->sale_status}}</td>
                    {{-- <td style="width:50px;"><a href="{{ route('edit_products' ,$item->product_id)}}" class="btn btn-warning btn-sm" >edit</a></td>
                    <td style="width:50px;"><a href="{{ route('delete_products' ,$item->product_id)}}" class="btn btn-danger btn-sm" onclick="return confirm(`คุณต้องการลบ {{$item->product_name}} หรือไม่?`)">delete</a></td>           --}}
                </tr>
            @endforeach
        </tbody>
    </table>
 </div>

 
</div>

<script>
    $(function(){
        $('#example').DataTable();
    });   
</script>


@endsection

