@extends('layout.default')
@section('content')
<style>
  @media only screen and (max-width:500px) {

    .title-login {
      font-size: 20px;
    }
  }
</style>
<div class="container">
  <!-- Outer Row -->
  <div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10 col-md-7 mt-5">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row p-5">
            {{-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> --}}
            <div class="col-lg-12 text-center ">
              <div class="mb-2">
                <a href="{{ route('staff.login') }}" class="btn btn-warning w-100">เข้าสู่ระบบสำหรับเจ้าหน้าที่</a>
              </div>
              <div>
                <a href="{{ route('admin.login') }}" class="btn btn-danger w-100">เข้าสู่ระบบสำหรับผู้ดูแลระบบ</a>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection