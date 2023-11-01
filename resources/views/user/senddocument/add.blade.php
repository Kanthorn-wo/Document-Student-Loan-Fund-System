@extends('layout.usertemplate')
@section('content')
<style>
  .logo-rmuti {
    width: 100%;

  }

  .logo-loan {
    width: 100%;

  }

  .container-loan {
    padding: 20px;
    border: 1px solid black;
    border-radius: 10px;

  }

  .top {

    display: grid;
    grid-template-columns: 10% 70% 20%;
    text-align: center;
    align-items: center;
    font-size: 30px;
    color: #3D3C67;
    margin-bottom: 20px;
  }

  .middle {

    display: flex;
    font-size: 22px;
    display: flex;
    align-items: center;
    background-color: #FFF2C0;
    word-wrap: break-word;
    color: black;
    margin-bottom: 20px;
  }

  .bottom {

    display: flex;
    font-size: 22px;
    display: flex;
    align-items: center;
    background-color: #FFDFDF;
    word-wrap: break-word;
    color: black;
  }

  @media only screen and (max-width:500px) {
    .top {
      font-size: 16px;
    }

    .middle {
      font-size: 14px;
    }

    .bottom {
      font-size: 14px;
    }

  }
</style>
<div class="row">
  <div class="col-lg-12 order-lg-1">
    <div class="card shadow mb-4">
      <div class="card-header d-flex">
        <a href="{{ route('user.senddocument.index') }}">
          <h6 class="m-0 font-weight-bold text-primary">ส่งเอกสาร</h6>
        </a>
        <h6 class="m-0 font-weight-bold text-gray mr-1 ml-1">/</h6>
        <h6 class="m-0 font-weight-bold text-gray">{{ $file_doc->subject }}</h6>
        @if($file_doc->note != NULL)
        <h6 class="m-0  text-danger ml-4">*หมายเหตุ : {{ $file_doc->note }}</h6>
        @endif

      </div>
      <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
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
        <div class="pl-lg-4">
          <form action="{{ url('/user/senddocument/add/'.$file_doc->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-lg-3">
                <div class="form-group focused">
                  <label class="form-control-label" for="student_id">รหัสนักศึกษา<span
                      class="small text-danger">*</span></label>
                  <input type="text" id="student_id" class="form-control" name="" placeholder="รหัสนักศึกษา" readonly
                    value="{{ old('student_id', Auth::user()->student_id) }}">
                </div>
              </div>

              <div class="col-lg-3">
                <div class="form-group focused">
                  <label class="form-control-label " for="prefix_name" style="white-space: nowrap">คำนำหน้า</label>
                  <input type="text" id="prefix_name" class="form-control" name="" placeholder="คำนำหน้า" readonly
                    value="{{ old('prefix_name', Auth::user()->prefix_name) }}">
                </div>
              </div>

              <div class="col-lg-3">
                <div class="form-group focused">
                  <label class="form-control-label" for="name">ชื่อ<span class="small text-danger">*</span></label>
                  <input type="text" id="name" class="form-control" name="" placeholder="Name" readonly
                    value="{{ old('name', Auth::user()->first_name) }}">
                </div>
              </div>

              <div class="col-lg-3">
                <div class="form-group focused">
                  <label class="form-control-label" for="last_name">นามสกุล</label>
                  <input type="text" id="last_name" class="form-control" name="" placeholder="Last name" readonly
                    value="{{ old('last_name', Auth::user()->last_name) }}">
                </div>
              </div>

            </div>
            <div class="row">

              <div class="col-lg-3">
                <div class="form-group">
                  <label class="form-control-label" for="personal_id">รหัสบัตรประชาชน<span
                      class="small text-danger">*</span></label>
                  <input type="text" id="personal_id" class="form-control" name="" placeholder="รหัสบัตรประชาชน"
                    readonly value="{{ old('personal_id', Auth::user()->personal_id) }}">
                </div>
              </div>

              <div class="col-lg-3">
                <div class="form-group">
                  <label class="form-control-label" for="email">อีเมล<span class="small text-danger">*</span></label>
                  <input type="email" id="" class="form-control" name="" placeholder="example@example.com" readonly
                    value="{{ old('email', Auth::user()->email) }}">
                </div>
              </div>

              <div class="col-lg-3">
                <div class="form-group">
                  <label class="form-control-label" for="faculty">คณะ<span class="small text-danger">*</span></label>
                  <input type="text" id="faculty" class="form-control" name="" placeholder="คณะ" readonly
                    value="{{ old('name', Auth::user()->faculty) }}">
                </div>
              </div>

              <div class="col-lg-3">
                <div class="form-group">
                  <label class="form-control-label" for="branch">สาขา<span class="small text-danger">*</span></label>
                  <input type="text" id="branch" class="form-control" name="" placeholder="สาขา" readonly
                    value="{{ old('name', Auth::user()->branch) }}">
                </div>
              </div>

            </div>


            <div class="row">

              <div class="col-lg-3">
                <div class="form-group">
                  <label class="form-control-label" for="year">ปีการศึกษา<span
                      class="small text-danger">*</span></label>
                  <select id="year" class="form-control" name="year" value="" required>
                    <option value="">-- เลือกปีการศึกษา --</option>
                    <option value="{{now()->format('Y')+543}}">{{now()->format('Y')+543}}
                    </option>
                    <option value="{{now()->format('Y')+544}}">{{now()->format('Y')+544}}</option>
                  </select>
                </div>
              </div>

              <div class="col-lg-3">
                <div class="form-group">
                  <label class="form-control-label" for="term">ภาคการศึกษา<span
                      class="small text-danger">*</span></label>
                  <select id="term" class="form-control" name="term" value="" required>
                    <option value="">-- เลือกภาคการศึกษา --</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                </div>
              </div>

              <div class="col-lg-3">
                <div class="form-group">
                  <label class="form-control-label" for="amount">จำนวนเงินที่กู้<span
                      class="small text-danger">*รวมค่าเทอมและค่าครองชีพ</span></label>
                  <input type="text" id="" class="form-control" name="amount" placeholder="" value="" required>
                </div>
              </div>


              <div class="col-lg-3">

                @php
                $now_year_thai = intval(Carbon\Carbon::now()->thaidate('y'));
                $year_auth_user = intval(substr(Auth::user()->student_id, 0, 2));

                @endphp
                {{-- <div class="form-group">

                  @if($now_year_thai > $year_auth_user)
                  <label class="form-control-label" for="term">ประเภทผู้กู้ กลุ่มที่ 1
                    <span class="small text-danger">*</span>
                  </label>
                  <select id="term" class="form-control" name="term" value="" required>
                    <option value="">-- เลือกประเภทผู้กู้ กลุ่มที่ 1 --</option>
                    <option value="11">รายเก่าเลื่อนชั้นปี</option>

                  </select>
                  @else
                  <label class="form-control-label" for="term">ประเภทผู้กู้ กลุ่มที่ 2
                    <span class="small text-danger">*</span></label>
                  <select id="term" class="form-control" name="term" value="" required>
                    <option value="">-- ประเภทผู้กู้ กลุ่มที่ 2 --</option>
                    <option value="21">ผู้กู้รายใหม่</option>
                    <option value="22">ผู้กู้รายเก่าย้ายสถานศึกษา</option>
                    <option value="23">ผู้กู้รายเก่าเปลี่ยนระดับชั้น</option>
                  </select>
                  @endif

                </div> --}}

                <div class="form-group">
                  <label class="form-control-label" for="type_loan">ประเภทผู้กู้ยืม<span class="small text-primary">
                      <a href="#" data-toggle="modal" data-target="#exampleModal">อ่านเพิ่มเติม คลิก</a></span></label>
                  <select id="type_loan" class="form-control" name="type_loan" value="" required>
                    <option value="">-- เลือกประเภทผู้กู้ยืม --</option>
                    <option style="background-color:#FFF2C0" value="11">กลุ่มที่ 1 | ผู้กู้ยืมรายเก่าเลื่อนชั้นปี
                    </option>
                    <option style="background-color:#FFDFDF" value="21">กลุ่มที่ 2 | ผู้กู้ยืมรายใหม่</option>
                    <option style="background-color:#FFDFDF" value="22">กลุ่มที่ 2 | ผู้กู้ยืมรายเก่าย้ายสถานศึกษา
                    </option>
                    <option style="background-color:#FFDFDF" value="23">กลุ่มที่ 2 | ผู้กู้ยืมรายเก่าเปลี่ยนระดับชั้น
                    </option>
                  </select>

                  <!-- Modal -->
                  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">รายละเอียดประเภทผู้กู้ยืม</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body p-4">
                          <div class="container-loan">
                            <div class="top">
                              <img class="logo-rmuti" src="{{asset('assets/img/RMUTI_KORAT.png') }}"></img>
                              <div>
                                ประเภทของผู้กู้ยืมเงินกองทุนเงินให้กู้ยืมเพื่อการศึกษา
                                <div>ปีการศึกษา {{now()->thaidate('Y') }}</div>
                              </div>
                              <img class="logo-loan" src="{{asset('assets/img/loan.png') }}"></img>
                            </div>
                            <div class="middle">
                              <div style="white-space: nowrap; margin: 10px">กลุ่มที่ 1</div>
                              <div style=" margin: 10px">
                                <span style="color: red">ผู้กู้ยืมรายเก่าเลื่อนชั้นปี</span>
                                หมายถึงนักศึกษาที่เคยทำสัญญากู้ยืมกับ มทร.อีสาน
                                และมีรหัสนักศึกษาชขึ้นต้นด้วย {{ now()->thaidate('y')-4 }}-{{ now()->thaidate('y')-1 }}
                                มีความประสงค์จะกู้ต่อเนื่องในปีการศึกษา {{now()->thaidate('Y') }}
                              </div>
                            </div>
                            <div class="bottom">
                              <div style="white-space: nowrap; margin: 10px">กลุ่มที่ 2</div>
                              <div style=" margin: 10px">
                                <div>
                                  <span style="color: red">ผู้กู้ยืมรายใหม่</span>
                                  หมายถึง นักศึกษาที่ไม่เคยกู้ยืมเงิน กยศ.
                                </div>
                                <div>
                                  <span style="color: red">ผู้กู้ยืมรายเก่าย้ายสถานศึกษา</span>
                                  หมายถึง นักศึกษาที่เคยกู้ยืมจากสถานศึกษาเดิมและได้มาศึกาาต่อที่ มทร.อีสาน
                                  รหัสนักศึกษาขึ้นต้นด้วย {{now()->thaidate('y') }}
                                </div>
                                <div>
                                  <span style="color: red">ผู้กู้ยืมรายเก่าเปลี่ยนระดับชั้น</span>
                                  หมายถึง ผู้กุ้ยืมเปลี่ยนระดับชั้นจาก ปวส.เป็นปริญญาตรี รหัสนักศึกษาขึ้นต้นด้วย
                                  {{now()->thaidate('y') }}
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

            </div>

            <div class="row">



              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label" for="img">อัพโหลดไฟล์<span
                      class="small text-danger">*ไฟล์ที่อัพโหลดจะต้องรวมเป็น pdf ไฟล์เดียวขนาดไม่เกิน 10 MB
                      เท่านั้น</span></label>
                  <input type="file" id="" class="form-control" name="img" placeholder="" value="" required>
                </div>
              </div>
              <div class="col-lg-12">
                {{-- @if (isset($pdfUrl))
                <div>
                  <iframe src="{{ $pdfUrl }}" width="100%" height="600"></iframe>
                </div>
                @endif --}}
              </div>
            </div>
        </div>
        <div class="pl-lg-4">
          <div class="row">
            <div class="col text-center">

              <button type="submit" class="btn btn-primary"
                onclick="return confirm('ตรวจสอบข้อมูลที่ต้องการจะส่งเรียบร้อยแล้ว ?')"> <i
                  class="fa fa-paper-plane mr-2" aria-hidden="true"></i>ส่งเอกสาร</button>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection