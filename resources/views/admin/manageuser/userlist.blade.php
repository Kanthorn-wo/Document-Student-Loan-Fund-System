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
            <h6 class="m-0 font-weight-bold text-secondary ">นักศึกษา</h6>
            <div class="form-group focused">

            </div>
          </div>
          <div class="col-sm ">
            <div style="display: flex; float: right;">
              <form action="{{ route('admin.manage.user.search') }}" method="GET" class="mr-3">
                @csrf
                <div class="input-group ">

                  <input type="text" class="form-control" placeholder="ค้นหา ชื่อ,นามสกุล,รหัสนักศึกษา" name='search'>
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                      <i class="fa fa-search"></i>
                    </button>
                  </div>

                </div>
              </form>

              <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"
                  aria-expanded="false">
                  เลือกดูผู้ใช้ในระบบ
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('admin.manage.user.index') }}">เจ้าหน้าที่</a>
                  <a class="dropdown-item" href="{{ route('admin.manage.user.list') }}">นักศึกษา</a>
                  {{-- <a class="dropdown-item" href="#">ผู้ดูแลระบบ(ยังไม่เพิ่ม Route)</a> --}}
                </div>
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
          <table class="table table-sm table-striped" id="onlyUser" width="100%" cellspacing="0"
            style="white-space: nowrap">
            <thead class="table-primary">
              <tr>
                <th>ลำดับ</th>
                <th>รหัสนักศึกษา</th>
                <th>รหัสประจำตัวประชาชน</th>
                <th>ชื่อ-นามสกุล</th>
                <th>คณะ</th>
                <th>สาขา</th>
                <th>อีเมล</th>
                <th>สิทธิ์ในระบบ</th>
                <th>วันที่สร้าง</th>
                <th>จัดการ</th>

              </tr>
            </thead>

            <tbody>
              @foreach ($users as $row)
              <tr>
                <th scope="row">{{ $users->firstItem()+$loop->index }}</th>
                <td>{{ $row->student_id }}</td>
                <td>{{Str::mask($row->personal_id, '*', 9); }}</td>
                <td>{{ $row->prefix_name}} {{ $row->first_name }} {{ $row->last_name }}</td>
                <td>{{ $row->faculty }}</td>
                <td>{{ $row->branch }}</td>
                <td>{{ $row->email }}</td>
                <td>{{ $row->role }}</td>
                <td>{{ $row->created_at->format('d/m/Y') }}</td>
                <td>
                  <a href="{{ route('admin.mysend',['id'=> $row->id]) }}" class="btn btn-primary">
                    <i class="fas fa-file"></i>
                    ({{App\Models\User\SendDocuments::where('user_id', '=', $row->id)->count() }})
                  </a>

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
                          <form action="{{ route('admin.updateuser.index',['id' => $row->id]) }}" method="post">
                            @csrf
                            <div class="form-group focused">
                              <label class="form-control-label float-left" for="student_id">รหัสนักศึกษา<span
                                  class="small text-danger">*</span></label>
                              <input type="text" class="form-control" name="student_id" placeholder="" required
                                value="{{ old('student_id', $row->student_id) }}">

                            </div>

                            <div class="form-group focused">
                              <label class="form-control-label float-left"
                                for="personal_id">รหัสบัตรประจำตัวประชาชน<span
                                  class="small text-danger">*</span></label>
                              <input type="text" class="form-control" name="personal_id" placeholder="" required
                                value="{{ old('personal_id', $row->personal_id) }}">

                            </div>
                            <div class="form-group focused">
                              <label class="form-control-label float-left" for="branch_name">คำนำหน้า<span
                                  class="small text-danger">*</span></label>
                              <select class="form-control" name="prefix_name" value="">
                                @foreach ( $prefix_name as $item)
                                <option value="{{$item->prefix_name}}" {{ $row->prefix_name === $item->prefix_name ?
                                  'selected':''}}>{{ $item->prefix_name }}</option>
                                @endforeach
                              </select>

                            </div>
                            <div class="form-group focused">
                              <label class="form-control-label float-left" for="first_name">ชื่อ<span
                                  class="small text-danger">*</span></label>
                              <input type="text" class="form-control" name="first_name" placeholder="" required
                                value="{{ old('first_name', $row->first_name) }}">
                            </div>

                            <div class="form-group focused">
                              <label class="form-control-label float-left" for="last_name">นามสกุล<span
                                  class="small text-danger">*</span></label>
                              <input type="text" class="form-control" name="last_name" placeholder="" required
                                value="{{ old('last_name', $row->last_name) }}">
                            </div>

                            <div class="form-group focused">
                              <label class="form-control-label float-left" for="faculty">คณะ<span required
                                  class="small text-danger">*</span></label>
                              <select class="faculty form-control" name="faculty_id">
                                <option value="{{ old('faculty', $row->faculty) }}">-- เลือกคณะ --</option>
                                @foreach($faculties as $item)
                                <option value="{{ $item->id }}" {{ $row->faculty === $item->faculty_name ?
                                  'selected' : ''}}>
                                  {{$item->faculty_name }}
                                </option>
                                @endforeach
                              </select>
                            </div>

                            <div class="form-group focused">
                              <label class="form-control-label float-left" for="branch">สาขา<span required
                                  class="small text-danger">*</span></label>
                              <select class="form-control branch-dropdown" name="branch">
                                <option value="{{ old('branch', $row->branch) }}">{{ old('branch', $row->branch) }}
                                </option>
                              </select>
                            </div>


                            <div class="form-group focused">
                              <label class="form-control-label float-left" for="abbreviatioemailn_name">อีเมล<span
                                  required class="small text-danger">*</span></label>
                              <input type="text" class="form-control" name="email" placeholder=""
                                value="{{ old('email', $row->email) }}">
                            </div>
                            <div class="form-group focused">
                              <label class="form-control-label float-left" for="password">รหัสผ่าน<span
                                  class="small text-danger">*</span></label>
                              <input type="password" class="form-control" name="password" placeholder="" value="">
                              <input type="hidden" class="form-control" name="old_password" placeholder=""
                                value="{{ old('password', $row->password) }}">
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

                  <a href="{{ route('admin.deleteuser.index',['id'=> $row->id]) }}" class="btn btn-danger"
                    onclick="return confirm('หากลบผู้ใช้ในระบบข้อมูลของผู้ใช้ทั้งหมดจะถูกลบ')">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
            <div class="pagination">

            </div>
          </table>
          {{ $users->links("pagination::bootstrap-4") }}
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@push('js')

<script type="text/javascript">
  $('.faculty').change(function () { 
    const select = $(this).val();
    const _token = $('input[name="_token"]').val();

    $.ajax({
      type: "POST",
      url: "/admin/fetch-branch",
      data: {select:select,_token:_token},

      success: function (response) {
          $('.branch-dropdown').html(response);
          console.log('response :>> ', response);
      }
    });
  });
 
</script>

<script>
  document.addEventListener('keydown', function(event) {
      if (event.key === 'Enter') {
          event.preventDefault(); // prevent default behavior of the Enter key
          document.querySelector('form').submit(); // submit the form
      }
  });
</script>


@endpush