@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5">
    <h5 class="text-center">รายงานสินค้าที่สั่งซื้อเข้า Stock</h5>

    <div class="overflow-auto p-3 bg-light" style="max-height: 600px;">
        <!-- ฟอร์มสำหรับเลือกวันที่ในการค้นหา -->
        <form action="{{ route('reportstock') }}" method="GET" class="mb-2">
            <label for="start_date">เลือกวันที่เริ่มต้น:</label>
            <input type="date" id="start_date" name="start_date" value="{{ $startDate ?? '' }}">

            <label for="end_date">เลือกวันที่สิ้นสุด:</label>
            <input type="date" id="end_date" name="end_date" value="{{ $endDate ?? '' }}">

            <label for="category">เลือกประเภทสินค้า:</label>
            <select id="category" name="category">
                <option value="">-- ทุกประเภท --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->category_id }}" {{ (isset($selectedCategory) && $selectedCategory == $category->category_id) ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>

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