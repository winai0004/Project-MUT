@extends('layouts_admin.app_admin')

@section('content')
<div class="container px-5 my-5">
    <h5 class="text-center">รายงานสรุปยอดโปรโมชั่น</h5>

    <div class="overflow-auto p-3 bg-light" style="max-height: 600px;">
        <form action="{{ route('promotionsreport') }}" method="GET" class="mb-2">
            <label for="day">เลือกวันที่ต้องการค้นหา:</label>
            <input type="date" id="day" name="day" value="{{ $selectedDate ?? '' }}">
            <input type="submit" value="ค้นหา" class="btn btn-primary">
        </form>

        <table id="example" class="table table-striped border" style="width:100%">
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
                        <td>{{ $item['discount'] }} %</td> <!-- แสดงส่วนลด -->
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
