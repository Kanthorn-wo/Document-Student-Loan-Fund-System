@extends('layout.default')
@section('content')

<div class="container">
  <div class="card w-50 mx-auto mt-5">
    <div class="card-body ">
      <form action="{{ route('staff.handleLogin') }}" method="post">
        @csrf
        <h3>เข้าสู่ระบบสำหรับเจ้าหน้าที่</h3>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">อีเมล</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email"
            value="{{ old('email') }}">
          @error('email')
          <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">รหัสผ่าน</label>
          <input type="password" class="form-control" id="exampleInputPassword1" name="password" value="">
          @error('password')
          <div class="invalid-feedback d-block">{{ $errors->first('password') }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">เข้าสู่ระบบ</button>


      </form>
      <a href="{{ route('select') }}">
        <button class=" mt-3 btn btn-secondary w-100">ย้อนกลับ</button>
      </a>

    </div>
  </div>

</div>
</div>
@endsection