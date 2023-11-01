@extends('layout.admintemplate')
@section('content')
<div class=" row">
  <div class="col-lg-12 order-lg-1">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row d-flex justify-content-between">
          <div class="col-sm d-flex align-items-center">
            <h6 class="m-0 font-weight-bold text-primary ">จัดการคำนำหน้า</h6>
          </div>
          <div class="col-sm ">
            <a class="btn btn-success  float-right " data-toggle="modal" data-target="#add"><i
                class="fas fa-plus mr-1"></i>เพิ่มคำนำหน้า</a>
          </div>
        </div>
        {{-- Modal Add--}}
        <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มคำนำหน้า</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{ route('admin.prefix.add') }}" method="post">
                  @csrf
                  <div class="form-group focused">
                    <label class="form-control-label float-left" for="prefix_name">ชื่อคำนำหน้า<span
                        class="small text-danger">*</span></label>
                    <input type="text" id="prefix_name" class="form-control" name="prefix_name" placeholder="" value=""
                      required>
                    @error('prefix_name')
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
              <tr style="white-space: nowrap">
                <th>ลำดับ</th>
                <th>คำนำหน้า</th>
                <th>จัดการ</th>

              </tr>
            </thead>
            @php
            $index = 1;
            @endphp
            <tbody>
              @foreach ($prefix_name as $row)
              <tr>
                <th scope="row">{{ $index++ }}</th>
                <td>{{ $row->prefix_name}}</td>
                <td>
                  <a class="btn btn-warning" data-toggle="modal" data-target="#update{{ $row->id }}"><i
                      class="fas fa-edit"></i></a>
                  {{-- Modal --}}
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
                          <form action="{{ url('/admin/prefix/'.$row->id) }}" method="post">
                            @csrf
                            <div class="form-group focused">
                              <label class="form-control-label float-left" for="prefix_name">ชื่อคำนำหน้า<span
                                  class="small text-danger">*</span></label>
                              <input type="text" id="prefix_name" class="form-control" name="prefix_name" placeholder=""
                                value="{{ old('prefix_name', $row->prefix_name) }}">
                              @error('prefix_name')
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
                  {{-- End Modal --}}

                  <a href="{{ url('admin/prefix/delete/'.$row->id) }}" class="btn btn-danger"
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

@push('js')