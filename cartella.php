<?php
  include_once "backend/database/connection.php";
  session_start();

  if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
      header("Location: login.html");
      exit;
  }

  $id = htmlspecialchars($_GET["id"]);
  
  $patientQuery = "
      SELECT 
          Nome,
          Cognome,
          Data_Nascita,
          Sesso
      FROM Pazienti
      WHERE ID = :id
  ";
  $patientStmt = $conn->prepare($patientQuery);
  $patientStmt->bindValue(":id", $id, SQLITE3_TEXT);
  $patientResult = $patientStmt->execute();
  $patient = $patientResult->fetchArray(SQLITE3_ASSOC);

  if (!$patient) {
      header("Location: index.php");
      exit;
  }

  
  $query = "
        SELECT 
            D.Data_Diagnosi,
            O.Nome AS Ospedale,
            GROUP_CONCAT(Q.Descrizione, ', ') AS Quesiti
        FROM Diagnosi D
        JOIN Ospedali O ON D.ID_Ospedale = O.ID
        LEFT JOIN Diagnosi_Quesiti DQ ON D.ID = DQ.ID_Diagnosi
        LEFT JOIN Quesiti_Diagnostici Q ON DQ.ID_Quesito = Q.ID
        WHERE D.ID_Paziente = :id
        GROUP BY D.ID
        ORDER BY D.Data_Diagnosi
    ";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(":id", $id, SQLITE3_TEXT);
    $result = $stmt->execute();
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestione Cartelle Cliniche | Cartella Clinica <?= ($patient["Nome"] ?? "") . " " . ($patient["Cognome"] ?? "") ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="dipendenze/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="dipendenze/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="dipendenze/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="dipendenze/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dipendenze/dist/css/adminlte.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="dipendenze/plugins/summernote/summernote-bs4.min.css">
  <style>
    td.action > a.nav-link {
      justify-content: center;
      display: flex;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini dark-mode">

<div class="wrapper">
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
              Pazienti
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
              Amministratori
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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cartella Clinica <b><?= ($patient["Nome"] ?? "") . " " . ($patient["Cognome"] ?? "") ?></b></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Cartella Clinica <b><?= ($patient["Nome"] ?? "") . " " . ($patient["Cognome"] ?? "") ?></b></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    <?= "Paziente <b>" . ($patient["Nome"] ?? "") . " " . ($patient["Cognome"] ?? "") . 
                        "</b> (" . ($patient["Sesso"] ?? "Sesso") . "). <br>Nato il " . 
                        (isset($patient["Data_Nascita"]) 
                            ? date("d-M-Y", strtotime($patient["Data_Nascita"])) 
                            : "Data sconosciuta") ?>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-hover datatable">
                <thead>
                    <tr>
                        <th>Data Diagnosi</th>
                        <th>Ospedale</th>
                        <th>Quesiti Diagnostici</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)): ?>
                    <tr>
                        <td><?= htmlspecialchars(date("d-m-Y", strtotime($row["Data_Diagnosi"]))) ?></td>
                        <td><?= htmlspecialchars($row["Ospedale"]) ?></td>
                        <td><?= htmlspecialchars($row["Quesiti"] ?? "Nessun quesito") ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Data Diagnosi</th>
                        <th>Ospedale</th>
                        <th>Quesiti Diagnostici</th>
                    </tr>
                </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
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

<script src="check_cookies.js"></script>

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
<!-- Summernote -->
<script src="dipendenze/plugins/summernote/summernote-bs4.min.js"></script>
<!-- Sparkline -->
<script src="dipendenze/plugins/sparklines/sparkline.js"></script>
<!-- AdminLTE App -->
<script src="dipendenze/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dipendenze/dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
  $('.datatable').each(function() {
    var table = $(this).DataTable({
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
    });

    // Posiziona i bottoni nel contenitore più vicino alla tabella
    table.buttons().container().appendTo(
      $(this).closest('.card-body').find('.col-md-6:eq(0)')
    );
  });
});
</script>
<?php $conn->close() ?>
</body>
</html>