<?php
  include_once "backend/database/connection.php";
  session_start();
  if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
      header("Location: login.html");
      exit;
  }
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestione Cartelle Cliniche | Dashboard</title>

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
    <img class="animation__shake" src="dipendenze/dist/img/Caduceus.svg" alt="Logo Gestione Cartelle Cliniche" height="60" width="60">
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
      <img src="dipendenze/dist/img/Caduceus.svg" alt="Logo Gestione Cartelle Cliniche" class="brand-image img-circle">
      <span class="brand-text font-weight-light"><b>Gestionale</b></span>
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
            <h1 class="m-0">Bentornato/a <b><?php 
              $stmt = $conn->prepare("SELECT Nome FROM Amministratori WHERE ID = :id");
              $stmt->bindValue(':id', $_SESSION['ID'], SQLITE3_INTEGER);
              $result = $stmt->execute();
              $row = $result->fetchArray(SQLITE3_ASSOC);
              echo $row['Nome'] ?? "";
            ?></b>!</h1>
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
                    // Esegue la query e ritorna la prima riga del risultato
                    $numPazienti = $conn->querySingle("SELECT COUNT(*) AS Numero FROM Pazienti", true);
                    echo $numPazienti["Numero"] ?? 0;
                  ?>
                </h3>

                <p>Pazienti registrati</p>
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
                    $numMaggiorenni = $conn->querySingle("SELECT COUNT(*) AS Numero FROM Pazienti WHERE Data_Nascita <= date('now', '-18 years')", true);
                    if($numMaggiorenni != 0 && $numPazienti != 0){
                      echo round(($numMaggiorenni["Numero"] / $numPazienti["Numero"]) * 100, 2);
                    } else {
                      echo 0;
                    }
                    ?>
                  <sup style="font-size: 20px">%</sup>
                </h3>
                <p>Pazienti maggiorenni</p>
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
                    $numOver65 = $conn->querySingle("SELECT COUNT(*) AS Numero FROM Pazienti WHERE Data_Nascita <= date('now', '-65 years')", true);
                    if($numOver65["Numero"] != 0 && $numPazienti["Numero"] != 0) {
                      echo round(($numOver65["Numero"] / $numPazienti["Numero"]) * 100, 2);
                    } else {
                      echo 0;
                    }
                  ?>
                  <sup style="font-size: 20px">%</sup>
              </h3>
                <p>Pazienti over 65</p>
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
                    $numAdmin = $conn->querySingle("SELECT COUNT(*) AS Numero FROM Amministratori", true);
                    echo $numAdmin["Numero"] ?? 0;
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
                <h3 class="card-title">DataTable with default features</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Rendering engine</th>
                      <th>Browser</th>
                      <th>Platform(s)</th>
                      <th>Engine version</th>
                      <th>CSS grade</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th>test1</th>
                      <th>test2</th>
                      <th>test3</th>
                      <th>test4</th>
                      <th>test5</th>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Rendering engine</th>
                      <th>Browser</th>
                      <th>Platform(s)</th>
                      <th>Engine version</th>
                      <th>CSS grade</th>
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
                  <h3 class="card-title">Tabella contenente informazioni sugli amministratori del seguente <b>gestionale</b></h3>
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
    <strong>Copyright &copy; 2025-2026 <a href="https://github.com/GabboClown/gestione-cartelle-cliniche-php">Gestione <b>Cartelle Cliniche</b></a>.</strong> Tutti i diritti riservati.
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
<!-- jQuery -->
<script src="dipendenze/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="dipendenze/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
<!-- AdminLTE App -->
<script src="dipendenze/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dipendenze/dist/js/demo.js"></script>
<!-- Page specific script -->
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
<?php $conn->close() ?>
</body>
</html>
