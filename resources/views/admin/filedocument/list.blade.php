@extends('layout.admintemplate')
@section('content')
<div class=" row">
  <div class="col-lg-12 order-lg-1">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row d-flex justify-content-between">
          <div class="col-sm d-flex align-items-center">
            <a href="{{ route('admin.filledoc.index') }}">
              <h6 class="m-0 font-weight-bold text-primary ">รายการไฟล์เอกสาร</h6>
            </a>
            <h6 class="m-0 font-weight-bold text-gray mr-1 ml-1">/</h6>
            <h6 class="m-0 font-weight-bold text-gray ">{{ $list_doc->subject }}</h6>
          </div>
          <div class=" col-sm ">
            <div style=" display: flex; float: right;">
              <a href="{{ route('admin.export',['id' => $list_doc->id]) }}" class="btn btn-success mr-2">
                <i class="fas fa-file-excel"></i> Export
              </a>
              <a class="btn btn-primary" data-toggle="modal" data-target="#chart{{ $list_doc->id }}">
                <i class="fas fa-info-circle"></i> รายงาน
              </a>

              {{-- Modal Detail --}}
              <div class="modal fade" id="chart{{ $list_doc->id }}" tabindex="-1" aria-labelledby="update"
                aria-hidden="true">
                <div class="modal-dialog  modal-xl modal-dialog-scrollable">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="chart{{$list_doc->id }}"><i class="fas fa-info-circle"></i>
                        รายงานไฟล์เอกสารลำดับที่ {{$list_doc->id
                        }}
                      </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                      <div class="row">
                        <div class="col-lg-12">
                          <div class="card h-100">
                            <div class="card-header">
                              รายละเอียดไฟล์เอกสาร
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="col-lg-6">
                                  <div>ลำดับที่ : {{ $list_doc->id }}</div>
                                  <div>ชื่อเอกสาร : {{ $list_doc->subject }}</div>
                                  <div>ผู้สร้าง : {{ $list_doc->admin->first_name }}</div>
                                  <div>วันที่สร้าง : {{ $list_doc->created_at}}</div>
                                  <div>หมายเหตุ : {{ $list_doc->note}}</div>
                                  @if ($list_doc->status == 1)
                                  สถานะ : <span class="badge badge-pill badge-success">เปิดใช้งาน</span>
                                  @else
                                  สถานะ : <span class="badge badge-pill badge-danger">ปิดใช้งาน</span>
                                  @endif

                                </div>
                                @php
                                $index = 1;
                                @endphp
                                <div class="col-lg-6">
                                  รายการที่ต้องแนบมาด้วย
                                  <div class="d-flex">
                                    <div class="d-flex align-items-start flex-column">
                                      @foreach(json_decode($list_doc->attachment) as $list)
                                      <div>{{ $index++ }} . {{ $list }} จำนวน</div>
                                      @endforeach
                                    </div>
                                    <div class="d-flex align-items-start flex-column">
                                      @foreach(json_decode($list_doc->piece) as $list)
                                      <div class="ml-2">{{ $list }} ใบ</div>
                                      @endforeach
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="col-lg-12 ">
                          <div class="card">
                            <div class="card-header">
                              <i class="fa fa-pie-chart"></i> กราฟ
                            </div>
                            <div class="card-body text-center">
                              <div style="display: flex;align-items: center;justify-content: center">
                                <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-lg-12">
                          <div class="card">
                            <div class="card-header">
                              <i class="fas fa-chart-bar"></i> สรุปตารางเอกสารแต่ละคณะ
                            </div>
                            <div class="card-body">
                              <div class="table-responsive">
                                <table class="table table-bordered w-100" style="white-space: nowrap;">
                                  <thead>
                                    <tr>
                                      <th scope="col">คณะ</th>
                                      @foreach ($facultyList as $facultyId)
                                      <th scope="col">{{ $facultyCounts->firstWhere('faculty_id',
                                        $facultyId)->faculty->faculty_name }}</th>
                                      @endforeach
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr class="table-primary">
                                      <td>ทั้งหมด</td>
                                      @foreach ($facultyList as $facultyId)
                                      <td>{{ $facultyCounts->where('faculty_id', $facultyId)->sum('count') }}</td>
                                      @endforeach
                                    </tr>
                                    <tr class="table-warning">
                                      <td>รอตรวจสอบ</td>
                                      @foreach ($facultyList as $facultyId)
                                      <td>{{ $countsWait[$facultyId] ?? 0 }}</td>
                                      @endforeach
                                    </tr>
                                    <tr class="table-success">
                                      <td>อนุมัติ</td>
                                      @foreach ($facultyList as $facultyId)
                                      <td>{{ $countsApprove[$facultyId] ?? 0 }}</td>
                                      @endforeach
                                    </tr>
                                    <tr class="table-danger">
                                      <td>ไม่อนุมัติ</td>
                                      @foreach ($facultyList as $facultyId)
                                      <td>{{ $countsUnapprove[$facultyId] ?? 0 }}</td>
                                      @endforeach
                                    </tr>
                                    <tr>

                                    </tr>
                                  </tbody>
                                </table>

                                <div>
                                  {{-- อ.เกตุกาญจน์ --}}
                                  <canvas id="barChart" style="width:100%;"></canvas>
                                </div>
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

        </div>
        <div class="card-body" style="padding: 20px 0">
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
                  <th>รหัสนักศึกษา</th>
                  <th>ชื่อ-นามสกุล</th>
                  <th>คณะ</th>
                  <th>สาขา</th>
                  <th>วันที่ส่งเอกสาร</th>
                  <th>วันที่ตรวจสอบ</th>
                  <th>สถานะ</th>
                  <th>จัดการ</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($doc_query as $row)
                <tr>
                  <th scope="row">{{ $doc_query->firstItem()+$loop->index }}</th>
                  <td>{{ $row->user->student_id}}</td>
                  <td>{{$row->user->prefix_name}} {{$row->user->first_name}} {{$row->user->last_name}}</td>
                  <td>{{$row->user->faculty}}</td>
                  <td>{{$row->user->branch}}</td>
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
                    <div class="status-unseccess d-inline-flex">
                      ไม่อนุมัติ
                    </div>
                    @endif
                  </td>

                  <td>
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
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <embed src="{{ url($row->img) }}" style="width:100%; height:800px;" frameborder="0">
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    {{-- End Modal Detail--}}


                    @if ($row->status == 1)
                    <a class="btn btn-warning disabled"><i class="fas fa-edit"></i></a>
                    @else
                    <a class="btn btn-warning" data-toggle="modal" data-target="#update{{ $row->id }}"><i
                        class="fas fa-edit"></i></a>
                    @endif

                    {{-- Modal --}}
                    <div class="modal fade" id="update{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                      aria-hidden="true">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i>แก้ไขข้อมูล</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="{{ route('admin.filledoc.list.update',['id' => $row->id]) }}" method="post"
                              enctype="multipart/form-data">
                              @csrf
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
                                    <label class="form-control-label" for="type_loan">ประเภทผู้กู้ยืม</label>
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
                                    <label class="form-control-label" for="img">อัพโหลดไฟล์<span
                                        class="small text-danger">*ไฟล์ที่อัพโหลดจะต้องรวมเป็น pdf ไฟล์เดียวขนาดไม่เกิน
                                        10
                                        MB
                                        เท่านั้น</span></label>
                                    <input type="file" id="" class="form-control" name="img" placeholder=""
                                      value="{{ $row->img }}">

                                  </div>
                                </div>
                              </div>

                              <input type="hidden" name="old_img" value="{{ $row->img }}">

                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="form-group focused">
                                    {{-- <label class="form-control-label" for="old-img-raw">
                                      ไฟล์เอกสารเดิม
                                    </label> --}}
                                    <embed src="{{ url($row->img) }}" style="width:100%; height:800px;" frameborder="0">
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

                    </div>
                    {{-- End Modal --}}


                    @if ($row->status == 1)
                    <a class="btn btn-danger disabled">
                      <i class="fas fa-trash"></i>
                    </a>
                    @else
                    <a href="{{ url('admin/filedocument/list/delete/'.$row->id) }}" class="btn btn-danger"
                      onclick="return confirm('ต้องการลบข้อมูล')">
                      <i class="fas fa-trash"></i>
                    </a>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>

            </table>
            {{ $doc_query->links("pagination::bootstrap-4") }}
          </div>
        </div>
      </div>
    </div>
  </div>


  @endsection

  @push('js')

  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

  <script>
    var xValues = ["รอตรวจสอบ", "อนุมัติ", "ไม่อนุมัติ"];
    var yValues = [{{ count($wait_doc) }}, {{ count($approve_doc) }}, {{ count($unapprove_doc) }},];
    var barColors = [
      "rgba(255, 206, 86, 0.2)",
      "rgba(75, 192, 192, 0.2)",
      "rgba(255, 99, 132, 0.2)",
    
    ];
    var borderColor =[
      "rgba(255, 206, 86, 1)",
      "rgba(75, 192, 192, 1)",
      "rgba(255, 99, 132, 1)"
    ]
    new Chart("myChart", {
      type: "pie",
      data: {
        labels: xValues,
        datasets: [{
          backgroundColor: barColors,
          borderColor:borderColor,
          data: yValues
        }]
      },
      options: {
        title: {
          display: true,
          text: "สรุปรายการของ {{ $list_doc->subject }} จำนวนทั้งหมด {{count($all_doc)}} รายการ"
        }
      }
    });
  </script>

  <script>
    // var ctx = document.getElementById('barChart').getContext('2d');
  
  var facultyNames = [
      @foreach ($facultyList as $facultyId)
          "{{ $facultyCounts->firstWhere('faculty_id', $facultyId)->faculty->faculty_name }}",
      @endforeach
  ];

  var totalData = [
      @foreach ($facultyList as $facultyId)
          {{ $facultyCounts->where('faculty_id', $facultyId)->sum('count') }},
      @endforeach
  ];

  var waitData = [
      @foreach ($facultyList as $facultyId)
          {{ $countsWait[$facultyId] ?? 0 }},
      @endforeach
  ];

  var approveData = [
      @foreach ($facultyList as $facultyId)
          {{ $countsApprove[$facultyId] ?? 0 }},
      @endforeach
  ];

  var unapproveData = [
      @foreach ($facultyList as $facultyId)
          {{ $countsUnapprove[$facultyId] ?? 0 }},
      @endforeach
  ];

  var data = {
    labels: facultyNames,
    datasets: [
        {
            label: 'ทั้งหมด',
            data: totalData,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        },
        {
            label: 'รอตรวจสอบ',
            data: waitData,
            backgroundColor: 'rgba(255, 206, 86, 0.2)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1
        },
        {
            label: 'อนุมัติ',
            data: approveData,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        },
        {
            label: 'ไม่อนุมัติ',
            data: unapproveData,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }
    ]
};

