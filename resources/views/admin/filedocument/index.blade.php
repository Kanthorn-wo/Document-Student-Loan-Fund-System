@extends('layout.admintemplate')
@section('content')
<div class="row">
  <div class="col-lg-12 order-lg-1" style="min-width: 150px">
    <div class="card shadow mb-4">
      <div class="card-header py-3 overflow-auto">
        <div class="row d-flex justify-content-between">
          <div class="col-sm d-flex align-items-center">
            <h6 class="m-0 font-weight-bold text-primary ">รายการไฟล์เอกสาร</h6>

          </div>
          <div class="col-sm ">
            <a class="btn btn-success  float-right " data-toggle="modal" data-target="#add"><i
                class="fas fa-plus mr-1"></i>เพิ่มเอกสาร</a>
          </div>
        </div>
        {{-- Modal Add--}}
        <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มเอกสาร</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="reset-x">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{ url('/admin/filedocument') }}" method="post" id="form-add">
                  @csrf
                  <div class="form-group ">
                    <label class="form-control-label float-left" for="subject">ชื่อเอกสาร<span
                        class="small text-danger">*</span></label>
                    <input type="text" id="subject" class="form-control" name="subject" placeholder="" value=""
                      required>
                    {{-- @error('subject')
                    <span class="text-danger my-4">{{ $message }}</span>
                    @enderror --}}
                  </div>
                  <div class="form-group ">
                    <label class="form-control-label float-left" for="note">หมายเหตุ</label>
                    <textarea type="text" id="note" class="form-control" name="note" placeholder="" value=""></textarea>
                  </div>
                  {{-- Radio --}}
                  <div style="color: #1a202c; font-weight:600 ">สถานะการใช้งาน</div>
                  <div class="form-check">
                    <input class="form-check-input " type="radio" name="status" id="exampleRadios1" value="1">
                    <label class="form-check-label" for="exampleRadios1">เปิดใช้งาน</label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input " type="radio" name="status" id="exampleRadios0" value="0" checked>
                    <label class="form-check-label" for="exampleRadios0">ปิดใช้งาน</label>
                  </div>
                  {{-- End Radio --}}
                  {{-- Mutiple-Input --}}
                  <div class="mt-3" style="color: #1a202c; font-weight:600 ">เอกสารที่ต้องแนบมาด้วย</div>
                  <div class="multiple-input mt-2" style="border: 1px solid #D1D3E2 ; border-radius: 0.35rem">
                    <table class="table table-borderless " id="table">
                      <tbody>
                        <tr>
                          <td>
                            <div style=" display: flex; align-items: center; justify-content: center">
                              <input type="text" name="inputs1[]" class="form-control mr-1" required> จำนวน
                              <input style="width: 15%" type="text" name="inputs2[]" class="form-control ml-1"
                                id="piece" required>
                            </div>
                          </td>
                          <td><button class="btn btn-success" name="multi-add" id="multi-add"
                              type="button">เพิ่ม</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  {{-- End Mutiple-Input --}}

              </div>
              <div class="modal-footer d-flex justify-content-center">
                <input type="submit" value="บันทึก" class="btn btn-primary ">
                <button type="reset" class="btn btn-danger " data-dismiss="modal" id="reset-form">ยกเลิก</button>
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
          <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead class="table-secondary">
              <tr>
                <th>ลำดับ</th>
                <th>ชื่อเอกสาร</th>
                <th>หมายเหตุ</th>
                <th>ผู้สร้าง</th>
                <th>สถานะการใช้งาน</th>
                <th>วันที่สร้าง</th>
                <th>จัดการ</th>

              </tr>
            </thead>
            @php
            $index = 1;
            @endphp
            <tbody>
              @foreach ($file_doc as $row)
              <tr>
                <input type="hidden" class="delete_velue_id" value="{{ $row->id }}">
                <th scope="row">{{ $index++ }}</th>
                <td>{{ $row->subject }}</td>
                <td>@if($row->note == NULL)
                  -
                  @else
                  {{ Str::limit($row->note, 20);}}
                </td>
                @endif

                <td>{{ $row->admin->first_name }}</td>
                <td style="white-space: nowrap">
                  @if ( $row->status == 1)
                  <div class="d-inline-flex"
                    style="color: white; background-color: #1CC88A ; border-radius: 95px ;padding: 0px 10px 0px 10px">
                    เปิดใช้งาน</div>
                  @else
                  <div class="d-inline-flex"
                    style="color: white;background-color: red ; border-radius: 95px ;padding: 0px 10px 0px 10px">
                    ปิดใช้งาน
                  </div>
                  @endif
                </td>
                <td>
                  @if($row->created_at == NULL)
                  NULL
                  @else
                  {{$row->created_at->format('d/m/Y')}}
                  @endif
                </td>
                <td style="white-space: nowrap">
                  <a class=" btn btn-primary" href="{{ route('admin.filledoc.list',['id'=> $row->id]) }}">
                    <i class=" fas fa-folder"></i>
                    ({{App\Models\Admin\FileDocument::Find($row->id)->senddocuments->count() }})</a>

                  <a class="btn btn-warning" data-toggle="modal" data-target="#update{{ $row->id }}"><i
                      class="fas fa-edit"></i></a>
                  {{-- Modal Edit --}}
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
                        <div class="modal-body ">
                          <form action="{{ url('/admin/filedocument/'.$row->id) }}" method="post">
                            @csrf
                            <div class="form-group ">
                              <label class="form-control-label float-left" for="subject">ชื่อเอกสาร<span
                                  class="small text-danger">*</span></label>
                              <input type="text" id="subject" class="form-control" name="subject" placeholder=""
                                value="{{ old('subject', $row->subject) }}">

                              @error('subject')
                              <span class="text-danger my-4">{{ $message }}</span>
                              @enderror
                            </div>
                            <div class="form-group ">
                              <label class="form-control-label float-left" for="note">หมายเหตุ</label>
                              <textarea type="text" id="note" class="form-control" name="note" placeholder=""
                                value="">{{ old('note', $row->note) }}</textarea>
                            </div>
                            {{-- Radio --}}
                            <div style="display: block ;text-align:left">
                              <div style="color: #1a202c; font-weight:600 ">สถานะการใช้งาน</div>
                              <div class="form-check">
                                <input class="form-check-input " type="radio" name="status" id="exampleRadios1"
                                  value="1" {{ old('status', $row->status) == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="exampleRadios1">เปิดใช้งาน</label>
                              </div>

                              <div class="form-check">
                                <input class="form-check-input " type="radio" name="status" id="exampleRadios0"
                                  value="0" {{ old('status', $row->status) == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="exampleRadios0">ปิดใช้งาน</label>
                              </div>
                            </div>
                            {{-- End Radio --}}
                            {{-- Mutiple-Input --}}
                            <div style="display: block ;text-align:left">
                              <div class="mt-3 " style="color: #1a202c; font-weight:600 ">เอกสารที่ต้องแนบมาด้วย</div>
                            </div>

                            <div class="multiple-input mt-2" style="border: 1px solid #D1D3E2 ; border-radius: 0.35rem">
                              <table class="table  " id="table-edit">

                                <tbody>
                                  <tr>
                                    <td style="width: 85%">
                                      @foreach(json_decode($row->attachment) as $list)
                                      <input type="text" name="inputs1[]" class="form-control mb-2" value="{{ $list }}"
                                        id="muti-input-edit">
                                      @endforeach
                                    </td>

                                    <td style="width: 15%">
                                      @foreach(json_decode($row->piece) as $list)
                                      <input type="text" name="inputs2[]" class="form-control mb-2" value="{{ $list }}"
                                        id="muti-input-edit">
                                      @endforeach
                                    </td>
                                  </tr>

                                </tbody>
                              </table>
                            </div>
                            {{-- End Mutiple-Input --}}
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                          <input type="submit" value="บันทึก" class="btn btn-primary ">
                          <button type="reset" class="btn btn-danger " data-dismiss="modal"
                            id="reset-form">ยกเลิก</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  {{-- End Modal Edit--}}


                  <a href="{{ url('admin/filedocument/delete/'.$row->id) }}" class="btn btn-danger"
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
<script>
  $('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id'); // Extract info from data-* attributes
    var modal = $(this);
    modal.find('.modal-body input').val(id);
  })
</script>

<script>
  $(document).ready(function(){
    $('#reset-form').click(function(){
      $('#form-add')[0].reset();
      location.reload();
    });
  });
</script>
<script>
  let i = 0;
  let i2 = 0 ;
  $('#multi-add').click(function (e) {
     i++;
     i2++;
      $('#table').append(
          `<tr id="row`+i+`">
            <td>
                  <div style=" display: flex; align-items: center; justify-content: center">
                      <input type="text" name="inputs1[`+i+`]" class="form-control mr-1" required> จำนวน 
                      <input style="width: 15%" type="text"name="inputs2[`+i2+`]" class="form-control ml-1" required>
                  </div>
              </td>
              <td><button class="btn btn-danger remove-table-row" style="width: 53.22px">ลบ</button></td>
          </tr>`
          
      );
     
  });
 
  $(document).on('click','.remove-table-row',function (){
    $(this).closest('tr').remove();
  });
</script>





<script>
  $(document).ready(function () {
    $('.handledelete').click(function (e) { 
      e.preventDefault();
      var id = $(this).closest("tr").find('.delete_velue_id').val();
      Swal.fire({
          title: 'คุณแน่ใจไหม?',
          text: "คุณจะเปลี่ยนกลับไม่ได้!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#4E73DF',
          cancelButtonColor: '#E74A3B',
          confirmButtonText: 'ใช่ ลบเลย!',
          cancelButtonText: 'ยกเลิก'
      }).then((result) => {
        if (result.isConfirmed) {
        $.ajax({
          type: "get",
          url:"{{ url('admin/filedocument/delete') }}/"+ id,
          data: "data",
          dataType: "dataType",
          success: function (response) {
          }
        });
        Swal.fire(
          'ลบแล้ว!',
          'ไฟล์ของคุณถูกลบแล้ว',
          'success'
        ).then((result)=>{
          if(result.isConfirmed){
            location.reload();
          }
        })
  }
        });
    });
  });
</script>
@endpush