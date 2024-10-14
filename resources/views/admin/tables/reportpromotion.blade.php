@extends('layouts_admin.app_admin') 

@section('content')

<div class="container px-5 my-5">
    <h5 class="text-center">รายงานสรุปยอดโปรโมชั่น</h5>

    <div class="overflow-auto p-3 bg-light" style="max-height: 600px;">
        <!-- ฟอร์มสำหรับเลือกช่วงวันที่ในการค้นหา -->
        <form method="GET" action="{{ route('reportpromotion') }}" class="mb-2">
            <label for="start_date">วันที่เริ่มต้น:</label>
            <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="form-control mb-2">
            <label for="end_date">วันที่สิ้นสุด:</label>
            <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="form-control mb-2">
            <input type="submit" value="แสดงรายงาน" class="btn btn-primary">
        </form>

        <!-- ตารางสำหรับแสดงข้อมูลโปรโมชั่น -->
        <table id="example" class="table table-striped border" style="width:100%">
            <thead>
                <tr>
                    <th>ชื่อโปรโมชั่น</th>
                    <th>จำนวนยอดขาย</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($promotionSummary as $summary)
                    @php
                        // ค้นหาโปรโมชั่นจาก promotion_id ในตาราง promotion_data
                        $promotion = $promotions->firstWhere('id', $summary->promotion_id);
                    @endphp
                    <tr>
                        <td>{{ $promotion->name ?? 'ไม่มีข้อมูล' }}</td>
                        <td>{{ $summary->total_quantity }}</td>
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
