@extends('layouts_admin.app_admin')

@section('content')
<div class="container px-5 my-5">
    <h5 class="text-center mb-4">รายงานสรุปยอดโปรโมชั่น</h5>

    <div class="overflow-auto p-3 bg-light" style="max-height: 600px;">
        <!-- ฟอร์มค้นหา -->
        <form action="{{ route('promotionsreport') }}" method="GET" class="mb-4">
            <div class="row align-items-end">
                <!-- วันที่เริ่มต้น -->
                <div class="col-md-5 mb-3">
                    <label for="start_date" class="form-label">เลือกวันที่เริ่มต้น:</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate ?? '' }}" class="form-control">
                </div>
                
                <!-- วันที่สิ้นสุด -->
                <div class="col-md-5 mb-3">
                    <label for="end_date" class="form-label">เลือกวันที่สิ้นสุด:</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate ?? '' }}" class="form-control">
                </div>

                <!-- ปุ่มค้นหา -->
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-lg w-100">ค้นหา</button>
                </div>
            </div>
        </form>

        <!-- ตารางแสดงข้อมูลโปรโมชั่น -->
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อสินค้า</th>
                    <th>ส่วนลด</th>
                </tr>
            </thead>
            <tbody>
                @php $counter = 1; @endphp
                @foreach($groupedItems as $item)
                <tr>
                    <th scope="row">{{ $counter++ }}</th>
                    <td>{{ $item['product_name'] }}</td>
                    <td>{{ isset($item['discount']) && $item['discount'] !== null ? $item['discount'] . ' %' : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
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
