@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
    <h5 class="text-center">ตารางแสดงข้อมูลโฆษณา</h5>

    <div class="overflow-auto p-3 bg-light" style=" max-height: 600px;">
        <div class="mb-2 d-flex justify-content-end">
            <a href="{{route('form_advert')}}" class="btn btn-primary btn-sm">เพิ่มข้อมูล</a>
        </div>
        <table id="example" class="table table-striped border" style="width:100%">
            <thead>
                <tr>
                    <th>Advert ID</th>
                    <th>Advert Name</th>
                    <th>Advert Image</th>
                    <th>Description</th>
                    <th >edit</th>
                    <th >delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($advert as $item)
                    <tr>
                        <td>{{$item->advertisement_id}}</td>
                        <td>{{$item->advertisement_name}}</td>
                        <td>
                            <img src="{{ asset('storage/advert/' . $item->advertisement_image) }}" alt="{{ $item->advertisement_name }}" style="width: 100px; height: auto;">
                        </td>
                        <td>{{$item->description}}</td>
                        <td style="width:50px;">
                            <a href="{{ route('edit_advert', $item->advertisement_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                        <td style="width:50px;">
                            <a href="{{ route('delete_advert', $item->advertisement_id) }}" class="btn btn-danger btn-sm" onclick="return confirm(`คุณต้องการลบ {{$item->advertisement_name}} หรือไม่?`)">Delete</a>
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
