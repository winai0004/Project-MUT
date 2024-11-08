@extends('layouts_admin.app_admin')

@section('content')
<div class="container px-5 my-5">
    <h5 class="text-center mb-4">รายงานสินค้าที่ไม่ได้ขาย (ช่วงเวลา: {{ $startDate }} ถึง {{ $endDate }})</h5>

    <!-- ฟอร์มให้เลือกช่วงเวลาและเลือกประเภทสินค้า -->
    <form action="{{ route('reportunsold') }}" method="GET" class="mb-4">
        <div class="row">
            <!-- เลือกวันที่เริ่มต้น -->
            <div class="col-md-4 mb-3">
                <label for="start_date" class="form-label">เลือกวันที่เริ่มต้น:</label>
                <input type="date" name="start_date" value="{{ request()->input('start_date', Carbon\Carbon::now()->startOfYear()->toDateString()) }}" class="form-control">
            </div>
        
            <!-- เลือกวันที่สิ้นสุด -->
            <div class="col-md-4 mb-3">
                <label for="end_date" class="form-label">เลือกวันที่สิ้นสุด:</label>
                <input type="date" name="end_date" value="{{ request()->input('end_date', Carbon\Carbon::now()->toDateString()) }}" class="form-control">
            </div>
        
            <!-- เลือกประเภทสินค้า -->
            <div class="col-md-4 mb-3">
                <label for="category_id" class="form-label">เลือกประเภทสินค้า:</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="" {{ request()->input('category_id') == '' ? 'selected' : '' }}>ทุกประเภท</option> <!-- เพิ่มตัวเลือก 'ทุกประเภท' -->
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}" 
                                {{ $category->category_id == request()->input('category_id') ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary btn-lg">ค้นหา</button>
        </div>
    </form>
    
    <!-- ตารางแสดงข้อมูล -->
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>ชื่อสินค้า</th>
                <th>ประเภทสินค้า</th>
            </tr>
        </thead>
        <tbody>
            @forelse($unsoldProducts as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->category_name ?? 'ไม่มีประเภทสินค้า' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">ไม่พบสินค้าที่ไม่ได้ขายในช่วงเวลานี้</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
