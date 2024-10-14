@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5">
    <h5 class="text-center">รายงานสินค้าที่ขายไม่ได้</h5>

    <div class="overflow-auto p-3 bg-light" style="max-height: 600px;">
        <!-- ฟอร์มสำหรับเลือกวันที่ในการค้นหา -->
        <form action="{{ route('reportunsold') }}" method="GET" class="mb-2">
            <label for="day">เลือกวันที่ต้องการค้นหา:</label>
            <input type="date" id="day" name="day" value="{{ $selectedDate ?? '' }}">
            <input type="submit" value="ค้นหา">
        </form>

        <!-- ตารางสำหรับแสดงข้อมูลสินค้า -->
        <table id="example" class="table table-striped border" style="width:100%">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>รูปภาพ</th>
                    <th>ชื่อสินค้า</th>
                    <th>จำนวนที่มีอยู่ใน Stock</th>
                </tr>
            </thead>
            <tbody>
                @php $counter = 1; @endphp
                @foreach($groupedItems as $item)
                    <tr>
                        <th scope="row">{{ $counter++ }}</th>
                        {{-- <td>
                            <img src="{{ asset('images/' . $item['image']) }}" 
                                 alt="{{ $item['product_name'] }}" 
                                 style="width:100px; height:auto;">
                        </td> --}}
                        <td>
                            <img src="{{ asset('images/' . $item['image']) }}" 
                                 {{-- alt="Item Image"  --}}
                                 style="width:100px; height:auto;">
                        </td>
                        <td>{{ $item['product_name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- ใช้ DataTables สำหรับการจัดการตาราง -->
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

@endsection