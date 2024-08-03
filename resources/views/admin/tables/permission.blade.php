@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
<h5 class="text-center">ตารางแสดงข้อมูลสิทธิ์</h5>

<div class="overflow-auto p-3 bg-light" style=" max-height: 600px;">
    <div class="mb-2 d-flex justify-content-end">
        <a href="{{route('form_permission')}}" class="btn btn-primary btn-sm ">เพิ่มข้อมูล</a>
    </div>
    <table id="example" class="table table-striped border" style="width:100%">
    <thead>
        <tr>
            <th>Permission ID</th>
            <th>Permission Name</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
    </thead>
        <tbody>
            @foreach($permission as $item)
                <tr>
                    <td>{{$item->permission_id}}</td>
                    <td>{{$item->permission_name}}</td>
                    <td style="width:50px;"><a href="{{ route('edit_permission' ,$item->permission_id)}}" class="btn btn-warning btn-sm" >edit</a></td>
                    <td style="width:50px;"><a href="{{ route('delete_permission' ,$item->permission_id)}}" class="btn btn-danger btn-sm" onclick="return confirm(`คุณต้องการลบ {{$item->permission_name}} หรือไม่?`)">delete</a></td>          
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

 