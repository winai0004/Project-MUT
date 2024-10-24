@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
<h5 class="text-center">ตารางแสดงข้อมูลโปรโมชั่น</h5>

<div class="overflow-auto p-3 bg-light" style=" max-height: 600px;">
    <div class="mb-2 d-flex justify-content-end">
        <a href="{{route('form_promotion')}}" class="btn btn-primary btn-sm ">เพิ่มข้อมูล</a>
    </div>
    <table id="example" class="table table-striped border" style="width:100%">
    <thead>
        <tr>
            <th>ProductName</th>
            <th>Discount</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
    </thead>
        <tbody>
            @foreach($promotion as $item)
                <tr>
                    <td>{{$item->product_name}}</td>
                    <td>{{$item->discount . '%'}}</td>
                    <td style="width:50px;"><a href="{{ route('edit_promotion' ,$item->promotion_id )}}" class="btn btn-warning btn-sm" >edit</a></td>
                    <td style="width:50px;"><a href="{{ route('delete_promotion' ,$item->promotion_id )}}" class="btn btn-danger btn-sm" onclick="return confirm(`คุณต้องการลบ {{$item->product_name}} หรือไม่?`)">delete</a></td>          
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

