@extends('layout.usertemplate')
@section('content')
<div class="row">
  <div class="col-lg-12 order-lg-1">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">ประวัติการส่งเอกสาร</h6>
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
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>ลำดับ</th>
                <th>ชื่อเอกสาร</th>
                <th>จำนวนเงินที่กู้</th>
                <th>ปีการศึกษา</th>
                <th>วัน-เวลา ที่ส่ง</th>
                <th>วัน-เวลา ที่ตรวจสอบ</th>
                <th>สถานะ</th>
                <th>สาเหตุ</th>
                <th>ดูรายละเอียด</th>
                <th>แก้ไขเอกสาร</th>
              </tr>
            </thead>
            @php
            $index = 1;
            @endphp
            <tbody>
              @foreach ($send_doc as $row)
              <tr>
                <td data-label="ลำดับ" class="head-td">{{ $index++ }}</td>
                <td data-label="ชื่อเอกสาร">{{$row->filedocument->subject}}</td>
                <td data-label="จำนวนเงินที่กู้">{{$row->amount}} </td>
                <td data-label="จำนวนเงินที่กู้">{{$row->term}}/{{$row->year}}</td>
                <td data-label="ส่งเมื่อ:">{{$row->created_at->format('d/m/Y-H:i:s')}}</td>
                <td data-label="ตรวจสอบเมื่อ:">
                  @if ($row->updated_at != NULL)
                  {{$row->updated_at->format('d/m/Y-H:i:s')}}
                  @else
                  รอตรวจสอบ
                  @endif

                </td>
                <td data-label="สถานะ">
                  @if ($row->status == 0)
                  <span class="badge badge-pill badge-warning">รอตรวจสอบ</span>
                  @elseif ($row->status == 1)
                  <span class="badge badge-pill badge-success">อนุมัติ</span>
                  @elseif ($row->status == 2)
                  <span class="badge badge-pill badge-danger">ไม่อนุมัติ</span>
                  @endif
                </td>
                <td data-label="สาเหตุ">
                  @if($row->comment != NULL)
                  {{ $row->comment }}
                  @else
                  -
                  @endif
                </td>
                <td data-label="ดูรายละเอียด">
                  <a class="btn btn-primary" data-toggle="modal" data-target="#detail{{ $row->id }}"><i
                      class="far fa-eye"></i></a>
                  {{-- Modal Detail --}}
                  <div class="modal fade" id="detail{{ $row->id }}" tabindex="-1" aria-labelledby="update"
                    aria-hidden="true">
                    <div class="modal-dialog  modal-xl modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="detail{{ $row->id }}"> รายละเอียดเอกสาร
                          </h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="container-detail" style="text-align:start;">
                            <div class="alert alert-primary " role="alert">
                              <div class="d-flex align-items-start flex-column">
                                <div><b>รายละเอียดเอกสาร</b></div>
                                <div>ชื่อเอกสาร : {{$row->filedocument->subject}}</div>
                                <div>หมายเหตุ :{{$row->filedocument->note}}</div>
                                <div><b>ข้อมูลนักศึกษา</b></div>
                                <div>รหัสนักศึกษา : {{$row->user->student_id}}</div>
                                <div>ชื่อ-นามสกุล : {{$row->user->prefix_name}} {{$row->user->first_name}}
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
                                <div>ขนาดไฟล์ : {{ round((filesize($row->img) / 1024000), 2)}} MB</div>
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

                          </div>
                          <div class="pdf-show">
                            {{-- <embed src="{{ url($row->img) }}" style="width:100%; height:800px;" frameborder="0">
                            --}}
                            <object data="{{ url($row->img) }}" type="application/pdf" width="100%" height="1000px">
                              <a href="{{ url($row->img) }}"><i class="fas fa-file-pdf" aria-hidden="true">Dowload
                                  PDF</i></a>
                            </object>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  {{-- End Modal Detail--}}

                  </a>
                </td>

                <td data-label="แก้ไขเอกสาร">
                  @if ($row->status == 2)
                  <a class="btn btn-warning" data-toggle="modal" data-target="#update{{ $row->id }}"><i
                      class="fas fa-edit"></i></a>
                  @else
                  -
                  @endif

                  {{-- Modal Edit --}}
                  <div class="modal fade" id="update{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" style="padding-left: 0px">
                    <div class="modal-dialog modal-xl">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i>แก้ไขข้อมูล </h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="{{ url('user/history/update/'.$row->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div style="text-align: start !important">
                              <div class="row">
                                <div class="col-lg-3">
                                  <div class="form-group focused">
                                    <label class="form-control-label" for="student_id">รหัสนักศึกษา</label>
                                    <input type="text" id="student_id" class="form-control" name="" placeholder=""
                                      value="{{ old('student_id', $row->user->student_id) }}" readonly>
                                  </div>
                                </div>
                                <div class="col-lg-3">
                                  <div class="form-group focused">
                                    <label class="form-control-label" for="prefix_name">คำนำหน้า</label>
                                    <select id="inputState" class="form-control" name="" value="" disabled="true">
                                      @foreach ( $data_prefix_name as $item)
                                      <option value="{{$item->id}}" {{ $row->user->id === $item->id ? 'selected' :
                                        ''}}>{{ $item->prefix_name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-3">
                                  <div class="form-group focused">
                                    <label class="form-control-label" for="first_name">ชื่อ</label>
                                    <input type="text" id="first_name" class="form-control" name="" placeholder=""
                                      readonly value="{{ old('first_name', $row->user->first_name) }}">
                                  </div>
                                </div>
                                <div class="col-lg-3">
                                  <div class="form-group focused">
                                    <label class="form-control-label" for="last_name">นามสกุล</label>
                                    <input type="text" id="last_name" class="form-control" name="" placeholder=""
                                      readonly value="{{ old('last_name', $row->user->last_name) }}">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-lg-4">
                                  <div class="form-group focused">
                                    <label class="form-control-label" for="student_id">รหัสบัตรประจำตัวประชาชน</label>
                                    <input type="text" id="student_id" class="form-control" name="" placeholder=""
                                      readonly value="{{ old('student_id', $row->user->personal_id) }}">
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group focused">
                                    <label class="form-control-label" for="faculty">คณะ</label>
                                    <input type="text" id="faculty" class="form-control" name="" placeholder="" readonly
                                      value="{{ old('faculty', $row->user->faculty) }}">
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group focused">
                                    <label class="form-control-label" for="branch">สาขา</label>
                                    <input type="text" id="branch" class="form-control" name="" placeholder="" readonly
                                      value="{{ old('branch', $row->user->branch) }}">
                                  </div>
                                </div>
                              </div>

                              @php
                              $year1 = strval(now()->thaidate('Y')-1);
                              $year2 = strval(now()->thaidate('Y'));
                              $year3 = strval(now()->thaidate('Y')+1);
                              @endphp

                              <div class="row">
                                <div class="col-lg-2">
                                  <div class="form-group focused">
                                    <label class="form-control-label" for="year">ปีการศึกษา<span
                                        class="small text-danger">*</span></label>
                                    <select id="year" class="form-control" name="year" value="">
                                      <option value="{{ $year1 }}" {{ $row->year === $year1 ? 'selected' : '' }}>{{
                                        $year1
                                        }}
                                      </option>
                                      <option value="{{ $year2 }}" {{ $row->year === $year2 ? 'selected' : '' }}>{{
                                        $year2
                                        }}
                                      </option>
                                      <option value="{{ $year3 }}" {{ $row->year === $year3 ? 'selected' : '' }}>{{
                                        $year3
                                        }}
                                      </option>
                                    </select>
                                  </div>
                                </div>



                                <div class="col-lg-2">
                                  <div class="form-group focused">
                                    <label class="form-control-label" for="term">ภาคการศึกษา</label>
                                    <select id="term" class="form-control" name="term" value="">
                                      <option value="">-- เลือกภาคการศึกษา --</option>
                                      <option value="1" {{ $row->term == 1? 'selected' : '' }}>1</option>
                                      <option value="2" {{ $row->term == 2? 'selected' : '' }}>2</option>
                                      <option value="3" {{ $row->term == 3? 'selected' : '' }}>3</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group focused">
                                    <label class="form-control-label" for="amount">จำนวนเงินที่กู้</label>
                                    <span class="small text-danger">*รวมค่าเทอมและค่าครองชีพ</span>
                                    <input type="text" id="amount" class="form-control" name="amount" placeholder=""
                                      value="{{ old('amount', $row->amount) }}">
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group focused">
                                    <label class="form-control-label" for="type_loan">ประเภทผู้กู้ยืม<span
                                        class="small text-primary">
                                        <a href="">อ่านเพิ่มเติม คลิก</a></span></label>
                                    <select id="type_loan" class="form-control" name="type_loan" value="" required>
                                      <option value="">-- เลือกประเภทผู้กู้ยืม --</option>
                                      <option style="background-color:#FFF2C0" value="11" {{ $row->type_loan =='11'
                                        ? 'selected' : '' }}>กลุ่มที่ 1 |
                                        ผู้กู้ยืมรายเก่าเลื่อนชั้นปี
                                      </option>
                                      <option style="background-color:#FFDFDF" value="21" {{ $row->type_loan =='21'
                                        ? 'selected' : '' }}>กลุ่มที่ 2 | ผู้กู้ยืมรายใหม่
                                      </option>
                                      <option style="background-color:#FFDFDF" value="22" {{ $row->type_loan =='22'
                                        ? 'selected' : '' }}>กลุ่มที่ 2 |
                                        ผู้กู้ยืมรายเก่าย้ายสถานศึกษา
                                      </option>
                                      <option style="background-color:#FFDFDF" value="23" {{ $row->type_loan =='23'
                                        ? 'selected' : '' }}>กลุ่มที่ 2 |
                                        ผู้กู้ยืมรายเก่าเปลี่ยนระดับชั้น
                                      </option>
                                    </select>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="form-group focused">
                                    <label class="form-control-label" for="img">
                                      อัพโหลดไฟล์
                                      <span class="small text-danger">
                                        *ไฟล์ที่อัพโหลดจะต้องรวมเป็น pdf ไฟล์เดียวขนาดไม่เกิน 10MB เท่านั้น
                                      </span>
                                    </label>
                                    <input type="file" id="" class="form-control" name="img" value="{{ $row->img }}">
                                  </div>
                                </div>
                              </div>

                              <input type="hidden" name="old_img" value="{{ $row->img }}">

                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="form-group focused">
                                    <label class="form-control-label" for="old-img-raw">
                                      ไฟล์เอกสารเดิม
                                    </label>
                                    @if(file_exists($row->img))
                                    <object data="{{ url($row->img) }}" type="application/pdf" width="100%"
                                      height="1000px">
                                      <a href="{{ url($row->img) }}"><i class="fas fa-file-pdf"
                                          aria-hidden="true">Dowload
                                          PDF</i></a>
                                    </object>
                                    @else
                                    <div>File not found</div>
                                    @endif

                                  </div>
                                </div>
                              </div>


                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                              <input type="submit" value="อัพเดตข้อมูล" class="btn btn-primary ">
                              <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>

                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    {{-- End Modal --}}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>


      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')

@endpush