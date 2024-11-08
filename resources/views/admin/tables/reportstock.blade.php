@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5">
    <h5 class="text-center mb-4">รายงานสินค้าที่สั่งซื้อเข้า Stock</h5>

    <div class="overflow-auto p-3 bg-light" style="max-height: 600px;">
        <!-- ฟอร์มสำหรับเลือกวันที่ในการค้นหา -->
        <form action="{{ route('reportstock') }}" method="GET" class="mb-4">
            <div class="row align-items-end">
                <!-- วันที่เริ่มต้น -->
                <div class="col-md-3 mb-3">
                    <label for="start_date" class="form-label">เลือกวันที่เริ่มต้น:</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate ?? '' }}" class="form-control">
                </div>

                <!-- วันที่สิ้นสุด -->
                <div class="col-md-3 mb-3">
                    <label for="end_date" class="form-label">เลือกวันที่สิ้นสุด:</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate ?? '' }}" class="form-control">
                </div>

                <!-- ประเภทสินค้า -->
                <div class="col-md-3 mb-3">
                    <label for="category" class="form-label">เลือกประเภทสินค้า:</label>
                    <select id="category" name="category" class="form-select">
                        <option value="">ทุกประเภท</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}" {{ (isset($selectedCategory) && $selectedCategory == $category->category_id) ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- ปุ่มค้นหา -->
                <div class="col-md-3 mb-3 d-flex align-items-end ms-auto">
                    <button type="submit" class="btn btn-primary btn-lg w-100">ค้นหา</button>
                </div>
                
            </div>
        </form>

        <!-- ตารางสำหรับแสดงข้อมูลสินค้า -->
        <div class="table-responsive">
            <table id="example" class="table table-bordered table-hover table-striped" style="width:100%">
                <thead class="table-light">
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
</div>

<!-- ใช้ DataTables สำหรับการจัดการตาราง -->
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "paging": true,    // การแบ่งหน้า
            "searching": true, // การค้นหาภายในตาราง
            "ordering": true,  // การจัดเรียงข้อมูล
            "info": true,      // การแสดงข้อมูลเกี่ยวกับจำนวนข้อมูลทั้งหมด
            "lengthMenu": [10, 25, 50, 100]  // กำหนดจำนวนแถวที่แสดงในแต่ละหน้า
        });
    });
</script>

@endsection
