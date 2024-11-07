@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5">
    <h5 class="text-center">รายงานสินค้าที่ขายไม่ได้</h5>

    <div class="overflow-auto p-3 bg-light" style="max-height: 600px;">
        <!-- ฟอร์มสำหรับเลือกวันที่ในการค้นหา -->
        <form action="{{ route('reportunsold') }}" method="GET" class="mb-2">
            <div class="form-row">
                <div class="col-md-3 mb-2">
                    <label for="start_date">เลือกวันที่เริ่มต้น:</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}">
                </div>
                <div class="col-md-3 mb-2">
                    <label for="end_date">เลือกวันที่สิ้นสุด:</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}">
                </div>
                <div class="col-md-3 mb-2">
                    <label for="category_id">เลือกประเภทสินค้า:</label>
                    <select id="category_id" name="category_id" class="form-control">
                        <option value="">-- ทุกประเภท --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}" {{ (isset($selectedCategory) && $selectedCategory == $category->category_id) ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2 d-flex align-items-end">
                    <input type="submit" value="ค้นหา" class="btn btn-primary">
                </div>
            </div>
        </form>

        <!-- ตารางสำหรับแสดงข้อมูลสินค้า -->
        <table id="example" class="table table-striped border" style="width:100%">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อสินค้า</th>
                    <th>ประเภทสินค้า</th>
                    <th>จำนวนที่มีอยู่ใน Stock</th>
                </tr>
            </thead>
            <tbody>
                @php $counter = 1; @endphp
                @foreach($groupedItems as $item)
                    <tr>
                        <th scope="row">{{ $counter++ }}</th>
                        <td>{{ $item['product_name'] }}</td>
                        <td>{{ $item['category_name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



@endsection
