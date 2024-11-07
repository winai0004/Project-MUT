@extends('layouts_admin.app_admin')

@section('content')
<div class="container px-5 my-5">
    <h5 class="text-center">รายงานยอดขายสินค้า รายปี</h5>

    <form action="{{ route('sumreport') }}" method="GET" class="mb-2">
        <label for="start_date">วันที่เริ่มต้น:</label>
        <input type="date" id="start_date" name="start_date" value="{{ $startDate ?? Carbon\Carbon::now()->startOfYear()->toDateString() }}" required>

        <label for="end_date">วันที่สิ้นสุด:</label>
        <input type="date" id="end_date" name="end_date" value="{{ $endDate ?? Carbon\Carbon::now()->toDateString() }}" required>

        <input type="submit" value="ค้นหา" class="btn btn-primary">
    </form>

    <table id="example" class="table table-striped border" style="width:100%">
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>ชื่อสินค้า</th>
                <th>จำนวนคำสั่งซื้อ</th>
                <th>ยอดขายรวม</th>
                <th>จำนวนที่ขายรวม</th>
            </tr>
        </thead>
        <tbody>
            @php $counter = 1; @endphp
            @forelse($groupedSalesData as $data)
                <tr>
                    <th scope="row">{{  $counter++ }}</th>
                    <td>{{ $data['product_name'] }}</td>
                    <td>{{ $data['total_orders'] }}</td>
                    <td>{{ number_format($data['total_sales'], 2) }} บาท</td>
                    <td>{{ $data['total_quantity'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">ไม่พบข้อมูลที่ค้นหา</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection
