@extends('layout.default')
@section('content')
<style>
  @media only screen and (max-width:500px) {

    .title-login {
      font-size: 20px;
    }
  }
</style>
@php
// use App\Models\User;
// use Illuminate\Support\Facades\Auth;

// session_start();

// if (!empty($_SESSION['_login_info'])) {
// $test = json_encode($_SESSION['_login_info']);
// $obj = json_decode($test);
// $user_db = User::where('student_id','=',$obj->studentId)->first();
// if(!empty($user_db)){
// $data_sso = Auth::login($user_db);

// header('Location: https://dosl.rmuti.ac.th');
// Session::flush();
// header('Location: https://www.dosl.rmuti.ac.th/sso/?logout&redirect=https://www.dosl.rmuti.ac.th');



// }else{
// $faculty_cut = $obj->faculty;
// $branch_cut = $obj->program;
// $data = array();
// $data['student_id'] = $obj->studentId;
// $data['personal_id'] = $obj->personalId;
// $data['prefix_name'] = $obj->prename;
// $data['first_name'] = $obj->firstNameThai;
// $data['last_name'] = $obj->lastNameThai;
// $data['email'] = $obj->mail;
// $data['password'] = bcrypt($obj->personalId);
// $data['faculty'] = Str::after($faculty_cut, 'คณะ');
// $data['branch'] = Str::after($branch_cut, 'สาขาวิชา');
// $data['created_at'] = now();
// $data['updated_at'] = now();
// DB::table('users')->insert($data);

// header('Location: https://dosl.rmuti.ac.th');
// Session::flush();
// header('Location: https://www.dosl.rmuti.ac.th/sso/?logout&redirect=https://www.dosl.rmuti.ac.th');


// }

// }

@endphp
<div class="container">
  <!-- Outer Row -->
  <div class="row justify-content-center">
    <div class="col-xl-10 col-lg-12 col-md-9">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            {{-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> --}}
            <div class="col-lg-12">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="title-login h4 text-gray-900 mb-4">เข้าสู่ระบบสำหรับนักศึกษา</h1>
                </div>


                @if (session('success'))
                <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert"
                  id="alert">

                  <div id="success">{{ session('success') }}</div>

                </div>
                @endif


                <form action="{{ route('user.handleLogin') }}" method="post">
                  @csrf
                  <div class="form-group">
                    <input id="student_id" type="text" class="form-control @error('student_id') is-invalid @enderror"
                      name="student_id" value="{{ old('student_id') }}" required autocomplete="student_id" autofocus
                      placeholder="รหัสนักศึกษา">
                    @error('student_id')
                    <div class="invalid-feedback d-block">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" placeholder="รหัสผ่าน" name="password"
                      required />
                    @error('password')
                    <div class="invalid-feedback d-block">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox small">
                      <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                      <label class="custom-control-label" for="remember">Remember Me</label>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary btn-user btn-block">
                    เข้าสู่ระบบ
                  </button>
                  <a href="sso?sso" class="btn btn-warning btn-user btn-block text-dark" onclick="">
                    ลงทะเบียนด้วยบัญชีอินเทอร์เน็ต มทร. อีสาน
                  </a>

                </form>

                <div class="text-center">
                  {{-- <a class="small" href="forgot-password.html">Forgot Password?</a> --}}
                </div>
                <div class="text-center mt-2">
                  <a class="small" href="{{ route('register') }}">ลงทะเบียนผู้ใช้งาน
                  </a>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts_default')
@if(session()->has('success_sso'))
<script>
  Swal.fire({
    icon: 'success',
    title: '{{ session()->get('success_sso') }}',
    html: 'ID: รหัสนักศึกษา<br>Password: รหัสบัตรประจำตัวประชาชน',
    confirmButtonText: 'OK'
  });
  header('Location: https://www.dosl.rmuti.ac.th/sso/?logout&redirect=https://www.dosl.rmuti.ac.th/testsso');
</script>

@endif

@if(session()->has('success_insert_sso'))
<script>
  Swal.fire({
  title: '{{ session()->get('success_insert_sso') }}',
  html: 'ID: {{ session()->get('session_studentId') }}<br>Password: {{ session()->get('session_password') }}',
  icon: 'success',
  confirmButtonText: 'OK'
});
header('Location: https://www.dosl.rmuti.ac.th/sso/?logout&redirect=https://www.dosl.rmuti.ac.th/testsso');
</script>
@endif

@if(session()->has('message'))
<script>
  Swal.fire({
  icon: 'info',
  title: '{{ session()->get('message') }}',
  text: '',
  // showConfirmButton: true,
  
})
</script>

<script>
  $(document).ready(function () {
    if (hasSessionCookie("_login_info")) {
    // Session exists
    console.log("Session Have.");
} else {
    // Session does not exist
    console.log("Session does not exist.");
}
  });
</script>

<script>
  // Add an event listener for when the form is submitted
  document.querySelector('form').addEventListener('submit', function (event) {
    // If the "Remember Me" checkbox is checked, set a cookie with the user's login credentials
    if (document.querySelector('#remember:checked')) {
      document.cookie = 'student_id=' + encodeURIComponent(document.querySelector('input[name="student_id"]').value) + '; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/';
      document.cookie = 'password=' + encodeURIComponent(document.querySelector('input[name="password"]').value) + '; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/';
    } else {
      // If the "Remember Me" checkbox is not checked, remove any existing cookies
      document.cookie = 'student_id=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
      document.cookie = 'password=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
    }
  });
</script>

@endif

@endpush