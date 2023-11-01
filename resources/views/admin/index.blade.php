@extends('layout.admintemplate')
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
        <div class="col-xl-6 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">
                    ผู้ใช้ในระบบ(ทั้งหมด)</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $all_user_data }} </div>
                </div>
                <div class="col-auto">
                  <div class="dropdown no-arrow">
                    <i class="fas fa-user fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-6 col-md-6 mb-4">
          <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-lg font-weight-bold text-dark text-uppercase mb-1">
                    เอกสารทั้งหมด</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($file_doc) }}</div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-file fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

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



      <!-- Content Row -->

      <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-6 col-lg-6">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">ผู้ใช้งานในระบบ</h6>
              <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                  aria-labelledby="dropdownMenuLink">
                  <div class="dropdown-header" style="font-size: 14px ; color: var(--gray)">รายละเอียดผู้ใช้งานในระบบ
                  </div>
                  <a class="dropdown-item" href="#">นักศึกษา : {{ count($user_data) }}</a>
                  <a class="dropdown-item" href="#">ผู้ดูและระบบ : {{ count($admin_data) }}</a>
                  <a class="dropdown-item" href="#">เจ้าหน้าที่ : {{ count($staff_data) }}</a>
                </div>
              </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <div class="chart-area">
                <canvas id="myBarChart"></canvas>
                {{-- <canvas id="facultyChart"></canvas> --}}
              </div>
            </div>
          </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-6 col-lg-6">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">รายการเอกสาร</h6>

            </div>
            <!-- Card Body -->
            <div class="card-body">
              <div class="chart-pie pt-4 pb-2">
                <canvas id="myPieChart"></canvas>
              </div>
              <div class="mt-4 text-center small">
                <span class="mr-2">
                  <i class="fas fa-circle text-warning"></i> รอตรวจสอบ
                </span>
                <span class="mr-2">
                  <i class="fas fa-circle text-success"></i> อนุมัติ
                </span>
                <span class="mr-2">
                  <i class="fas fa-circle text-danger"></i> ไม่อนุมัติ
                </span>

              </div>
            </div>
          </div>
        </div>

        <div class="col-12 ">
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="font-weight-bold text-primary">รายการเอกสารแต่ละคณะ(ทั้งหมด)</h6>
            </div>
            <div class="card-body">
              <div>
                <!-- Adjust max-height as needed -->
                <canvas id="facultyChart"></canvas>
              </div>
            </div>
          </div>
        </div>








      </div>

      <!-- Content Row -->
      <div class="row">

        <!-- Content Column -->
        <div class="col-lg-6 mb-4">





        </div>

        <div class="col-lg-6 mb-4">





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
  var facultyData = @json($results); // Pass Laravel data to JavaScript
  
  var ctx = document.getElementById('facultyChart').getContext('2d');
  var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: facultyData.map(item => item.faculty_name), // Extract faculty names
          datasets: [{
              label: 'Document Count',
              data: facultyData.map(item => item.document_count), // Extract document counts
              backgroundColor: 'rgba(75, 192, 192, 0.2)', // Bar color
              borderColor: 'rgba(75, 192, 192, 1)', // Border color
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              y: {
                  beginAtZero: true
              }
          },
          animation: {
            onComplete: function () {
                var chartInstance = this.chart;
                var ctx = chartInstance.ctx;

                // Display the data values on top of each bar
                ctx.font = Chart.helpers.fontString(12, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function (dataset, datasetIndex) {
                    for (var i = 0; i < dataset.data.length; i++) {
                        var value = dataset.data[i];
                        if (value > 0) {
                            var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                            var barCenterX = model.x;
                            var barCenterY = model.y - 5; // Adjust for vertical positioning

                            ctx.fillStyle = 'black'; // Color of the data value
                            ctx.fillText(value, barCenterX, barCenterY);
                        }
                    }
                });
            }
        }
      }
  });
</script>
<script>
  $('.popover-dismiss').popover({
  trigger: 'focus'
})
</script>
@endpush