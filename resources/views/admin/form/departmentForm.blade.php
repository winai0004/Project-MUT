{{-- @extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
    <div class="container ">
    <h5 class="text-center">ฟอร์มเพิ่มข้อมูล</h5>

    <div class="row d-flex justify-content-center">
        <div class="col-md-9  ">
            <div class="form">
                <form method="post" action="{{ route('insert_department') }}" class="mt-5 border p-4 bg-light shadow">
                @csrf
                    <h4 class="mb-3 text-secondary">เพิ่มข้อมูล</h4>
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label>แผนก<span class="text-danger">*</span></label>
                            <input type="text" name="department_name" class="form-control" >
                        </div>
                        @error('title')
                            <div class="mb-1">
                                <span class="text-danger">{{$message}}</span>
                            </div>
                        @enderror
                        <div class="col-md-12">
                           <button class="btn btn-primary float-end" type="submit" >บันทึก</button>
                            <a href="{{route('department')}}"><button class="btn btn-danger float-end me-2" type="button">กลับ</button></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 
</div>



@endsection
 --}}


 @extends('layouts_admin.app_admin')

 @section('content')
 
 <div class="container px-5 my-5">
     <div class="container">
         <h5 class="text-center">ฟอร์มเพิ่มข้อมูลแผนก</h5>
         <div class="row d-flex justify-content-center">
             <div class="col-md-9">
                 <div class="form">
                     <form method="post" action="{{ route('insert_department') }}" class="mt-5 border p-4 bg-light shadow">
                         @csrf
                         <h4 class="mb-3 text-secondary">เพิ่มข้อมูลแผนก</h4>
                         <div class="row">
                             <div class="mb-3 col-md-12">
                                 <label>แผนก<span class="text-danger">*</span></label>
                                 <input type="text" name="department_name" class="form-control">
                                 @error('department_name')
                                     <span class="text-danger">{{$message}}</span>
                                 @enderror
                             </div>
                         </div>
 
                         <!-- เพิ่มส่วนสำหรับรับข้อมูลสิทธิ์ -->
                         {{-- <div id="rights">
                             <div class="row">
                                 <div class="mb-3 col-md-12">
                                     <label>สิทธิ์<span class="text-danger">*</span></label>
                                     <select name="rights[]" class="form-select">
                                         <option value="">เลือกสิทธิ์</option>
                                         <option value="สิทธิ์ที่ 1">สิทธิ์ที่ 1</option>
                                         <option value="สิทธิ์ที่ 2">สิทธิ์ที่ 2</option>
                                         <!-- เพิ่มตัวเลือกสิทธิ์ตามที่คุณต้องการ -->
                                     </select>
                                 </div>
                             </div>
                         </div> --}}

                         <div class="mb-3 col-md-12">
                            <label>สิทธิ์<span class="text-danger">*</span></label>
                            <select name="permission_id" class="form-select" aria-label="Default select example">
                                <option selected>เลือก permission</option>
                            @foreach($permission as $item)
                                <option value="{{ $item->permission_id  }}">{{ $item->permission_name }}</option>
                            @endforeach
                            </select>
                            @error('permission_id')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
 

                         {{-- <div class="mb-3 row">
                            <label for="permission" class="col-md-4 col-form-label text-md-end text-start">Permission</label>
                            <div class="col-md-6">           
                                <select class="form-select @error('permissions') is-invalid @enderror" multiple aria-label="permission" id="permission" name="permission[]" style="height: 210px;">
                                    @forelse ($permission as $permissionId)
                                        <option value="{{ $permissionId->permission_id  }}" {{ in_array($permissionId->permission_id , old('permission') ?? []) ? 'selected' : '' }}>
                                            {{ $permissionId->permission_name }}
                                        </option>
                                    @empty
    
                                    @endforelse
                                </select>
                                @if ($errors->has('permission'))
                                    <span class="text-danger">{{ $errors->first('permission') }}</span>
                                @endif
                            </div>
                        </div> --}}

                         <div class="row">
                             <div class="col-md-12">
                                 <button class="btn btn-primary float-end" type="submit" >บันทึก</button>
                                 <button class="btn btn-secondary float-end me-2" type="button" onclick="addRight()">เพิ่มสิทธิ์</button>
                                 <a href="{{route('department')}}"><button class="btn btn-danger float-end me-2" type="button">กลับ</button></a>
                             </div>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>
 
 <script>
     function addRight() {
         var rightsContainer = document.getElementById('rights');
         var newRightInput = document.createElement('div');
         newRightInput.classList.add('row');
         newRightInput.innerHTML = `
             <div class="mb-3 col-md-12">
                 <label>สิทธิ์<span class="text-danger">*</span></label>
                 <select name="rights[]" class="form-select">
                     <option value="">เลือกสิทธิ์</option>
                     <option value="สิทธิ์ที่ 1">สิทธิ์ที่ 1</option>
                     <option value="สิทธิ์ที่ 2">สิทธิ์ที่ 2</option>
                     <!-- เพิ่มตัวเลือกสิทธิ์ตามที่คุณต้องการ -->
                 </select>
             </div>
         `;
         rightsContainer.appendChild(newRightInput);
     }
 </script>
 
 @endsection
 