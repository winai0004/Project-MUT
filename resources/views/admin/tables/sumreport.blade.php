@extends('layouts_admin.app_admin')

@section('content')
<div class="container px-5 my-5">
    <h5 class="text-center mb-4">รายงานยอดขายสินค้า รายปี (แบบ Crosstab)</h5>

    <!-- ฟอร์มให้เลือกช่วงปี -->
    <form action="{{ route('sumreport') }}" method="GET" class="mb-4">
        <div class="row align-items-end">
            <!-- ช่วงปีเริ่มต้น -->
            <div class="col-md-5 mb-3">
                <label for="start_year" class="form-label">เลือกช่วงปี:</label>
                <select name="start_year" id="start_year" class="form-select">
                    @foreach(range(2000, Carbon\Carbon::now()->year) as $year)
                        <option value="{{ $year }}" {{ $year == request()->input('start_year', Carbon\Carbon::now()->year) ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- ช่วงปีสิ้นสุด -->
            <div class="col-md-5 mb-3">
                <label for="end_year" class="form-label">ถึง:</label>
                <select name="end_year" id="end_year" class="form-select">
                    @foreach(range(2000, Carbon\Carbon::now()->year) as $year)
                        <option value="{{ $year }}" {{ $year == request()->input('end_year', Carbon\Carbon::now()->year) ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- ปุ่มค้นหา -->
            <div class="col-md-2 mb-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-lg w-100">ค้นหา</button>
            </div>
        </div>
    </form>

    <!-- ตารางข้อมูลยอดขาย -->
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>ชื่อสินค้า</th>
                @foreach($years as $year)
                    <th>{{ $year }} (ยอดขาย)</th>
                    <th>{{ $year }} (จำนวน)</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php $counter = 1; @endphp
            @forelse($groupedSalesData as $productName => $yearData)
                <tr>
                    <th scope="row">{{ $counter++ }}</th>
                    <td>{{ $productName }}</td>
                    @foreach($years as $year)
                        <td>{{ isset($yearData[$year]) ? number_format($yearData[$year]['total_sales'], 2) . ' บาท' : '-' }}</td>
                        <td>{{ isset($yearData[$year]) ? $yearData[$year]['total_quantity'] : '-' }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ 2 + (count($years) * 2) }}" class="text-center">ไม่พบข้อมูลที่ค้นหา</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
