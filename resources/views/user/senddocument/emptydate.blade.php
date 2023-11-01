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
            ระบบยังไม่เปิดให้ใช้งาน

          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection

@push('scripts')
{{-- <script>
  window.onload = function() {
      $(document).ready(function () {
        Swal.fire({
          icon: 'error',
          title: 'แจ้งเตือน',
          text: 'ไม่อยู่ในช่วงเวลาส่งเอกสาร หากข้องใจไปตึกส้ม',
          
          
        })
      });
    };
</script> --}}


<script>
  Swal.fire({
  icon: 'error',
  title: 'แจ้งเตือน',
  text: 'ระบบยังไม่เปิดให้ใช้งาน',
  showConfirmButton: true,
  
})
</script>
@endpush