@extends('layouts_admin.app_admin')

@section('content')
<div class="container px-5 my-5">
    <h5 class="text-center mb-4">รายงานสินค้าขายดี</h5>

    <!-- ฟอร์มค้นหา -->
    <form action="{{ route('report') }}" method="GET" class="mb-4">
        <div class="row align-items-end">
            <!-- วันที่เริ่มต้น -->
            <div class="col-md-4 mb-3">
                <label for="start_date" class="form-label">เลือกวันที่เริ่มต้น:</label>
                <input type="date" id="start_date" name="start_date" value="{{ $selectedStartDate ?? '' }}" class="form-control">
            </div>
            
            <!-- วันที่สิ้นสุด -->
            <div class="col-md-4 mb-3">
                <label for="end_date" class="form-label">เลือกวันที่สิ้นสุด:</label>
                <input type="date" id="end_date" name="end_date" value="{{ $selectedEndDate ?? '' }}" class="form-control">
            </div>

            <!-- เลือกประเภทสินค้า -->
            <div class="col-md-3 mb-3">
                <label for="type" class="form-label">เลือกประเภทสินค้า:</label>
                <select id="type" name="type" class="form-control">
                    <option value="" selected>ทุกประเภท</option> <!-- ตัวเลือก "ทุกประเภท" -->
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}" {{ (isset($selectedCategoryId) && $selectedCategoryId == $category->category_id) ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- ปุ่มค้นหา -->
            <div class="col-md-1 mb-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-lg w-100">ค้นหา</button>
            </div>
        </div>
    </form>

    <!-- ตารางแสดงข้อมูลสินค้าขายดี -->
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>รูปภาพ</th>
                <th>ชื่อสินค้า</th>
                <th>จำนวนขาย</th>
            </tr>
        </thead>
        <tbody>
            @php $counter = 1; @endphp
            @foreach($topSellingItems as $item)
            <tr>
                <th scope="row">{{ $counter++ }}</th>
                <td>
                    <img src="{{ asset('images/' . $item->image) }}" alt="Item Image" style="width:100px; height:auto;">
                </td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->total_quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "pageLength": 4,  // แสดง 4 แถวต่อหน้า
            "lengthMenu": [  // ให้เลือกจำนวนแถวที่จะแสดงได้
                [4, 10, 25, 50],
                [4, 10, 25, 50] // ตัวเลือกให้แสดง 4, 10, 25, 50 แถว
            ],
            "language": {
                "lengthMenu": "แสดง _MENU_ รายการต่อหน้า",
                "zeroRecords": "ไม่พบข้อมูล",
                "info": "แสดงหน้าที่ _PAGE_ จาก _PAGES_",
                "infoEmpty": "ไม่มีข้อมูล",
                "infoFiltered": "(ค้นหาจาก _MAX_ รายการทั้งหมด)",
                "search": "ค้นหา:",
                "paginate": {
                    "first": "แรก",
                    "last": "สุดท้าย",
                    "next": "ถัดไป",
                    "previous": "ก่อนหน้า"
                }
            }
        });
    });
</script>

@endsection
