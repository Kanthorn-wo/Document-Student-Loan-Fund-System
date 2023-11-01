@extends('layout.admintemplate')
@section('content')
<div class=" row">
  <div class="col-lg-12 order-lg-1">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row d-flex justify-content-between">
          <div class="col-sm d-flex align-items-center">
            <h6 class="m-0 font-weight-bold text-primary ">จัดการผู้ใช้ในระบบ</h6>
            <h6 class="m-0 font-weight-bold text-secondary mr-1 ml-1">/</h6>
            <h6 class="m-0 font-weight-bold text-secondary ">เจ้าหน้าที่</h6>
          </div>
          <div class="col-sm ">
            <div style="display: flex; float: right;">
              <a class="btn btn-success  float-right mr-3" data-toggle="modal" data-target="#add"><i
                  class="fas fa-plus mr-1"></i>เพิ่มเจ้าหน้าที่</a>
              <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"
                  aria-expanded="false">
                  เลือกดูผู้ใช้ในระบบ
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="#">เจ้าหน้าที่</a>
                  <a class="dropdown-item" href="{{ route('admin.manage.user.list') }}">นักศึกษา</a>
                  {{-- <a class="dropdown-item" href="#">ผู้ดูแลระบบ(ยังไม่เพิ่ม Route)</a> --}}
                </div>
              </div>
            </div>

          </div>
        </div>
        {{-- Modal Add--}}
        <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มเจ้าหน้าที่</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{ route('admin.addstaff.index') }}" method="post">
                  @csrf
                  <div class="form-group focused">
                    <label class="form-control-label float-left" for="prefix_name">คำนำหน้า<span
                        class="small text-danger">*</span></label>
                    <select class="form-control" name="prefix_name" value="">
                      @foreach ( $prefix_data as $row)
                      <option>{{ $row->prefix_name}}</option>
                      @endforeach

                    </select>
                    @error('faculty_code')
                    <span class="text-danger my-4">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="form-group focused">
                    <label class="form-control-label float-left" for="first_name">ชือ<span
                        class="small text-danger">*</span></label>
                    <input type="text" class="form-control" name="first_name" placeholder="" value="">
                    @error('first_name')
                    <span class="text-danger my-4">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group focused">
                    <label class="form-control-label float-left" for="last_name">นามสกุล<span
                        class="small text-danger">*</span></label>
                    <input type="text" class="form-control" name="last_name" placeholder="" value="">
                    @error('last_name')
                    <span class="text-danger my-4">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="form-group focused">
                    <label class="form-control-label float-left" for="rank">ตำแหน่ง</label>
                    <input type="text" class="form-control" name="rank" placeholder="" value="">
                    @error('rank')
                    <span class="text-danger my-4">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="form-group focused">
                    <label class="form-control-label float-left" for="email">อีเมล<span
                        class="small text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" placeholder="" value="" required>
                    @error('email')
                    <span class="text-danger my-4">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group focused">
                    <label class="form-control-label float-left" for="password">รหัสผ่าน<span
                        class="small text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" placeholder="" value="" required>
                    @error('password')
                    <span class="text-danger my-4">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="modal-footer d-flex justify-content-center">
                    <input type="submit" value="บันทึก" class="btn btn-primary ">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          {{-- End Modal Add--}}
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
            <table class="table table-sm" id="dataTable" width="100%" cellspacing="0">
              <thead class="table-secondary">
                <tr>
                  <th>ลำดับ</th>
                  <th>คำนำหน้า</th>
                  <th>ชื่อ</th>
                  <th>นามสกุล</th>
                  <th>ตำแหน่ง</th>
                  <th>อีเมล</th>
                  <th>สิทธิ์ในระบบ</th>
                  <th>วันที่สร้าง</th>
                  <th>จัดการ</th>

                </tr>
              </thead>
              @php
              $index = 1;
              @endphp
              <tbody>
                @foreach ($staff_all as $row)
                <tr>
                  <th scope="row">{{ $index++ }}</th>
                  <td>{{ $row->prefix_name}}</td>
                  <td>{{ $row->first_name }}</td>
                  <td>{{ $row->last_name }}</td>
                  <td>{{ $row->rank }}</td>
                  <td>{{ $row->email }}</td>
                  <td>{{ $row->role }}</td>
                  <td>{{ $row->created_at->format('d/m/Y') }}</td>
                  <td>
                    <a class="btn btn-warning" data-toggle="modal" data-target="#update{{ $row->id }}"><i
                        class="fas fa-edit"></i></a>
                    {{-- Modal Edit--}}
                    <div class="modal fade" id="update{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                      aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i>แก้ไขข้อมูล</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="{{  route('admin.updatestaff.index',['id' => $row->id])  }}" method="post">
                              @csrf

                              <div class="form-group focused">
                                <label class="form-control-label float-left" for="prefix_name">คำนำหน้า<span
                                    class="small text-danger">*</span></label>
                                <select class="form-control" name="prefix_name" value="prefix_name">
                                  @foreach ( $prefix_data as $item)
                                  <option value="{{$item->prefix_name}}" {{ $row->prefix_name == $item->prefix_name?
                                    'selected'
                                    :
                                    ''}}>{{ $item->prefix_name }}</option>
                                  @endforeach
                                </select>

                              </div>
                              <div class="form-group focused">
                                <label class="form-control-label float-left" for="first_name">ชื่อ<span
                                    class="small text-danger">*</span></label>
                                <input type="text" class="form-control" name="first_name" placeholder=""
                                  value="{{ old('first_name', $row->first_name) }}">
                              </div>

                              <div class="form-group focused">
                                <label class="form-control-label float-left" for="last_name">นามสกุล<span
                                    class="small text-danger">*</span></label>
                                <input type="text" class="form-control" name="last_name" placeholder=""
                                  value="{{ old('branch_code', $row->last_name) }}">
                              </div>

                              <div class="form-group focused">
                                <label class="form-control-label float-left" for="rank">ตำแหน่ง<span
                                    class="small text-danger">*</span></label>
                                <input type="text" class="form-control" name="rank"
                                  placeholder="ตำแหน่งอยู่ไม่นานตำนานอยู่ตลอดไป"
                                  value="{{ old('branch_code', $row->rank) }}">
                              </div>


                              <div class="form-group focused">
                                <label class="form-control-label float-left" for="email">อีเมล<span
                                    class="small text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" placeholder=""
                                  value="{{ old('email', $row->email) }}">
                              </div>
                              <div class="form-group focused">
                                <label class="form-control-label float-left" for="password">รหัสผ่าน<span
                                    class="small text-danger">*</span></label>
                                <input type="text" class="form-control" name="abbreviation_name" placeholder=""
                                  value="">
                              </div>

                          </div>
                          <div class="modal-footer d-flex justify-content-center">
                            <input type="submit" value="บันทึก" class="btn btn-primary ">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>

                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    {{-- End Modal Edit --}}

                    <a href="{{ route('admin.deletestaff.index',['id'=> $row->id]) }}" class="btn btn-danger"
                      onclick="return confirm('หากลบผู้ใช้ในระบบข้อมูลของผู้ใช้ทั้งหมดจะถูกลบ')">
                      <i class="fas fa-trash"></i>
                    </a>
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
</div>

@endsection