@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
<h5 class="text-center">ตารางแสดงข้อมูลสต็อกสินค้า</h5>

<div class="overflow-auto p-3 bg-light" style=" max-height: 600px;">
    <div class="mb-2 d-flex justify-content-end">
        <a href="{{route('stock_form')}}" class="btn btn-primary btn-sm ">เพิ่มข้อมูล</a>
    </div>
    <table id="example" class="table table-striped border" style="width:100%">
        <thead>
            <tr>
                <th>ไอดี</th>
                <th>ชื่อสินค้า</th>
                <th>ราคาทุน</th>
                <th>จำนวน</th>
                <th>วันที่รับ</th>
                <th>เวลาที่รับ</th>
               
                <th>แก้ไข</th>
                <th>ลบ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{$item->stock_id}}</td>
                    <td>{{$item->product_name}}</td>
                    <td>{{$item->cost_price}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->date_receiving}}</td>
                    <td>{{$item->time_receiving}}</td>
                       
                    <td><a href="{{ route('stock_edit', $item->stock_id)}}" class="btn btn-warning btn-sm">แก้ไข</a></td>
                    <td>
                        <form action="{{ route('stock_delete', $item->stock_id) }}" method="POST" onsubmit="return confirm('คุณต้องการลบ {{$item->product_name}} หรือไม่?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">ลบ</button>
                        </form>
                    </td>
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