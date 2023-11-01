@extends('layout.stafftemplate')
@section('content')
<div class=" row">
  <div class="col-lg-12 order-lg-1">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row d-flex justify-content-between">
          <div class="col-sm d-flex align-items-center">
            <h6 class="m-0 font-weight-bold text-primary text-nowrap">ตรวจสอบเอกสาร</h6>
          </div>
          <div class=" col-sm ">
            <div style=" display: flex; float: right;">
              {{-- <a href="{{ route('admin.check.index') }}" class="btn btn-primary" type="button"
                style="margin-right: 10px ">เอกสารทั้งหมด </a> --}}

              {{-- <form action="" method="GET" class="mr-3">
                @csrf

              </form> --}}

              <form action="{{ route('staff.check.list') }}" method="get">
                <div class="d-flex">

                  <select class="faculty form-control mr-2 " name="file_doc" onchange="this.form.submit()">
                    <option value="">-- เลือกเอกสาร --</option>
                    @foreach($file_doc as $item)
                    <option value="{{ $item->id }}" {{ $req_file_doc==$item->id ? 'selected' : '' }}>{{
                      $item->subject }}</option>
                    @endforeach
                  </select>

                  <select class="form-control mr-2" name="status" id="status" onchange="this.form.submit()"
                    style="max-width: 250px;">
                    <option>-- เลือกเอกสาร --</option>
                    <option value="0" {{ $req_status=="0" ?'selected':'' }}>เอกสารที่รอตรวจสอบ</option>
                    <option value="1" {{ $req_status==1 ?'selected':'' }}>เอกสารที่อนุมัติแล้ว</option>
                    <option value="2" {{ $req_status==2 ?'selected':'' }}>เอกสารที่ไม่อนุมัติ</option>
                  </select>

                  <select class="faculty form-control " name="faculty" onchange="this.form.submit()">
                    <option value="all">-- เลือกคณะ --</option>
                    @foreach($faculties as $faculty)
                    <option value=" {{ $faculty->id }}" {{ $req_faculty==$faculty->id ?'selected':'' }}>{{
                      $faculty->faculty_name }}</option>
                    @endforeach
                  </select>

                  @php
                  $year_ago = strval(now()->thaidate('Y')-3);
                  $year_last = strval(now()->thaidate('Y')-2);
                  $year_befor = strval(now()->thaidate('Y')-1);
                  $year_now = strval(now()->thaidate('Y'));
                  $year_future = strval(now()->thaidate('Y')+1);
                  @endphp

                  <select class="form-control ml-2" name="year" id="year" onchange="this.form.submit()"
                    style="max-width: 120px;">
                    <option value="{{ $year_now }}">ปีการศึกษา</option>
                    <option value="{{ $year_future }}" {{ $req_year==$year_future ? 'selected' : '' }}> {{$year_future
                      }}
                    <option value="{{ $year_now }}" {{ $req_year==$year_now ? 'selected' : '' }}>{{ $year_now }}
                    </option>
                    <option value="{{ $year_befor }}" {{ $req_year==$year_befor ? 'selected' : '' }}>{{ $year_befor }}
                    </option>
                    <option value="{{ $year_last}}" {{ $req_year==$year_last ? 'selected' : '' }}>{{ $year_last }}
                    <option value="{{ $year_ago}}" {{ $req_year==$year_ago ? 'selected' : '' }}>{{ $year_ago }}
                    </option>


                  </select>

                  <select class="form-control ml-2" name="row" id="row" onchange="this.form.submit()"
                    style="max-width: 120px;">
                    <option value="">แสดง</option>
                    <option value="10" {{ $req_row=="10" ?'selected':'' }}>10 แถว</option>
                    <option value="25" {{ $req_row=="25" ?'selected':'' }}>25 แถว</option>
                    <option value="50" {{ $req_row=="50" ?'selected':'' }}>50 แถว</option>
                    <option value="75" {{ $req_row=="50" ?'selected':'' }}>75 แถว</option>
                    <option value="100" {{ $req_row=="100" ?'selected':'' }}>100 แถว</option>
                  </select>


              </form>
            </div>

          </div>

        </div>
      </div>
    </div>
    <div class="card-body">
      @if (session('success'))
      <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert" id="alert">
        <ul class="pl-4 my-2">
          <li id="success">{{ session('success') }}</li>
        </ul>
      </div>
      @endif

      @if ($errors->any())
      <div class="alert alert-danger border-left-danger" role="alert" id="alert">
        <ul class="pl-4 my-2">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <div class="table-responsive">
        <table class="table " id="onlyUser" width="100%" cellspacing="0" style="white-space: nowrap">

          <thead class="table-secondary">
            <tr>
              <th>ลำดับ</th>
              <th>ชื่อเอกสาร</th>
              <th>รหัสนักศึกษา</th>
              <th>ชื่อ-นามสกุล</th>
              <th>จำนวนเงินที่กู้</th>
              <th>คณะ</th>
              <th>ปีการศึกษา</th>
              <th>วัน-เวลา ที่ส่ง</th>
              <th>วัน-เวลา ที่ตรวจสอบ</th>
              <th>สถานะ</th>
              <th>ตรวจสอบเอกสาร</th>




            </tr>
          </thead>
          @php
          $index = 1;
          @endphp
          <tbody>
            @foreach ($approve as $row)
            <tr>
              <th scope="row">{{ $approve->firstItem()+$loop->index }}</th>

              <td>{{$row->filedocument->subject}}</td>
              <td>{{$row->user->student_id}}</td>
              <td>{{$row->user->prefix_name}} {{$row->user->first_name}} {{$row->user->last_name}}</td>
              <td>{{$row->amount}}</td>
              <td>{{$row->user->faculty}}</td>
              <td>{{$row->term}} / {{$row->year}}</td>
              <td>{{$row->created_at->format('d/m/Y-H:i:s')}}</td>
              <td>
                @if ($row->updated_at != NULL)
                {{$row->updated_at->format('d/m/Y-H:i:s')}}
                @else
                รอตรวจสอบ
                @endif
              </td>
              <td>@if ($row->status == 0)
                <div class="status-warning d-inline-flex">
                  รอตรวจสอบ
                </div>
                @elseif ($row->status == 1)
                <div class="status-success d-inline-flex">
                  อนุมัติ
                </div>
                @elseif ($row->status == 2)
                <div class=" status-unseccess d-inline-flex">
                  ไม่อนุมัติ
                </div>

                @endif
              </td>
              {{-- <td>
                @if ($row->user->process == 1)
                กำลังดำเนินการ
                @else
                สำเร็จเเล้ว
                @endif

              </td> --}}
              <td>
                <a class="btn btn-primary" data-toggle="modal" data-target="#check{{ $row->id }}">
                  <i class="fas fa-search"></i>
                </a>
                {{-- Modal check --}}
                <div class="modal fade" id="check{{ $row->id }}" tabindex="-1" aria-labelledby="check"
                  aria-hidden="true">
                  <div class="modal-dialog  modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="check{{ $row->id }}"><i class="fas fa-search mr-1"></i>
                          ตรวจสอบเอกสาร
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="pl-lg-12" style="border: 1px solid rgb(255, 255, 255)">
                          <table class="table">
                            <tbody>
                              <tr>
                                <td style="border: 1px solid #E3E6F0; border-radius:2px">
                                  <div class="alert alert-primary " role="alert">
                                    <div class="d-flex align-items-start flex-column">
                                      <div><b>รายละเอียดเอกสาร</b></div>
                                      <div>ชื่อเอกสาร : {{$row->filedocument->subject}}</div>
                                      <div>หมายเหตุ :{{$row->filedocument->note}}</div>
                                      <div><b>ข้อมูลนักศึกษา</b></div>
                                      <div>รหัสนักศึกษา : {{$row->user->student_id}}</div>
                                      <div>ชื่อ-นามสกุล : {{$row->user->prefix_name}}{{$row->user->first_name}}
                                        {{$row->user->last_name}}</div>
                                      <div>รหัสบัตรประจำตัวประชาชน : {{$row->user->personal_id}}</div>
                                      <div>คณะ : {{$row->user->faculty}}</div>
                                      <div>สาขา : {{$row->user->branch}}</div>
                                      <div>ปีการศึกษา : {{$row->year}}</div>
                                      <div>ภาคการศึกษา : {{$row->term}}</div>
                                      <div>จำนวนเงินที่กู้ : {{$row->amount}} บาท</div>
                                      <div>วัน-เวลา ที่ส่ง : {{$row->created_at->format('d/m/Y-H:i:s น.')}}</div>
                                      <div><b>ประเภทผู้กู้ยืม</b></div>
                                      <div>
                                        @if ($row->type_loan == 11)
                                        <div class="loan-group1">กลุ่มที่ 1 ผู้กู้ยืมรายเก่าเลื่อนชั้นปี
                                        </div>
                                        @elseif($row->type_loan == 21)
                                        <div class="loan-group2">กลุ่มที่ 2 ผู้กู้ยืมรายใหม่</div>
                                        @elseif($row->type_loan == 22)
                                        <div class="loan-group2">กลุ่มที่ 2 ผู้กู้ยืมรายเก่าย้ายสถานศึกษา</div>
                                        @elseif($row->type_loan == 23)
                                        <div class="loan-group2">กลุ่มที่ 2 ผู้กู้ยืมรายเก่าเปลี่ยนระดับชั้น</div>
                                        @endif
                                      </div>
                                      <div><b>เอกสารที่ต้องแนบมาด้วย</b></div>
                                      <div>
                                        <ul class="d-flex align-items-start flex-column">
                                          @foreach(json_decode($row->filedocument->attachment) as $list)
                                          <li> {{ $list }}</li>
                                          @endforeach
                                        </ul>
                                      </div>
                                      @if(file_exists($row->img))
                                      <div>ขนาดไฟล์ : {{ round((filesize($row->img) / 102400), 2)}} MB</div>
                                      @else
                                      <div>File not found</div>
                                      @endif
                                      <div style="display: flex; ">
                                        <p style="margin-right: 7px ">สถานะ : </p> @if ($row->status == 0)
                                        <p style="color: var(--wait)">รอตรวจสอบ</p>
                                        @elseif ($row->status == 1)
                                        <p style="color: rgb(11, 234, 74)">อนุมัติ</p>
                                        @elseif ($row->status == 2)
                                        <p style="color: rgb(255, 32, 7)">ไม่อนุมัติ</p>

                                        @endif
                                        @if($row->comment != NULL)
                                        <p class="ml-2">เนื่องจาก : {{$row->comment}}</p>
                                        @else

                                        @endif
                                      </div>
                                    </div>

                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>

                        </div>
                        <embed src="{{ url($row->img) }}" style="width:100%; height:800px;" frameborder="0">
                      </div>
                      <div class="modal-footer">
                        <a href="{{ route('staff.check.approve', ['id' => $row->id]) }}" type="button"
                          class="btn btn-success"><i class="fas fa-check mr-1"></i>อนุมัติเอกสาร</a>
                        {{-- DisApprove Modal --}}
                        <a class="btn btn-danger" data-toggle="modal" data-target="#disapprove{{ $row->id }}"><i
                            class="fas fa-times mr-1"></i>ไม่อนุมัติเอกสาร</a>
                        <div class="modal fade" id="disapprove{{ $row->id }}" tabindex="-1"
                          aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                  <i class="fas fa-times mr-1"></i>ไม่อนุมัติเอกสาร
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="{{ route('staff.check.disapproval',['id'=> $row->id]) }}" method="post"
                                  id="form-comment">
                                  @csrf
                                  <div class="form-group ">
                                    <label class="form-control-label float-left" for="comment"
                                      required="required">ข้อความ</label>
                                    <textarea type="text" id="comment" class="form-control" name="comment"
                                      placeholder="ระบุสาเหตุที่ไม่อนุมัติ" value=""></textarea>
                                  </div>
                              </div>
                              <div class="modal-footer d-flex justify-content-center">
                                <input type="submit" value="บันทึก" class="btn btn-primary ">
                                <button type="reset" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                              </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        {{-- End DisApprove Modal --}}



                      </div>
                    </div>
                  </div>
                </div>
                {{-- End Modal check--}}





            </tr>
            @endforeach
          </tbody>

        </table>
        {{ $approve->links("pagination::bootstrap-4") }}
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@push('js')
{{-- <script>
  $(document).ready(function() {
    // show the alert
    $("#alert-massage").fadeTo(3000, 500).slideUp(800, function(){
      $("#alert-massage").alert('close');
    });
    // setTimeout(function() {
    //     $(".alert").alert('close');
    // }, 4000);
});
</script> --}}

@endpush