var ctx = document.getElementById('barChart').getContext('2d');

// show zero value
// var myChart = new Chart(ctx, {
//     type: 'bar',
//     data: data,
//     options: {
//         scales: {
//             y: {
//                 beginAtZero: true
//             }
//         },
//         animation: {
//             onComplete: function () {
//                 var chartInstance = this.chart;
//                 var ctx = chartInstance.ctx;

//                 // Display the data values on top of each bar
//                 ctx.font = Chart.helpers.fontString(12, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
//                 ctx.textAlign = 'center';
//                 ctx.textBaseline = 'bottom';

//                 this.data.datasets.forEach(function (dataset, datasetIndex) {
//                     for (var i = 0; i < dataset.data.length; i++) {
//                         var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
//                         var barCenterX = model.x;
//                         var barCenterY = model.y - 5; // Adjust for vertical positioning

//                         ctx.fillStyle = 'black'; // Color of the data value
//                         ctx.fillText(dataset.data[i], barCenterX, barCenterY);
//                     }
//                 });
//             }
//         }
//     }
// });

//no show zero value

var myChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        animation: {
            onComplete: function () {
                var chartInstance = this.chart;
                var ctx = chartInstance.ctx;

                // Display the data values on top of each bar
                ctx.font = Chart.helpers.fontString(12, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function (dataset, datasetIndex) {
                    for (var i = 0; i < dataset.data.length; i++) {
                        var value = dataset.data[i];
                        if (value > 0) {
                            var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                            var barCenterX = model.x;
                            var barCenterY = model.y + 20; // Adjust for vertical positioning

                            ctx.fillStyle = 'black'; // Color of the data value
                            ctx.fillText(value, barCenterX, barCenterY);
                        }
                    }
                });
            }
        }
    }
});



  </script>

  <script>
    var ctx = document.getElementById('barChartAll').getContext('2d');
        var data = {
            labels: [
                @foreach ($facultyList as $facultyId)
                    "{{ $facultyCounts->firstWhere('faculty_id', $facultyId)->faculty->faculty_name }}",
                @endforeach
            ],
            datasets: [{
                label: 'Status Counts',
                data: [
                    @foreach ($facultyList as $facultyId)
                        {{ $facultyCounts->firstWhere('faculty_id', $facultyId)->count }},
                    @endforeach
                ],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
  </script>
  @endpush