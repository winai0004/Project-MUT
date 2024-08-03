@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
<h5 class="text-center">ตารางแสดงข้อมูลรายละเอียดการสั่งซื้อสินค้า</h5>

<div class="overflow-auto p-3 bg-light" style=" max-height: 600px;">
    <div class="mb-2 d-flex justify-content-end">
        <a href="{{route('order_products_detailForm')}}" class="btn btn-primary btn-sm ">เพิ่มข้อมูล</a>
    </div>
    <table id="example" class="table table-striped border" style="width:100%">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Picture</th>
            <th>Cost Price</th>
            <th>Selling Price</th>
            <th>Color</th>
            <th>Size</th>
            <th>Type</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
    </thead>
        <tbody>
            @foreach($products as $item)
                <tr>
                    <td>{{$item->product_id}}</td>
                    <td>{{$item->product_name}}</td>
                    <td>
                        <img src="{{ asset('images/' . $item->product_img) }}" alt="Product Image" class=" object-fit-cover rounded-circle" width="80px" height="80px">
                    </td>
                    <td>{{$item->selling_price}}</td>
                    <td>{{$item->cost_price}}</td>
                    <td>{{$item->color_name}}</td>
                    <td>{{$item->size_name}}</td>
                    <td>{{$item->category_name}}</td>
                    {{-- <td>
                        @if(property_exists($item, 'color_name'))
                            {{$item->color_name}}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if(property_exists($item, 'size_name'))
                            {{$item->size_name}}
                        @else
                            N/A
                        @endif
                    </td> --}}
                    <td style="width:50px;"><a href="{{ route('edit_products' ,$item->product_id)}}" class="btn btn-warning btn-sm" >edit</a></td>
                    <td style="width:50px;"><a href="{{ route('delete_products' ,$item->product_id)}}" class="btn btn-danger btn-sm" onclick="return confirm(`คุณต้องการลบ {{$item->product_name}} หรือไม่?`)">delete</a></td>          
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

