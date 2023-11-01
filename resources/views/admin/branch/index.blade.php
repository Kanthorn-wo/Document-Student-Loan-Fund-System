@extends('layout.admintemplate')
@section('content')
<div class=" row">
  <div class="col-lg-12 order-lg-1">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row d-flex justify-content-between">
          <div class="col-sm d-flex align-items-center">
            <h6 class="m-0 font-weight-bold text-primary ">จัดการสาขาวิชา</h6>
          </div>
          <div class="col-sm ">
            <a class="btn btn-success  float-right " data-toggle="modal" data-target="#add"><i
                class="fas fa-plus mr-1"></i>เพิ่มสาขาวิชา</a>
          </div>
        </div>
        {{-- Modal Add--}}
        <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มสาขาวิชา</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{ route('admin.branch.add') }}" method="post">
                  @csrf
                  <div class="form-group focused">
                    <label class="form-control-label float-left" for="faculty_id">คณะ<span
                        class="small text-danger">*</span></label>

                    <select id="inputState" class="form-control" name="faculty_id" value="">
                      @foreach ( $faculty_data as $row)
                      <option value="{{ $row->id }}">{{ $row->faculty_code}} | {{ $row->faculty_name }}</option>
                      @endforeach

                    </select>
                    @error('faculty_code')
                    <span class="text-danger my-4">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group focused">
                    <label class="form-control-label float-left" for="branch_code">รหัสสาขาวิชา<span
                        class="small text-danger">*</span></label>
                    <input type="text" id="branch_code" class="form-control" name="branch_code" placeholder="" value=""
                      required>
                    @error('branch_code')
                    <span class="text-danger my-4">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group focused">
                    <label class="form-control-label float-left" for="branch_name">ชื่อสาขาวิชา<span
                        class="small text-danger">*</span></label>
                    <input type="text" id="branch_name" class="form-control" name="branch_name" placeholder="" value=""
                      required>
                    @error('branch_name')
                    <span class="text-danger my-4">{{ $message }}</span>
                    @enderror
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
          <table class="table " id="dataTable" width="100%" cellspacing="0">
            <thead class="table-secondary">
              <tr>
                <th>ลำดับ</th>

                <th>รหัสคณะ</th>
                <th>คณะ</th>
                <th>รหัสสาขาวิชา</th>
                <th>สาขาวิชา</th>
                <th>จัดการ</th>

              </tr>
            </thead>
            @php
            $index = 1;
            @endphp
            <tbody>
              @foreach ($branch_data as $row)
              <tr>
                <th scope="row">{{ $index++ }}</th>

                <td>{{ $row->faculty->faculty_code }}</td>
                <td>{{ $row->faculty->faculty_name }}</td>
                <td>{{ $row->branch_code }}</td>
                <td>{{ $row->branch_name }}</td>

                <td>
                  <a class="btn btn-warning" data-toggle="modal" data-target="#update{{ $row->id }}">
                    <i class="fas fa-edit"></i>
                  </a>
                  {{-- Modal Edit--}}
                  <div class="modal fade" id="update{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit mr-1"></i>แก้ไขข้อมูล
                          </h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="{{ url('/admin/branch/'.$row->id) }}" method="post">
                            @csrf
                            <div class="form-group focused">
                              <label class="form-control-label float-left" for="faculty_id">คณะ<span
                                  class="small text-danger">*</span></label>

                              <select id="inputState" class="form-control" name="faculty_id" value="">
                                @foreach ( $faculty_data as $item)
                                <option value="{{$item->id}}" {{ $row->faculty->id === $item->id ? 'selected' :
                                  ''}}>{{ $item->faculty_code }} | {{$item->faculty_name}}</option>
                                @endforeach

                              </select>
                              @error('faculty_code')
                              <span class="text-danger my-4">{{ $message }}</span>
                              @enderror
                            </div>

                            <div class="form-group focused">
                              <label class="form-control-label float-left" for="branch_code">รหัสสาขาวิชา<span
                                  class="small text-danger">*</span></label>
                              <input type="text" id="branch_code" class="form-control" name="branch_code" placeholder=""
                                value="{{ old('branch_code', $row->branch_code) }}">
                              @error('branch_code')
                              <span class="text-danger my-4">{{ $message }}</span>
                              @enderror
                            </div>
                            <div class="form-group focused">
                              <label class="form-control-label float-left" for="branch_name">ชื่อสาขาวิชา<span
                                  class="small text-danger">*</span></label>
                              <input type="text" id="branch_name" class="form-control" name="branch_name" placeholder=""
                                value="{{ old('branch_name', $row->branch_name) }}">
                              @error('branch_name')
                              <span class="text-danger my-4">{{ $message }}</span>
                              @enderror
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
                  {{-- End Modal Edit--}}

                  <a href="{{ url('admin/branch/delete/'.$row->id) }}" class="btn btn-danger"
                    onclick="return confirm('ต้องการลบข้อมูล')">
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

@endsection