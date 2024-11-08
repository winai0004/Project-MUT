@extends('layouts_admin.app_admin')

@section('content')
<div class="container px-5 my-5">
    <h5 class="text-center mb-4">รายงานสรุปยอดโปรโมชั่น</h5>

    <div class="bg-light p-4 rounded shadow-sm">
        <!-- ฟอร์มค้นหา -->
        <form method="GET" action="{{ route('promotionsreport') }}" class="mb-4">
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="start_date">เลือกวันที่เริ่มต้น:</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request()->input('start_date', '2024-09-01') }}" class="form-control">
                </div>
                <div class="col-md-5 mb-3">
                    <label for="end_date">เลือกวันที่สิ้นสุด:</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request()->input('end_date', '2024-11-30') }}" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end mb-3">
                    <button type="submit" class="btn btn-primary w-100">แสดง</button>
                </div>
            </div>
        </form>

        <!-- ตารางแสดงข้อมูลรายงาน -->
        <div class="overflow-auto">
            <table id="promotionReportTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อสินค้า</th>
                        <th>ส่วนลด</th>
                        <th>จำนวนที่ขาย</th>
                        <th>ราคาที่ขายรวม</th>
                        <th>ราคาหลังหักส่วนลด</th>
                        <th>ยอดขายรวม</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $index => $report)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $report->product_name }}</td>
                        <td>{{ $report->discount }}%</td>
                        <td>{{ $report->total_quantity }}</td>
                        <td>{{ number_format($report->total_price, 2) }} บาท</td>
                        <td>{{ number_format($report->discount_price, 2) }} บาท</td>
                        <td>{{ number_format($report->total_sales, 2) }} บาท</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "paging": true,    // การแบ่งหน้า
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
