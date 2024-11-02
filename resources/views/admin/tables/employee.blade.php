@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
<h5 class="text-center">ตารางแสดงข้อมูลพนักงาน</h5>

<div class="overflow-auto p-3 bg-light" style=" max-height: 600px;">
    <div class="mb-2 d-flex justify-content-end">
        <a href="{{route('form_employee')}}" class="btn btn-primary btn-sm ">เพิ่มข้อมูล</a>
    </div>
    <table id="example" class="table table-striped border" style="width:100%">
    <thead>
        <tr>
            <th>Employee ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            {{-- <th>Password</th> --}}
            <th>Phone Number</th>
            <th>Department</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
    </thead>
        <tbody>
            @foreach($employee as $item)
                <tr>
                    <td>{{$item->employee_id }}</td>
                    <td>{{$item->first_name}}</td>
                    <td>{{$item->last_name}}</td>
                    <td>{{$item->username}}</td>
                    {{-- <td>{{$item->password}}</td> --}}
                    <td>{{$item->phone_number}}</td>
                    <td>{{$item->department_name}}</td>
                    <td style="width:50px;"><a href="{{ route('edit_employee' ,$item->employee_id)}}" class="btn btn-warning btn-sm" >edit</a></td>
                    <td style="width:50px;"><a href="{{ route('delete_employee' ,$item->employee_id)}}" class="btn btn-danger btn-sm" onclick="return confirm(`คุณต้องการลบ {{$item->username}} หรือไม่?`)">delete</a></td>          
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

