@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
<<<<<<< HEAD
    <h5 class="text-center">ตารางรายงานสินค้าขายดี</h5>

    <div class="overflow-auto p-3 bg-light" style="max-height: 600px;">
        <form action="{{ route('report') }}" method="GET" class="mb-2">
            <label for="day">เลือกวันที่ต้องการค้นหา:</label>
            <input type="date" id="day" name="day" value="{{ $selectedDate ?? '' }}">
            <input type="submit" value="ค้นหา">
        </form>
=======
<h5 class="text-center">รายงานสินค้าขายดี</h5>

<div class="overflow-auto p-3 bg-light" style="max-height: 600px;">
    <form action="{{ route('report') }}" method="GET" class="mb-2">
        <label for="start_date">เลือกวันที่เริ่มต้น:</label>
        <input type="date" id="start_date" name="start_date" value="{{ $startDate ?? '' }}">
    
        <label for="end_date">เลือกวันที่สิ้นสุด:</label>
        <input type="date" id="end_date" name="end_date" value="{{ $endDate ?? '' }}">
    
        <label for="category_id">เลือกประเภทสินค้า:</label>
        <select id="category_id" name="category_id">
            <option value="">-- ทุกประเภท --</option>
            @foreach($categories as $category)
                <option value="{{ $category->category_id }}" {{ (isset($selectedCategory) && $selectedCategory == $category->category_id) ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
            @endforeach
        </select>
    
        <input type="submit" value="ค้นหา">
    </form>
    
>>>>>>> 0f3ab96d29a8836b962947b892e48a04285e2fc9

        <table id="example" class="table table-striped border" style="width:100%">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>รูปภาพ</th>
                    <th>ชื่อสินค้า</th>
                    <th>จำนวนขาย</th>
                </tr>
<<<<<<< HEAD
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

=======
            @endforeach
        </tbody>
    </table>
    
    
>>>>>>> 0f3ab96d29a8836b962947b892e48a04285e2fc9
<script>
    $(function(){
        $('#example').DataTable();
    });   
</script>

@endsection
