@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
    <h5 class="text-center">ตารางรายงานสินค้าขายดี</h5>


    <br>
    <div class="container">
        <div class="row mb-3">
            <form action="{{ route('report') }}" method="GET" class="d-flex justify-content-between">
                <div class="col-md-3 me-2">
                    <label for="start_date">เลือกวันที่เริ่มต้น:</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $selectedStartDate ?? '' }}">
                </div>
                <div class="col-md-3 me-2">
                    <label for="end_date">เลือกวันที่สิ้นสุด:</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $selectedEndDate ?? '' }}">
                </div>
                <div class="col-md-3 me-2">
                    <label for="type">เลือกประเภท:</label>
                    <select id="type" name="type" class="form-control">
                        <option value="" disabled selected>เลือกประเภท</option>
                        <option value="type1" {{ (isset($selectedType) && $selectedType == 'type1') ? 'selected' : '' }}>ประเภท 1</option>
                        <option value="type2" {{ (isset($selectedType) && $selectedType == 'type2') ? 'selected' : '' }}>ประเภท 2</option>
                        <!-- เพิ่มตัวเลือกประเภทที่ต้องการ -->
                    </select>
                </div>
                <div class="col-md-12 mt-4">
                    <input type="submit" value="ค้นหา" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>

    <div class="overflow-auto p-3 bg-light" style="max-height: 600px;">
        
        

        <table id="example" class="table table-striped border" style="width:100%">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>รูปภาพ</th>
                    <th>ชื่อสินค้า</th>
                    <th>จำนวนขาย</th>
                </tr>
            </thead>
            <tbody>
                @php $counter = 1; @endphp
                @foreach($topSellingItems as $item) 
                    <tr>
                        <th scope="row">{{ $counter++ }}</th>
                        <td>
                            <img src="{{ asset('images/' . $item->image) }}"  
                                 alt="Item Image" 
                                 style="width:100px; height:auto;">
                        </td>
                        <td>{{ $item->name }}</td>  
                        <td>{{ $item->total_quantity }}</td> 
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(function(){
        $('#example').DataTable();
    });   
</script>

@endsection
