@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
<h5 class="text-center">ตารางแสดงข้อมูลประเภทเสื้อ</h5>

<div class="overflow-auto p-3 bg-light" style=" max-height: 600px;">
    <div class="mb-2 d-flex justify-content-end">
        <a href="{{route('form_shirt')}}" class="btn btn-primary btn-sm ">เพิ่มข้อมูล</a>
    </div>
    <table id="example" class="table table-striped border" style="width:100%">
    <thead>
        <tr>
            <th>Shirt Type ID</th>
            <th>Shirt Type Name</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
    </thead>
        <tbody>
            @foreach($shirts as $item)
                <tr>
                    <td>{{$item->category_id}}</td>
                    <td>{{$item->category_name}}</td>
                    <td style="width:50px;"><a href="{{ route('edit_shirt' ,$item->category_id)}}" class="btn btn-warning btn-sm" >edit</a></td>
                    <td style="width:50px;"><a href="{{ route('delete_shirt' ,$item->category_id)}}" class="btn btn-danger btn-sm" onclick="return confirm(`คุณต้องการลบ {{$item->category_name}} หรือไม่?`)">delete</a></td>          
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