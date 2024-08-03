@extends('layouts_admin.app_admin')

@section('content')

<div class="container px-5 my-5 ">
    <div class="container ">
        <h5 class="text-center">เพิ่มข้อมูลระดับสมาชิก</h5>

        <div class="row d-flex justify-content-center">
            <div class="col-md-9  ">
                <div class="form">
                    <form method="post" action="{{ route('insert_membershiplevel') }}" class="mt-5 border p-4 bg-light shadow">
                        @csrf
                        <h4 class="mb-3 text-secondary">เพิ่มข้อมูลระดับสมาชิก</h4>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label>ชิ่อระดับสมาชิก<span class="text-danger">*</span></label>
                                <input type="text" name="membership_level_name" class="form-control">
                            </div>
                            @error('title')
                            <div class="mb-1">
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                            @enderror
                            <div class="mb-3 col-md-6">
                                <label>คะแนนเริ่มต้น<span class="text-danger">*</span></label>
                                <input type="number" name="minscore" class="form-control"  min="1" max="20000">
                                @error('minscore')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label>คะแนนสูงสุด<span class="text-danger">*</span></label>
                                <input type="number" name="maxscore"  min="1" max="20000" class="form-control">
                                @error('maxscore')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary float-end" type="submit">บันทึก</button>
                                <a href="{{ route('membershiplevel') }}"><button class="btn btn-danger float-end me-2" type="button">กลับ</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

 