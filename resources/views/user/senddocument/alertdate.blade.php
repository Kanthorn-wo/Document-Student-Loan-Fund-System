@extends('layout.usertemplate')
@section('content')
<div class="row">
  <div class="col-lg-12 order-lg-2">
    <div class="card shadow mb-4">
      <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">ส่งเอกสาร </h6>
      </div>
      <div class="card-body">
        <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert">
          <div style="color: red">
            <i class="fas fa-exclamation-circle"></i>
            ไม่อยู่ในช่วงเวลาส่งเอกสาร ระบบจะเปิดให้ส่งเอกสารวันที่
            {{date('d/m/Y',strtotime($associative_arr['start_date']))}} ถึง
            {{date('d/m/Y', strtotime($associative_arr['end_date']))}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection

@push('scripts')

@if(session()->has('message'))
<script>
  Swal.fire({
  icon: 'info',
  title: 'ไม่อยู่ในช่วงเวลาส่งเอกสาร',
  text: 'ระบบจะเปิดให้ส่งเอกสารวันที่ {{ session()->get('message') }}',
  showConfirmButton: true,
  
})
</script>
@endif
@endpush