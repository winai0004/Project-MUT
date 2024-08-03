@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
<h5 class="text-center">ตารางแสดงข้อมูลระดับสมาชิก</h5>

<div class="overflow-auto p-3 bg-light" style=" max-height: 600px;">
    <div class="mb-2 d-flex justify-content-end">
        <a href="{{route('form_membershiplevel')}}" class="btn btn-primary btn-sm ">เพิ่มข้อมูลระดับสมาชิก</a>
    </div>
    <table id="example" class="table table-striped border" style="width:100%">
    <thead>
        <tr>
            <th>Membership ID</th>
            <th>Membership Name</th>
            <th>Min Score</th>
            <th>Max Score</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
    </thead>
        <tbody>
            @foreach($membershiplevel as $item)
                <tr>
                    <td>{{$item->membership_level_id}}</td>
                    <td>{{$item->membership_level_name}}</td>
                    <td>{{$item->minscore}}</td>
                    <td>{{$item->maxscore}}</td>
                    <td style="width:50px;"><a href="{{ route('edit_membershiplevel' ,$item->membership_level_id)}}" class="btn btn-warning btn-sm" >edit</a></td>
                    <td style="width:50px;"><a href="{{ route('delete_membershiplevel' ,$item->membership_level_id)}}" class="btn btn-danger btn-sm" onclick="return confirm(`คุณต้องการลบ {{$item->membership_level_name}} หรือไม่?`)">delete</a></td>          
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

