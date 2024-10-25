@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5">
    <h5 class="text-center">ฟอร์มเพิ่มข้อมูลโฆษณา</h5>

    <div class="row d-flex justify-content-center">
        <div class="col-md-9">
            <div class="form">
                <form method="post" action="{{ route('insert_advert') }}" enctype="multipart/form-data" class="mt-5 border p-4 bg-light shadow">
                    @csrf
                    <h4 class="mb-3 text-secondary">เพิ่มข้อมูลโฆษณา</h4>

                    <div class="mb-3 col-md-12">
                        <label>โฆษณา<span class="text-danger">*</span></label>
                        <input type="text" name="advertisement_name" class="form-control" required>
                        @error('advertisement_name')
                            <div class="mb-1">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-12">
                        <label>รูปโฆษณา<span class="text-danger">*</span></label>
                        <input type="file" name="advertisement_image" class="form-control" required>
                        @error('advertisement_image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-12">
                        <label>รายละเอียด<span class="text-danger">*</span></label>
                        <input type="text" name="description" class="form-control" required>
                        @error('description')
                            <div class="mb-1">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-12 d-flex justify-content-end">
                        <button class="btn btn-primary me-2" type="submit">บันทึก</button>
                        <a href="{{ route('advert') }}" class="btn btn-danger">กลับ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
