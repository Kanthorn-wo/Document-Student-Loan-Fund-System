@extends('layout.admintemplate')
@section('content')
<a class="btn btn-primary" data-toggle="modal" data-target="#update{{ $row->id }}"><i class="fas fa-edit"></i></a>

{{-- Modal --}}
<div class="modal fade" id="update{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูล</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ url('/admin/filedocument/'.$row->id) }}" method="post">
          @csrf
          <div class="form-group focused">
            <label class="form-control-label" for="subject">ชื่อเอกสาร<span class="small text-danger">*</span></label>
            <input type="text" id="subject" class="form-control" name="subject" placeholder=""
              value="{{ old('subject', $row->subject) }}">
            @error('subject')
            <span class="text-danger my-4">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group focused">
            <label class="form-control-label" for="note">หมายเหตุ<span class="small text-danger">*</span></label>
            <input type="text" id="note" class="form-control" name="note" placeholder="" value="">
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" value="บันทึก" class="btn btn-primary ">
      </div>
      </form>
    </div>
  </div>
</div>
{{-- End Modal --}}
@endsection