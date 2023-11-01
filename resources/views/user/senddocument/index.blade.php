@php
use App\Models\Admin\FileDocument;
$check_file_doc = count(FileDocument::all());
@endphp
@extends('layout.usertemplate')
@section('content')
<div class="row">
  <div class="col-lg-12 order-lg-2">
    <div class="card shadow mb-4">
      <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">ส่งเอกสาร</h6>
      </div>

      <div class="card-body">
        @if (!$check_file_doc)
        <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert">
          <div>
            <i class="fas fa-info-circle mr-1"></i>
            ไม่มีเอกสารให้ส่ง ณ ขณะนี้
          </div>

        </div>
        @else
        <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert">
          <div>
            <i class="fas fa-info-circle mr-1"></i>
            ระบบจะเปิดให้ส่งเอกสารวันที่
            {{date('d/m/Y',strtotime($associative_arr['start_date']))}}
            ถึง
            {{date('d/m/Y', strtotime($associative_arr['end_date']))}}
          </div>

        </div>
        @endif


        @foreach($file_doc as $item)

        <div class="alert alert-primary" role="alert" style="margin: 0 !important">
          <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="mr-3">
              <b>ชื่อเอกสาร : </b>{{ $item->subject }}
            </div>
            <div class="flex-shrink-0">
              @if (Auth::user()->process != 1)
              <a href="{{ url('user/senddocument/add/'.$item->id)}}" class="btn btn-primary"> <i
                  class="fas fa-file-alt text-white mr-1">
                </i><span class="hidden-send">กรอกเอกสาร</span>
              </a>
              @else
              <a class="btn btn-primary" onclick="showAlert()">
                <i class="fas fa-file-alt text-white"></i>
                <span class="hidden-send">กรอกเอกสาร</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        <div class="card mb-3">
          <div class="card-body">

            <div class="mb-3">
              <div class=p-3">
                @if($item->note != NULL)
                หมายเหตุ : {{ $item->note }}
                @else
                หมายเหตุ : -
                @endif
              </div>
            </div>

            <div class="mb-3">
              <div>
                สิ่งที่ต้องแนบมาด้วย
              </div>
            </div>
            <div class="mb-3">
              <div class=" p-1">
                <div class="d-flex justify-content-start align-items-center">
                  <div style=" margin-right: 2rem">
                    @foreach(json_decode($item->attachment) as $model)
                    <div><b class="mr-1">-</b>{{ $model }}</div>
                    @endforeach
                  </div>

                  <div>
                    @foreach(json_decode($item->piece) as $model)
                    <div style="display: flex;">
                      <div class="mr-1">{{ $model }}</div>
                      <div>ใบ</div>
                    </div>
                    @endforeach
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>






        @endforeach

      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')



<script>
  function showAlert() {
    Swal.fire({
  icon: 'info',
  title: 'มีเอกสารที่ยังไม่ได้ตรวจสอบ',
  text: 'ไม่สามารถส่งเอกสารได้จนกว่าเอกสารที่ส่งล่าสุดจะได้รับการตรวจสอบ',
  showConfirmButton: true,
  
})
}
  
</script>

@endpush

{{-- <a href="{{ url('user/senddocument/add/'.$row->id)}}" class="btn btn-primary"> <i
    class="fas fa-file-alt text-white"></i> กรอกเอกสาร</a> --}}