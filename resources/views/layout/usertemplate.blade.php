@php
$massage_data = App\Models\User\SendDocuments::where('user_id','=',
Auth::user()->id)->orderByDesc('created_at')->take(5)->get();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ระบบส่งเอกสาร กยศ. ออนไลน์</title>

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
  <link href="{{ asset('assets/css/user.css') }}" rel="stylesheet">
</head>
<div class="loading">
  <div class="loading-icon"></div>
</div>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion " id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center " href="#">
        <div class="sidebar-brand-text mx-3">{{ Auth::user()->student_id }}</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item {{ url()->current() == route('user.senddocument.index') ? 'active' : '' }} ">
        <a class="nav-link " href="{{ route('user.senddocument.index') }}">
          <i class="fas fa-fw fa-file"></i>
          <span>ส่งเอกสาร</span>
        </a>

      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        เมนูผู้ใช้งาน
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item {{ url()->current() == route('user.senddocument.history') ? 'active' : '' }}">
        <a class="nav-link " href="{{ route('user.senddocument.history') }}">
          <i class="fa fa-history"></i>
          <span>ประวัติการส่งเอกสาร</span></a>
      </li>


      <li class="nav-item {{ url()->current() == route('profileUser')  ? 'active' : '' }}">
        <a class="nav-link " href="{{ route('profileUser') }}">
          <i class="fas fa-fw fa-user"></i>
          <span>จัดการข้อมูลส่วนตัว</span>
        </a>

      </li>

      <li class="nav-item ">
        <a class="nav-link " href="https://drive.google.com/drive/u/4/folders/1nV0lTsVYEn8lEWmNfsfODkE2o_P843YG"
          target=" _blank">
          <i class="fa fa-download"></i>
          <span>ดาวน์โหลดเอกสาร</span>
        </a>

      </li>


      <!-- Nav Item - Utilities Collapse Menu -->



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
          {{-- <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
            <div style="display: flex; justify-content: center; ">
              <img class="  center-block mr-3 " src="https://upload.wikimedia.org/wikipedia/th/e/e0/RMUTI_KORAT.png"
                style="max-width: 30px;">
              <div>
                <h6>ระบบส่งเอกสาร กยศ. ออนไลน์</h6>
                <p>Rajamangala University Of Technology Isan</p>
              </div>

            </div>

          </div> --}}

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
                <a class="dropdown-item d-flex align-items-center" href="{{ route('user.senddocument.history') }}">
                  <div class="mr-3">
                    @if($item->status == 0)
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-file-alt text-white"></i>
                      @elseif ($item->status == 1)
                      <div class="icon-circle bg-success">
                        <i class="fas fa-check text-white"></i>
                        @elseif ($item->status == 2)
                        <div class="icon-circle bg-danger">
                          <i class="fas fa-times text-white"></i>
                          @endif

                        </div>
                      </div>
                      <div>

                        <div class="small text-gray-900">ส่งเมื่อ {{
                          Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</div>
                        <span class="font-weight-bold">เอกสาร : {{ $item->filedocument->subject}}</span>
                        <div class="font-weight-bold">สถานะ :

                          @if($item->status == 0)
                          <span class="badge badge-pill badge-warning" style="font-size: 90%;
                        font-weight: 500;color: black">
                            <span>รอตรวจสอบ</span>
                          </span>
                          @elseif ($item->status == 1)
                          <span class="badge badge-pill badge-success" style="font-size: 90%;
                      font-weight: 500;color: rgb(255, 255, 255)">
                            <span>อนุมัติ</span>
                          </span>
                          @elseif ($item->status == 2)
                          <span class="badge badge-pill badge-danger" style="font-size: 90%;
                        font-weight: 500;color: rgb(255, 255, 255)">
                            <span>ไม่อนุมัติ</span>
                          </span>
                          @endif

                        </div>
                        <div class="font-weight-bold">ผู้ส่ง : {{ $item->user->first_name}} {{ $item->user->last_name}}
                        </div>


                      </div>
                </a>
                @endforeach


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
                <a class="dropdown-item" href="{{ route('profileUser') }}">
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
        <div class="container-fluid">

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
            <span>Copyright &copy; มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน นครราชสีมา {{
              Carbon\Carbon::now()->format('Y')}}</span>
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
          <h5 class="modal-title" id="exampleModalLabel">ต้องการออกจากระบบ?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">เลือก "ออกจากระบบ" หากคุณต้องการออกจากระบบ.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
          <a class="btn btn-danger" href="{{ route('user.logout') }}">ออกจากระบบ</a>
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
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Page level plugins -->
  <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

  <!-- Page level custom scripts -->
  <script src="{{ asset('assets/js/demo/datatables-demo.js') }}"></script>


  <script>
    window.onload = function() {
        document.querySelector('.loading').style.display = 'none';
        document.querySelector('#app').classList.add('loaded');
    };
  </script>
  <script>
    $(document).ready(function() {
      $("#alert").fadeTo(10000, 500).slideUp(800, function(){
        $("#alert").alert('close');
      });
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


  @stack('scripts')
</body>

</html>