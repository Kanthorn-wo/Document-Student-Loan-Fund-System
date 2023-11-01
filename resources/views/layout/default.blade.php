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
  <style>
    .nav-bar {
      width: 100%;
      height: 70px;
      background-color: #224abe;
    }

    .top-nav {
      width: 100%;
      height: 120px;
      display: flex;
      align-items: center;
    }

    .logo-rmuti {

      height: 100px;
    }

    .logo-loan {
      height: 50px;
    }

    .text-head {
      font-size: 20px;

    }

    .text-sub-head {
      font-size: 16px;

    }

    .secondary-text-head {
      font-size: 0px;
    }

    @media only screen and (max-width: 500px) {
      .text-head {
        font-size: 0;
      }

      .secondary-text-head {
        font-size: 18px;
      }

      .text-sub-head {
        font-size: 12px;
      }

      .logo-rmuti {

        height: 90px;
      }

      .logo-loan {
        height: 40px;
      }

    }

    @media only screen and (max-width:220px) {
      .top-nav {
        width: 100%;
        height: 160px;
        display: flex;
        align-items: center;
      }
    }
  </style>
</head>

<body id="page-top">
  <div class="top-nav">
    <div style="margin-left:15px ">
      <a href="{{ route('user.login') }}">
        <img class="logo-rmuti " src="{{asset('assets/img/RMUTI_KORAT.png') }}" alt="">
      </a>
    </div>
    <div>
      <a href="{{ route('user.login') }}">
        <img class="logo-loan"
          src="
        https://upload.wikimedia.org/wikipedia/commons/thumb/c/c8/Student_Loan_logo.svg/512px-Student_Loan_logo.svg.png"
          href="{{ route('user.login') }}" alt="">
      </a>
    </div>

    <div>
      <div class="text-head">
        ระบบส่งเอกสารออนไลน์กองทุนเงินให้กู้ยืมเพื่อการศึกษา
      </div>
      <div class="secondary-text-head">
        ระบบส่งเอก กยศ. สารออนไลน์
      </div>
      <div class="text-sub-head">
        มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน
      </div>
    </div>
  </div>
  <div class="nav-bar">
    <a href="{{ route('select') }}" style="float: right ; color: rgb(109, 175, 255)">สำหรับผู้ดูแลระบบ</a>
  </div>
  <div>
    <!-- Page Heading -->
    @include('include.content')
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

  <script>
    $(document).ready(function() {
      // show the alert
      $("#alert").fadeTo(10000, 500).slideUp(800, function(){
        $("#alert").alert('close');
      });
     
  });
  </script>
  @stack('scripts_default')
</body>

</html>