@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5">
    <h5 class="text-center mb-4">รายงานต้นทุนสินค้าที่ขาย</h5>

    <div class="overflow-auto p-3 bg-light" style="max-height: 600px;">
        <!-- ฟอร์มสำหรับเลือกวันที่ในการค้นหา -->
        <form action="{{ route('costreport') }}" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label for="start_date" class="form-label">วันที่เริ่มต้น:</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate ?? '' }}" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label for="end_date" class="form-label">วันที่สิ้นสุด:</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate ?? '' }}" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2 d-flex align-items-end">
                    <input type="submit" value="ค้นหา" class="btn btn-primary w-100">
                </div>
            </div>
        </form>

        <!-- ตารางสำหรับแสดงข้อมูลต้นทุนสินค้า -->
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>ต้นทุนต่อหน่วย</th>
                    <th>จำนวนที่ขาย</th>
                    <th>ต้นทุนรวม</th>
                </tr>
            </thead>
            <tbody>
                @php $counter = 1; @endphp
                @if($costReport->isNotEmpty())
                    @foreach($costReport as $report)
                        <tr>
                            <th scope="row">{{ $counter++ }}</th>
                            <td>{{ $report['product_id'] }}</td>
                            <td>{{ $report['product_name'] }}</td>
                            <td>{{ number_format($report['cost_price'], 2) }} บาท</td>
                            <td>{{ $report['total_quantity'] }}</td>
                            <td>{{ number_format($report['total_cost'], 2) }} บาท</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">ไม่มีข้อมูลในการแสดง</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
