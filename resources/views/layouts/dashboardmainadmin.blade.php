<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>{{ $title }}</title>

  <link href="{{ asset('/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i') }}" rel="stylesheet">
  <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/trix.css') }}" rel="stylesheet">
  <link rel="icon" type="image/png" href="../img/logo 1.png">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
  <style>
    .form-row {
      border-bottom: 0;
    }

  </style>

</head>

<body id="page-top">

  <div id="wrapper">

    <ul class="navbar-nav bg-white sidebar sidebar-dark accordion" id="accordionSidebar">

      <div class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
          <img src="../img/logo 1.png" alt="logo">
        </div>
        <div class="sidebar-brand-text">Dashboard</div>
      </div>

      <hr class="sidebar-divider my-0">

      <li class="nav-item {{ request()->is('homemainadmin') ? 'active' : '' }}">
        <a class="nav-link text-primary" href="/homemainadmin">
          <i class="fas fa-fw fa-home text-primary"></i>
          <span>Home</span></a>
      </li>

      <li class="nav-item {{ request()->is('rencanakegiatanmainadmin', 'jeniskegiatan', 'pelaksanaan') ? 'active' : '' }}">
        <a class="nav-link collapsed text-primary" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-file-signature text-primary"></i>
          <span>Data Management</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-gradient-primary py-2 collapse-inner rounded">
            <a class="collapse-item text-white {{ request()->is('rencanakegiatanmainadmin') ? 'active' : '' }}" href="/rencanakegiatanmainadmin">Rencana
              Kegiatan</a>
            <a class="collapse-item text-white {{ request()->is('pelaksanaan') ? 'active' : '' }}" href="{{ route('pelaksanaan.index') }}">Pelaksanaan</a>
            <a class="collapse-item text-white {{ request()->is('jeniskegiatan') ? 'active' : '' }}" href="{{ route('jeniskegiatan.index') }}">Jenis
              Kegiatan</a>
          </div>
        </div>
      </li>

      <li class="nav-item {{ request()->is('datamastermainadmin') ? 'active' : '' }}">
        <a class="nav-link text-primary" href="/datamastermainadmin?data=rencana">
          <i class="fas fa-fw fa-database text-primary"></i>
          <span>Data Master</span></a>
      </li>

      <li class="nav-item {{ request()->is('mainadmin/users') ? 'active' : '' }}">
        <a class="nav-link text-primary" href="{{ route('manage-user') }}">
          <i class="fas fa-fw fa-list text-primary"></i>
          <span>User Management</span></a>
      </li>

      <hr class="sidebar-divider d-none d-md-block">

      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>

    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <nav class="navbar navbar-expand navbar-light bg-primary topbar mb-4 static-top shadow">

          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>

            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-white small">{{ auth()->user()->nama_pengguna }}</span>
                <img class="img-profile rounded-circle" src="{{ asset('uploads/' . auth()->user()->username . '.jpg') }}">
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/profilmainadmin">
                  <i class="fas fa-user fa-sm fa-fw mr-2"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="/ubahpasswordmainadmin">
                  <i class="fas fa-key fa-sm fa-fw mr-2"></i>
                  Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>

        @yield('content')

        <a class="scroll-to-top rounded" href="#page-top">
          <i class="fas fa-angle-up"></i>
        </a>

        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true"></span>
                </button>
              </div>
              <div class="modal-body">Select "Logout" below if you are ready to end your current
                session.</div>
              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="/">Logout</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/sistem.js"></script>
  <script src="../js/trix.js"></script>
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="../js/demo/chart-area-demo.js"></script>
  <script src="../js/demo/chart-pie-demo.js"></script>
  <script src="https://cdn.datatables.net/autofill/2.3.9/js/dataTables.autoFill.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>

  <script type="text/javascript">
    $($datauser).ready(function() {
      var table = $('#datauser').DataTable();

      table.on('click', '.edit', function() {
        $tr = $(this).closest('tr');
        if ($($tr).hasClass('child')) {
          $tr = $tr.prev('.parent');
        }

        var data = table.row($tr).data();
        console.log(data);

        $('#username').val(data[1]);
        $('#password').val(data[2]);
        $('#nama_pengguna').val(data[3]);
        $('#pangkat').val(data[4]);
        $('#NRP').val(data[5]);
        $('#jabatan').val(data[6]);
        $('#tempatlahir').val(data[7]);
        $('#tanggallahir').val(data[8]);
        $('#jeniskelamin').val(data[9]);
        $('#agama').val(data[10]);
        $('#email').val(data[11]);

        $('#editForm').attr('action', 'datauser' + data[0]);
        $('#updateuser').modal('show');
      });
    });
  </script>
  @stack('js')

</body>

</html>
