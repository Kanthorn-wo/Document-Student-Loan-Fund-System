@extends('layout.admintemplate')
@section('content')

<div class="row">
  <div class="col-lg-12 order-lg-1">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">กำหนดวันส่งเอกสาร</h6>
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
        <form action="{{ url('/admin/setdate') }}" method="post">
          @csrf
          <label>วันเริ่มต้น</label>
          <input type="date" name="start_date">
          <label>วันสิ้นสุด</label>
          <input type="date" name="end_date">
          <button class="btn btn-success" type="submit">
            <i class="fa fa-plus mr-1"></i> เพิ่มวันที่
          </button>
        </form>
        <div class="table-responsive">
          <table class="table " id="dataTable" width="100%" cellspacing="0">
            <thead class="table-secondary">
              <tr>
                <th>ลำดับ</th>
                <th>วันเริ่มต้น</th>
                <th>วันสิ้นสุด</th>
                <th>สถานะ</th>
                <th class="text-center">เลือกใช้งาน</th>
                <th>จัดการ</th>

              </tr>
            </thead>
            @php
            $index = 1;
            @endphp
            <tbody>
              @foreach ($date_data as $row)
              <tr style="white-space: nowrap">
                <th scope="row">{{ $index++ }}</th>
                <td>{{ \Carbon\Carbon::parse($row->start_date)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($row->end_date)->format('d/m/Y') }}</td>
                <td>
                  @if ($row->is_active == true)
                  <div class="d-inline-flex"
                    style="color: white; background-color: #1CC88A ; border-radius: 95px ;padding: 0px 10px 0px 10px">
                    เปิดใช้งาน
                  </div>
                  @else
                  <div class="d-inline-flex"
                    style="color: white; background-color: red ; border-radius: 95px ;padding: 0px 10px 0px 10px">
                    ปิดใช้งาน
                  </div>
                  @endif
                </td>
                <td class="text-center">
                  @if ($row->is_active == true)
                  <div class="d-inline-flex"
                    style="color: white; background-color: var(--gray) ; border-radius: 95px ;padding: 0px 10px 0px 10px">
                    กำลังใช้งาน
                  </div>
                  @else
                  <a href="{{ url('admin/setdate/'.$row->id) }}" class="btn btn-primary">
                    <i class="fas fa-check"></i>
                  </a>

                  @endif
                </td>
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
                          <form action="{{ route('admin.setdate.update',['id' => $row->id]) }}" method="post">
                            @csrf
                            <div class="form-group focused">
                              <label class="form-control-label float-left" for="start_date">วันเริ่มต้น<span
                                  class="small text-danger">*</span></label>
                              <input type="date" id="start_date" class="form-control" name="start_date" placeholder=""
                                value="{{ old('start_date', $row->start_date) }}">
                              @error('start_date')
                              <span class="text-danger my-4">{{ $message }}</span>
                              @enderror
                            </div>

                            <div class="form-group focused">
                              <label class="form-control-label float-left" for="end_date">วันสิ้นสุด<span
                                  class="small text-danger">*</span></label>
                              <input type="date" id="end_date" class="form-control" name="end_date" placeholder=""
                                value="{{ old('end_date', $row->end_date) }}">
                              @error('end_date')
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
                  {{-- @if ($row->is_active == true)
                  <a class="btn btn-danger disabled">
                    <i class="fas fa-trash"></i>
                  </a>
                  @else --}}
                  <a href="{{ url('admin/setdate/delete/'.$row->id) }}" class="btn btn-danger"
                    onclick="return confirm('ต้องการลบข้อมูล')">
                    <i class="fas fa-trash"></i>
                  </a>
                  {{-- @endif --}}

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


@endpush