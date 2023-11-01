@php
use App\Models\Admins;
use App\Models\Staffs;
use App\Models\User;

$last_id = App\Models\Admin\FileDocument::orderBy('id', 'desc')->first();
$massage_data = App\Models\User\SendDocuments::where('status', '=', 0)->orderByDesc('created_at')->take(5)->get();
$pie_wait = count(App\Models\User\SendDocuments::where('status', '=', 0)->get());
$pie_approve = count(App\Models\User\SendDocuments::where('status', '=', 1)->get());
$pie_unapprove = count(App\Models\User\SendDocuments::where('status', '=', 2)->get());

$chart_user = count(User::all());
$chart_admin = count(Admins::all());
$chart_staff = count(Staffs::all());

@endphp
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ระบบส่งเอกสารออนไลน์กองทุนเงินให้กู้ยืมเพื่อการศึกษา</title>

  <!-- Custom fonts for this template-->

  <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  {{--
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet"> --}}
  <link
    href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@1,500&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sarabun:wght@100&display=swap"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('assets/css/sb-admin-2.css') }}" rel="stylesheet">
  <!-- Custom styles for this page -->
  <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    /* CSS for the loading animation */
    .loading {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 9999;
    }

    .loading-icon {
      animation: spin 1s linear infinite;
      border: 5px solid #ccc;
      border-top-color: #4e73df;
      border-radius: 50%;
      height: 50px;
      width: 50px;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    /* CSS for the main content */
    body {
      background-color: #fff;
    }

    #app {
      opacity: 0;
      transition: opacity 1s ease;
    }

    #app.loaded {
      opacity: 1;
    }
  </style>
</head>
<div class="loading">
  <div class="loading-icon"></div>
</div>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class=" sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/admin/dashboard') }}">

        <div class="sidebar-brand-text mx-3 ">
          Admin(CMS)</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item {{ url()->current() == url('/admin/dashboard')  ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/admin/dashboard') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        จัดการเอกสาร
      </div>
      @php
      $year_thai_now = strval(now()->thaidate('Y'));

      @endphp
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item {{ url()->current() == route('admin.check.approve.list')  ? 'active' : '' }}">
        <a class="nav-link "
          href="{{ route('admin.check.approve.list',['status' => 0 , 'row' => 10 ,'faculty' => 'all','year' => $year_thai_now ,'file_doc' => $last_id]) }}">
          <i class="fas fa-fw fa-check-square"></i>
          <span>ตรวจสอบเอกสาร</span>
        </a>
      </li>

      <li class="nav-item {{ url()->current() == route('admin.filledoc.index')  ? 'active' : '' }}">
        <a class="nav-link " href="{{ route('admin.filledoc.index') }}">
          <i class="fas fa-fw fa-file"></i>
          <span>จัดการเอกสาร</span>
        </a>
      </li>


      <li class="nav-item {{ url()->current() == route('admin.setdate.index')  ? 'active' : '' }}">
        <a class="nav-link " href="{{ route('admin.setdate.index') }}">
          <i class="fas fa-fw fa-calendar"></i>
          <span>กำหนดวันส่งเอกสาร</span>
        </a>
      </li>

      <hr class="sidebar-divider">

      <div class="sidebar-heading">
        จัดการข้อมูลผู้ใช้
      </div>

      <li class="nav-item {{ url()->current() == route('admin.manage.user.index')  ? 'active' : '' }}">
        <a class="nav-link " href="{{ route('admin.manage.user.index') }}">
          <i class="fas fa-fw fa-users-cog"></i>
          <span>จัดการผู้ใช้ในระบบ</span>
        </a>
      </li>
      <li class="nav-item {{ url()->current() == route('admin.profile')  ? 'active' : '' }}">
        <a class="nav-link " href="{{ route('admin.profile') }}">
          <i class="fas fa-fw fa-user"></i>
          <span>จัดการข้อมูลส่วนตัว</span>
        </a>
      </li>

      <hr class="sidebar-divider">
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
          aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>จัดการข้อมูลพื้นฐาน</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">เมนูจัดการข้อมูลพื้นฐาน</h6>
            <a class="collapse-item" href="{{ route('admin.prefix.index') }}">คำนำหน้า</a>
            <a class="collapse-item" href="{{ route('admin.faculty.index') }}">คณะ</a>
            <a class="collapse-item" href="{{ route('admin.branch.index') }}">สาขา</a>
          </div>
        </div>
      </li>



      <!-- Divider -->


      <!-- Heading -->


      <!-- Nav Item - Pages Collapse Menu -->




      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <h5>ระบบส่งเอกสาร กยศ. ออนไลน์</h5>
          </div>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">


            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-history"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">{{ count($massage_data) }}+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  ประวัติ
                </h6>
                @foreach ($massage_data as $item)
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>

                    <div class="small text-gray-900">ส่งเมื่อ {{
                      Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</div>
                    <span class="font-weight-bold">เอกสาร : {{ $item->filedocument->subject}}</span>
                    <div class="font-weight-bold">สถานะ : <span class="badge badge-pill badge-warning" style="font-size: 90%;
                        font-weight: 500;color: black"><span>รอตรวจสอบ</span></span></div>
                    <div class="font-weight-bold">ผู้ส่ง : {{ $item->user->first_name}} {{ $item->user->last_name}}
                    </div>


                  </div>
                </a>
                @endforeach

                <a class="dropdown-item text-center small text-gray-500"
                  href="{{ route('admin.check.index') }}">แสดงเอกสารทั้งหมด</a>
              </div>
            </li>



            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->first_name }} {{
                  Auth::user()->last_name }}</h1></span>
                <img class="img-profile rounded-circle" src="{{ asset('assets/img/user.svg') }}">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  ข้อมูลส่วนตัว
                </a>
                <a class="dropdown-item" href="{{ asset('pdf/user_manual.pdf') }}" target="_blank">
                  <i class="fas fa-book fa-sm fa-fw mr-2 text-gray-400"></i>
                  คู่มือการใช้งาน
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  ออกจากระบบ
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="loaded container-fluid" id="app">

          <!-- Page Heading -->
          @include('include.content')


        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน นครราชสีมา {{ Carbon\Carbon::now()->format('Y')
              }}</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">พร้อมที่จะออกจากระบบ?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">เลือก "ออกจากระบบ" หากคุณต้องการออกจากผู้ดูแลระบบ.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
          <a class="btn btn-danger" href="{{ route('admin.logout') }}">ออกจากระบบ</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>


  <!-- Page level plugins -->
  <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

  <!-- Page level custom scripts -->
  <script src="{{ asset('assets/js/demo/datatables-demo.js') }}"></script>

  <!-- Page level plugins -->
  <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>

  <!-- Page level custom scripts -->
  <script src="{{ asset('assets/js/demo/chart-area-demo.js') }}"></script>
  <script src="{{ asset('assets/js/demo/chart-pie-demo.js') }}"
    data-value="{{ $pie_wait }},{{ $pie_approve }},{{ $pie_unapprove }}">
  </script>
  <script src="{{ asset('assets/js/demo/chart-bar-demo.js') }} "
    data-prop="{{ $chart_user }},{{ $chart_admin }},{{ $chart_staff}}"></script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" defer></script>


  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>



  <script>
    window.onload = function() {
        document.querySelector('.loading').style.display = 'none';
        document.querySelector('#app').classList.add('loaded');
    };
  </script>

  <script>
    $(document).ready(function() {
      // show the alert
      $("#alert").fadeTo(10000, 500).slideUp(800, function(){
        $("#alert").alert('close');
      });
      // setTimeout(function() {
      //     $(".alert").alert('close');
      // }, 4000);
  });
  </script>



  @if (Session::has('success'))
  <script>
    $(document).ready(function () {
    let massage = $('#success').text();
    console.log('massage :>> ', massage);
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: massage ,
      showConfirmButton: false,
      timer: 1700
    })
  });
  
  </script>
  @endif


  @stack('js')

</body>

</html>