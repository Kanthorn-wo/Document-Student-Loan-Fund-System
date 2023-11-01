@extends('layout.default')

@section('content')

<div class="container">

  <div class="card col-xl-10 col-lg-12 col-md-9 mt-5">
    <div class="card-body ">
      <div class="text-center">
        <h1 class="title-login h4 text-gray-900 mb-4">ลงทะเบียนผู้ใช้งาน</h1>
      </div>
      <form action="{{ route('register.insert') }}" method="post">
        @csrf
        @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert" id="alert">
          <ul class="pl-4 my-2">
            <li id="success">{{ session('success') }}</li>
          </ul>
        </div>
        @endif

        <div class="mb-3">
          <label for="student_id" class="form-label text-dark">รหัสนักศึกษา</label>
          <span class="small text-danger">* ใช้ในการเข้าสู่ระบบ</span>
          <input id="student_id" type="text" class="form-control @error('student_id') is-invalid @enderror"
            name="student_id" value="{{ old('student_id') }}" required autocomplete="student_id" autofocus
            placeholder="กรอกรหัสนักศึกษา (ตัวอย่าง 6X123456789-0)">
          @error('student_id')
          <div class="invalid-feedback d-block">{{ $errors->first('student_id') }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="personal_id" class="form-label text-dark">รหัสประจำตัวประชาชน</label>
          <span class="small text-danger">*</span>
          <input id="personal_id" type="text" class="form-control @error('personal_id') is-invalid @enderror"
            name="personal_id" value="{{ old('personal_id') }}" required autocomplete="personal_id" autofocus
            placeholder="กรอก 13 หลักไม่ต้องเติมขีด">
          @error('personal_id')
          <div class="invalid-feedback d-block">{{ $errors->first('personal_id') }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="prefix_name" class="form-label text-dark">คำนำหน้า</label>
          <span class="small text-danger">*</span>
          <select class="form-control" name="prefix_name" autocomplete="prefix_name" autofocus>
            <option value="">-- เลือกคำนำหน้า --</option>
            @foreach ($prefix_data as $item)
            <option value="{{$item->prefix_name}}" {{ old('prefix_name')===$item->prefix_name ? 'selected' : '' }}>
              {{$item->prefix_name}}
            </option>
            @endforeach
          </select>
          @error('prefix_name')
          <div class="invalid-feedback d-block">{{ $errors->first('prefix_name') }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="first_name" class="form-label text-dark">ชื่อ</label>
          <span class="small text-danger">*</span>
          <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
            name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus
            placeholder="กรอกชื่อภาษาไทย">
          @error('first_name')
          <div class="invalid-feedback d-block">{{ $errors->first('first_name') }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="last_name" class="form-label text-dark">นามสกุล</label>
          <span class="small text-danger">*</span>

          <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
            name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus
            placeholder="กรอกนามสกุลภาษาไทย">
          @error('last_name')
          <div class="invalid-feedback d-block">{{ $errors->first('last_name') }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="email" class="form-label text-dark">อีเมล</label>
          <span class="small text-danger">*</span>
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
            value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="กรอกอีเมล">
          @error('email')
          <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="password" class="form-label text-dark">รหัสผ่าน</label>
          <span class="small text-danger">*
          </span>
          <input type="password" class="form-control" name="password" id="password"
            placeholder="ตัวอักษรผสมตัวเลข [A-Z,a-z,0-9] (8-32 ตัว)">
          @error('password')
          <div class="invalid-feedback d-block">{{ $errors->first('password') }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label text-dark">ยืนยันรหัสผ่าน</label>
          <span class="small text-danger">*</span>
          <input type="password" class="form-control" name="confirm-password"
            placeholder="ตัวอักษรผสมตัวเลข [A-Z,a-z,0-9] (8-32 ตัว)">
          @error('confirm-password')
          <div class="invalid-feedback d-block">{{ $errors->first('confirm-password') }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="faculty" class="form-label text-dark">คณะ</label>
          <span class="small text-danger">*</span>
          <select class="faculty form-control" name="faculty">
            <option value="">-- เลือกคณะ --</option>
            @foreach($faculties as $faculty)
            <option value=" {{ $faculty->id }}">{{
              $faculty->faculty_code}} | {{ $faculty->faculty_name }}</option>
            @endforeach
          </select>
          @error('faculty')
          <div class="invalid-feedback d-block">{{ $errors->first('faculty') }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="branch" class="form-label text-dark">สาขา</label>
          <span class="small text-danger">*</span>
          <select class="branch-dropdown form-control" name="branch">
            <option value="">เลือกสาขา</option>
          </select>
          @error('branch')
          <div class="invalid-feedback d-block">{{ $errors->first('branch') }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <input type="checkbox" id="policy" name="policy" value="" required>
          <span class="small text-danger">*</span>
          <label style="font-size:14px; " for="vehicle1"> ยอมรับ <a href="#" data-toggle="modal"
              data-target="#exampleModal">ข้อตกลงการใช้บริการ</a> และ
            <a href="#" data-toggle="modal" data-target="#exampleModal2">นโยบายความเป็นส่วนตัว</a></label>
          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">ข้อตกลงการใช้บริการ</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body p-4">
                  <div class="container">
                    <p style="text-indent: 2.5em;">
                      ข้อตกลงการใช้บริการ คือ เอกสารหรือข้อความที่กำหนดขึ้นเพื่อระบุเงื่อนไข, ข้อกำหนด,
                      และนโยบายที่ผู้ให้บริการกำหนดให้ผู้ใช้บริการปฏิบัติตามเมื่อเข้าถึงหรือใช้งานบริการดังกล่าว
                      ข้อตกลงการใช้บริการมักมีวัตถุประสงค์เพื่อกำกับดูเกี่ยวกับการให้บริการ, ควบคุมคุณภาพ,
                      ป้องกันการกระทำที่ไม่เหมาะสม, รวมถึงคุ้มครองลิขสิทธิ์และความเป็นส่วนตัวของผู้ใช้และผู้ให้บริการ
                    </p>
                    <p>1) ผู้ใช้ต้องสมัครสมาชิกและเข้าสู่ระบบก่อนที่จะสามารถส่งเอกสารได้</p>
                    <p>2) เอกสารที่ส่งเข้ามาจะต้องเป็นของตัวเอง หรือมีสิทธิ์ในการแจกจ่าย</p>
                    <p>3) เอกสารต้องไม่ละเมิดลิขสิทธิ์ ทรัพย์สินทางปัญญา หรือกฎหมายที่เกี่ยวข้อง</p>
                    <p>4) เอกสารต้องไม่มีเนื้อหาที่พาดพิง หรือก่อให้เกิดความเสื่อมเสียใด ๆ ต่อบุคคลอื่น</p>
                    <p>5) ขนาดของไฟล์เอกสารไม่ควรเกิน 10 MB และต้องเป็นไฟล์ประเภท PDF เท่านั้น</p>
                    <p>6) สำหรับเอกสารที่ไม่ผ่านการตรวจสอบ ผู้ใช้จะต้องดำเนินการเพื่อแก้ไขและส่งเอกสารใหม่</p>
                    <p>7) เว็บไซต์มีสิทธิ์ในการลบเอกสารที่ไม่เหมาะสม หรือไม่เป็นไปตามนโยบายที่กำหนด</p>
                    <p>8) ห้ามส่งเอกสารที่มีเนื้อหาที่ส่อเสียด ลามก หรือก่อให้เกิดความไม่สงบ</p>
                    <p>9) เว็บไซต์ขอสงวนสิทธิ์ในการปรับปรุงหรือแก้ไขเอกสารที่ไม่เป็นไปตามมาตรฐาน</p>
                    <p>10) ผู้ใช้ต้องยอมรับและปฏิบัติตามข้อกำหนดและเงื่อนไขของเว็บไซต์</p>
                    <p>11) การส่งเอกสารเข้ามาในเว็บไซต์นี้ถือว่าผู้ใช้ยอมรับและยินยอมให้เว็บไซต์นำเอกสารไปใช้งาน
                      หรือนำไปเผยแพร่ตามความเหมาะสม</p>
                    <p>12) เว็บไซต์ไม่รับผิดชอบต่อความคิดเห็นหรือข้อความที่แสดงอยู่ในเอกสารที่ส่งเข้ามา</p>
                    <p>13) ผู้ใช้ควรเก็บรักษาสำเนาของเอกสารที่ส่งเข้ามาเพื่อป้องกันความสูญเสีย</p>
                    <p>
                      14) เว็บไซต์ขอสงวนสิทธิ์ในการเปลี่ยนแปลงนโยบายการส่งเอกสารในเว็บไซต์โดยไม่ต้องแจ้งให้ทราบล่วงหน้า
                    </p>

                  </div>

                </div>
                <div class=" modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>

                </div>
              </div>
            </div>
          </div>
          <!-- End Modal -->

          <!-- Modal -->
          <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">นโยบายความเป็นส่วนตัว</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body p-4">
                  <div class="container">
                    <p style="text-indent: 2.5em;">
                      นโยบายความเป็นส่วนตัว คือ เอกสารหรือข้อความที่อธิบายถึงวิธีการที่องค์กร, บริษัท,
                      หรือเว็บไซต์จัดการกับข้อมูลส่วนตัวของผู้ใช้งานหรือลูกค้า
                      นโยบายนี้มักประกอบด้วยข้อมูลเกี่ยวกับวิธีการเก็บรวบรวม, ใช้, ปกป้อง,
                      และเปิดเผยข้อมูลส่วนตัวของผู้ใช้งาน
                    </p>
                    <p>1) การเก็บข้อมูลส่วนตัว: เว็บไซต์จะเก็บข้อมูลส่วนตัวของผู้ใช้เมื่อมีการสมัครสมาชิกหรือใช้บริการ
                      เช่น ชื่อ, นามสกุล, ที่อยู่อีเมล, และข้อมูลการใช้งาน</p>
                    <p>2) วัตถุประสงค์ในการใช้ข้อมูล: เว็บไซต์ใช้ข้อมูลส่วนตัวเพื่อปรับปรุงคุณภาพบริการ,
                      สื่อสารกับผู้ใช้, และป้องกันการใช้งานที่ไม่เหมาะสม</p>
                    <p>3) การเปิดเผยข้อมูลส่วนตัว: เว็บไซต์จะไม่เปิดเผยข้อมูลส่วนตัวของผู้ใช้ให้แก่บุคคลที่สาม
                      นอกจากได้รับความยินยอมจากผู้ใช้ หรือตามคำสั่งของหน่วยงานที่มีอำนาจตามกฎหมาย</p>
                    <p>4) การรักษาความปลอดภัย:
                      เว็บไซต์มีมาตรการความปลอดภัยเพื่อป้องกันการเข้าถึงข้อมูลส่วนตัวของผู้ใช้โดยไม่ได้รับอนุญาต
                      แต่ไม่สามารถรับประกันได้ 100% ว่าข้อมูลจะปลอดภัยอยู่เสมอ</p>
                    <p>5) การแก้ไขข้อมูลส่วนตัว: ผู้ใช้สามารถแก้ไขข้อมูลส่วนตัวของตัวเองผ่านทางระบบของเว็บไซต์
                      หากข้อมูลส่วนตัวมีการเปลี่ยนแปลง</p>
                    <p>6) การเชื่อมโยงไปยังเว็บไซต์อื่น: เว็บไซต์อาจมีการเชื่อมโยงไปยังเว็บไซต์อื่น ๆ
                      ซึ่งเว็บไซต์ไม่สามารถควบคุมหรือรับผิดชอบในนโยบายความเป็นส่วนตัวของเว็บไซต์เหล่านั้น</p>
                    <p>7) การเปลี่ยนแปลงนโยบายความเป็นส่วนตัว:
                      เว็บไซต์ขอสงวนสิทธิ์ในการเปลี่ยนแปลงนโยบายความเป็นส่วนตัวในเว็บไซต์โดยไม่ต้องแจ้งให้ทราบล่วงหน้า
                      และขอแนะนำให้ผู้ใช้ตรวจสอบนโยบายความเป็นส่วนตัวอย่างประจำ</p>

                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>

                </div>
              </div>
            </div>
          </div>
          <!-- End Modal -->
        </div>
        <button type="submit" class="btn btn-primary">ลงทะเบียน</button>
        <div class="mt-2">
          <a class="small" href="{{ route('user.login') }}">เข้าสู่ระบบ
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts_default')

<script type="text/javascript">
  $('.faculty').change(function () { 
    const select = $(this).val();
    const _token = $('input[name="_token"]').val();

    $.ajax({
      type: "POST",
      url: "/get-branch",
      data: {select:select,_token:_token},

      success: function (response) {
          $('.branch-dropdown').html(response);
          console.log(response);
      }
    });
  });
 
</script>

@if(session()->has('message'))
<script>
  Swal.fire({
  icon: 'info',
  title: 'ไม่อยู่ในช่วงเวลาส่งเอกสาร',
  text: 'ระบบจะเปิดให้ส่งเอกสารวันที่ {{ session()->get('message') }}',
  showConfirmButton: true,
  
})
</script>

@endif


@endpush