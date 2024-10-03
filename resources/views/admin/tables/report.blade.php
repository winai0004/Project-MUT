@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
<h5 class="text-center">ตารางรายงานสินค้าขายดี</h5>

<div class="overflow-auto p-3 bg-light" style=" max-height: 600px;">
    <form action="#" class="mb-2">
        <label for="day">เลือกวันที่ต้องการค้นหา:</label>
        <input type="date" id="day" name="day">
        <input type="submit">
      </form>

    <table id="example" class="table table-striped border" style="width:100%">
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>ชื่อสินค้า</th>
                <th>ราคา</th>
                <th>จำนวนขาย</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach($data as $item)
                <tr>
                    <td>{{$item->stock_order}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->employee_name}}</td>
                    <td>{{$item->date_receiving}}</td>
                    <td>{{$item->time_receiving}}</td>
                    <td style="width:50px;">
                        @if($item->status == 0)
                            <a href="#" class="btn btn-warning btn-sm">Pending</a>
                        @elseif($item->status == 1)
                            <a href="#" class="btn btn-success btn-sm">Success</a>
                        @elseif($item->status == 2)
                            <a href="#" class="btn btn-danger btn-sm">Failed</a>
                        @endif
                    </td>          
                    <td><a href="{{ route('stock_edit', $item->stock_id)}}" class="btn btn-warning btn-sm">แก้ไข</a></td>
                    <td>
                        <form action="{{ route('stock_delete', $item->stock_id) }}" method="POST" onsubmit="return confirm('คุณต้องการลบ {{$item->name}} หรือไม่?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">ลบ</button>
                        </form>
                    </td>
                </tr>
            @endforeach --}}
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