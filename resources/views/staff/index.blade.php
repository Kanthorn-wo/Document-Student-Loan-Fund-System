@extends('layout.stafftemplate')
@section('content')

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

  <!-- Main Content -->
  <div id="content">


    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
      </div>

      <!-- Content Row -->
      <div class="row">


        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-lg font-weight-bold text-warning text-uppercase mb-1">เอกสารที่รอตรวจสอบ
                  </div>
                  <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ count($wait_doc) }}</div>
                    </div>

                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-hourglass fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-lg font-weight-bold text-success text-uppercase mb-1">
                    เอกสารที่อนุมัติแล้ว</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($approve_doc) }}</div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-check fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
          <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-lg font-weight-bold text-danger text-uppercase mb-1">
                    เอกสารที่ไม่อนุมัติ</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($unapprove_doc) }}</div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-times fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>



    </div>
    <!-- /.container-fluid -->

  </div>
  <!-- End of Main Content -->



</div>
<!-- End of Content Wrapper -->
@endsection
@push('js')


<script>
  $('.popover-dismiss').popover({
  trigger: 'focus'
})
</script>
@endpush