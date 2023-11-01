@extends('layout.stafftemplate')
@section('content')

@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert" id="alert">
  <ul class="pl-4 my-2">
    <li id="success">{{ session('success') }}</li>
  </ul>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger border-left-danger" role="alert">
  <ul class="pl-4 my-2">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>

    @endforeach
  </ul>
</div>
@endif
<div class="row">

  <div class="col-lg-4 order-lg-2">

    <div class="card shadow mb-4">
      <div class="card-profile-image mt-4">
        <div class="row">
          <div class="col-lg-12">

            <div class="text-center">
              <img class="rounded-circle img-responsive center-block" src="{{ asset('assets/img/user.svg') }}" alt="..."
                style="max-width: 300px;">
            </div>


          </div>
        </div>

      </div>
      <div class=" card-body">

        <div class="row">
          <div class="col-lg-12">
            <div class="text-center">
              <h5 class="font-weight-bold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h5>
              <p>สิทธิ์ผู้ใช้งาน : {{ Auth::user()->role }}</p>
            </div>
          </div>
        </div>


      </div>
    </div>

  </div>

  <div class="col-lg-8 order-lg-1">

    <div class="card shadow mb-4">

      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">My Account</h6>
      </div>

      <div class="card-body">

        <form method="POST" action="{{ route('staff.update', ['id' => Auth::user()->id]) }}" autocomplete="off">
          @csrf


          <h6 class="heading-small text-muted mb-4">Staff information</h6>

          <div class="pl-lg-4">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group focused">
                  <label class="form-control-label" for="name">ชื่อ<span class="small text-danger">*</span></label>
                  <input type="text" id="name" class="form-control" name="name" placeholder="Name"
                    value="{{ old('name', Auth::user()->first_name) }}">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group focused">
                  <label class="form-control-label" for="last_name">นามสกุล</label>
                  <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Last name"
                    value="{{ old('name', Auth::user()->last_name) }}">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="email">อีเมล<span class="small text-danger">*</span></label>
                  <input type="email" id="email" class="form-control" name="email" placeholder="example@example.com"
                    value="{{ old('name', Auth::user()->email) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="rank">ตำแหน่ง<span class="small text-danger">*</span></label>
                  <input type="text" id="email" class="form-control" name="rank" placeholder=""
                    value="{{ old('name', Auth::user()->rank) }}">
                </div>
              </div>

            </div>



            <div class="row">
              <div class="col-lg-4">
                <div class="form-group focused">
                  <label class="form-control-label" for="current_password">รหัสผ่านปัจจุบัน</label>
                  <input type="password" id="current_password" class="form-control" name="current_password"
                    placeholder="Current password">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group focused">
                  <label class="form-control-label" for="new_password">รหัสผ่านใหม่</label>
                  <input type="password" id="new_password" class="form-control" name="new_password"
                    placeholder="New password">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group focused">
                  <label class="form-control-label" for="confirm_password">ยืนยัน รหัสผ่านใหม่</label>
                  <input type="password" id="confirm_password" class="form-control" name="password_confirmation"
                    placeholder="Confirm password">
                </div>
              </div>
            </div>
          </div>

          <!-- Button -->
          <div class="pl-lg-4">
            <div class="row">
              <div class="col text-center">
                <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
              </div>
            </div>
          </div>
        </form>

      </div>

    </div>

  </div>

</div>
@endsection