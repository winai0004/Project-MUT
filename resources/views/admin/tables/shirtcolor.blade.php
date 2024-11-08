@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
<h5 class="text-center">ตารางแสดงข้อมูลสีเสื้อ</h5>

<div class="overflow-auto p-3 bg-light" style=" max-height: 600px;">
    <div class="mb-2 d-flex justify-content-end">
        <a href="{{route('form_shirtcolor')}}" class="btn btn-primary btn-sm ">เพิ่มข้อมูล</a>
    </div>
    <table id="example" class="table table-striped border" style="width:100%">
    <thead>
        <tr>
            <th>Shirt Color ID</th>
            <th>Shirt Color Name</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
    </thead>
        <tbody>
            @foreach($shirtcolor as $item)
                <tr>
                    <td>{{$item->color_id }}</td>
                    <td>{{$item->color_name}}</td>
                    <td style="width:50px;"><a href="{{ route('edit_shirtcolor' ,$item->color_id)}}" class="btn btn-warning btn-sm" >edit</a></td>
                    <td style="width:50px;"><a href="{{ route('delete_shirtcolor' ,$item->color_id)}}" class="btn btn-danger btn-sm" onclick="return confirm(`คุณต้องการลบ {{$item->color_name}} หรือไม่?`)">delete</a></td>          
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

