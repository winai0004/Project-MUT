@extends('layouts_admin.app_admin')

@section('content')
<div class="container px-5 my-5">
    <h5 class="text-center">รายงานยอดขายสินค้า รายปี</h5>

    <form action="{{ route('sumreport') }}" method="GET" class="mb-2">
        <label for="start_date">วันที่เริ่มต้น:</label>
        <input type="date" id="start_date" name="start_date" value="{{ $startDate ?? '' }}">

        <label for="end_date">วันที่สิ้นสุด:</label>
        <input type="date" id="end_date" name="end_date" value="{{ $endDate ?? '' }}">

        <input type="submit" value="ค้นหา">
    </form>

    <table id="example" class="table table-striped border" style="width:100%">
        <thead>
            <tr>
                <th>วันที่ขาย</th>
                <th>จำนวนคำสั่งซื้อ</th>
                <th>ยอดขายรวม</th>
                <th>จำนวนที่ขายรวม</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salesData as $data)
                <tr>
                    <td>{{ $data->sale_date }}</td>
                    <td>{{ $data->total_orders }}</td>
                    <td>{{ number_format($data->total_sales, 2) }} บาท</td>
                    <td>{{ $data->total_quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

@endsection
