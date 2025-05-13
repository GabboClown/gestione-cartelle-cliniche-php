<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_COOKIE['login']) || $_COOKIE['login'] != 'SUCCESSFULL') {
    header('Location: login.html');
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Comune di Napoli | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="dipendenze/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="dipendenze/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="dipendenze/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dipendenze/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="dipendenze/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="dipendenze/plugins/summernote/summernote-bs4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="dipendenze/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="dipendenze/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="dipendenze/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed dark-mode">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dipendenze/dist/img/Comune di Napoli.png" alt="Logo Comune di Napoli" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="backend/logout.php" role="button">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
      <img src="dipendenze/dist/img/Comune di Napoli.png" alt="Logo Comune di Napoli" class="brand-image img-circle">
      <span class="brand-text font-weight-light">Comune di <b>Napoli</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">Gestionale</li>
        <li class="nav-item">
          <a href="dashboard.php" class="nav-link">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>
            Statistiche
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-users"></i>
              <p>
              Cittadini
              <i class="fas fa-angle-left right"></i>
              </p>
            </a>
          <ul class="nav nav-treeview" style="display: none;">
            <li class="nav-item">
              <a href="showdata.php?admin=false" class="nav-link">
                <i class="fa fa-user-circle nav-icon"></i>
                <p>Mostra</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="insertnew.php?admin=false" class="nav-link">
                <i class="fa fa-user-plus nav-icon"></i>
                <p>Inserisci</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-lock"></i>
              <p>
              Autorizzati
              <i class="fas fa-angle-left right"></i>
              </p>
            </a>
          <ul class="nav nav-treeview" style="display: none;">
            <li class="nav-item">
              <a href="showdata.php?admin=true" class="nav-link">
                <i class="fa fa-user-circle nav-icon"></i>
                <p>Mostra</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="insertnew.php?admin=true" class="nav-link">
                <i class="fa fa-user-plus nav-icon"></i>
                <p>Inserisci</p>
              </a>
            </li>
          </ul>
        </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Bentornato/a <b><?php echo $_COOKIE["username"]?></b>!</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Statistiche</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>
                  <?php 
                    $DB = new mysqli("localhost", "gabbo", "");
                      echo $DB->query("SELECT * FROM anagrafe.cittadini")->num_rows;
                    $DB->close();
                  ?>
                </h3>

                <p>Cittadini registrati</p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
              <a href="showdata.php?admin=false" class="small-box-footer">Visualizza tutti <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <h3>
                  <?php 
                    $DB = new mysqli("localhost", "gabbo", "");
                      echo round(($DB->query("SELECT * FROM anagrafe.cittadini WHERE YEAR(data_di_nascita) <= YEAR(CURDATE()) - 18;")->num_rows * 100) / $DB->query("SELECT * FROM anagrafe.cittadini")->num_rows, 2); 
                    $DB->close();
                  ?>
                  <sup style="font-size: 20px">%</sup>
              </h3>

                <p>Cittadini maggiorenni</p>
              </div>
              <div class="icon">
                <i class="fa fa-birthday-cake"></i>
              </div>
              <a href="showdata.php?admin=false" class="small-box-footer">Visualizza tutti <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <h3>
              <?php 
                    $DB = new mysqli("localhost", "gabbo", "");
                      echo round(($DB->query("SELECT * FROM anagrafe.cittadini WHERE YEAR(data_di_nascita) <= YEAR(CURDATE()) - 60;")->num_rows * 100) / $DB->query("SELECT * FROM anagrafe.cittadini")->num_rows, 2); 
                    $DB->close();
                  ?>
                  <sup style="font-size: 20px">%</sup>
              </h3>

                <p>Cittadini over 60</p>
              </div>
              <div class="icon">
                <i class="fa fa-blind"></i>
              </div>
              <a href="showdata.php?admin=false" class="small-box-footer">Visualizza tutti <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <h3>
                  <?php 
                    $DB = new mysqli("localhost", "gabbo", "");
                      echo $DB->query("SELECT * FROM anagrafe.autorizzati")->num_rows;
                    $DB->close();
                  ?>
                </h3>

                <p>Amministratori Registrati</p>
              </div>
              <div class="icon">
                <i class="fa fa-lock"></i>
              </div>
              <a href="showdata.php?admin=true" class="small-box-footer">Visualizza tutti <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-6">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Database contenente informazioni anagrafiche di alcuni cittadini residenti nel Comune di <b>Napoli</b></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Cognome</th>
                      <th>Codice Fiscale</th>
                      <th>Data di Nascita</th>
                      <th>Luogo di Nascita</th>
                      <th>Indirizzo</th>
                      <th>Numero di Telefono</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $DB = new mysqli("localhost", "gabbo", "");
                        $risultato = $DB->query("SELECT * FROM anagrafe.cittadini LIMIT 10")->fetch_all(MYSQLI_NUM);
                        foreach($risultato as $row){
                            echo "<tr>";
                            foreach($row as $column){
                                echo "<th>$column</th>";
                            }
                            echo "</tr>";
                        }
                        $DB->close();
                      ?>
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Cognome</th>
                      <th>Codice Fiscale</th>
                      <th>Data di Nascita</th>
                      <th>Luogo di Nascita</th>
                      <th>Indirizzo</th>
                      <th>Numero di Telefono</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
              <!-- /.card -->
            </div>
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-6">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Database contenente informazioni sugli amministratori del gestionale del Comune di <b>Napoli</b></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Username</th>
                      <th>Password</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $DB = new mysqli("localhost", "gabbo", "");
                        $risultato = $DB->query("SELECT * FROM anagrafe.autorizzati LIMIT 10")->fetch_all(MYSQLI_NUM);
                        foreach($risultato as $row){
                            echo "<tr>";
                            foreach($row as $column){
                                echo "<th>$column</th>";
                            }
                            echo "</tr>";
                        }
                        $DB->close();
                      ?>
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Username</th>
                      <th>Password</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
              <!-- /.card -->
            </div>
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Versione</b> 1.2.0
    </div>
    <strong>Copyright &copy; 2023-2024 <a href="https://github.com/GabboClown">Comune di <b>Napoli</b></a>.</strong> Tutti i diritti riservati.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="dipendenze/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="dipendenze/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- DataTables  & Plugins -->
<script src="dipendenze/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="dipendenze/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="dipendenze/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="dipendenze/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="dipendenze/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="dipendenze/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="dipendenze/plugins/jszip/jszip.min.js"></script>
<script src="dipendenze/plugins/pdfmake/pdfmake.min.js"></script>
<script src="dipendenze/plugins/pdfmake/vfs_fonts.js"></script>
<script src="dipendenze/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="dipendenze/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="dipendenze/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Bootstrap 4 -->
<script src="dipendenze/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- JQVMap -->
<script src="dipendenze/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="dipendenze/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="dipendenze/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="dipendenze/plugins/moment/moment.min.js"></script>
<script src="dipendenze/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="dipendenze/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- overlayScrollbars -->
<script src="dipendenze/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dipendenze/dist/js/adminlte.js"></script>
<!-- Summernote -->
<script src="dipendenze/plugins/summernote/summernote-bs4.min.js"></script>
<!-- Sparkline -->
<script src="dipendenze/plugins/sparklines/sparkline.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dipendenze/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dipendenze/dist/js/pages/dashboard.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
