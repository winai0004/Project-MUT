@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5">
    <h5 class="text-center">ตารางรายงานสินค้าที่สั่งซื้อเข้า Stock</h5>

    <div class="overflow-auto p-3 bg-light" style="max-height: 600px;">
        <!-- ฟอร์มสำหรับเลือกวันที่ในการค้นหา -->
        <form action="{{ route('reportstock') }}" method="GET" class="mb-2">
            <label for="day">เลือกวันที่ต้องการค้นหา:</label>
            <input type="date" id="day" name="day" value="{{ $selectedDate ?? '' }}">
            <input type="submit" value="ค้นหา">
        </form>

        <!-- ตารางสำหรับแสดงข้อมูลสินค้า -->
        <table id="example" class="table table-striped border" style="width:100%">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อสินค้า</th>
                    <th>จำนวนที่สั่งซื้อเข้า Stock</th>
                    <th>ราคาต่อหน่วย</th>
                    <th>Stock Order</th>
                </tr>
            </thead>
            <tbody>
                @php $counter = 1; @endphp
                @foreach($groupedItems as $item)
                    <tr>
                        <th scope="row">{{ $counter++ }}</th>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['total_quantity'] }}</td>
                        <td>{{ number_format($item['price'], 2) }} บาท</td>
                        <td>{{ $item['stock_order'] }}</td>
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
