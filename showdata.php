<?php
  include_once "backend/database/connection.php";
  session_start();

  if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
      header("Location: login.html");
      exit;
  }
  $mode = htmlspecialchars($_GET["admin"]);
  $isAdmin = match($mode) {
    "true" => true,
    "false" => false,
    default => null
  };
  if($isAdmin === null) header("Location: dashboard.php");

  $filter = htmlspecialchars($_GET["filters"]);
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestione Cartelle Cliniche | Database <?php echo $isAdmin ? "Admin" : "Cittadini";?></title>

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
            <li class="nav-item">
              <a href="newdiagnosis.php" class="nav-link">
                <i class="fa fa-user-plus nav-icon"></i>
                <p>Aggiungi Diagnosi</p>
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
            <h1>Database <?php echo $isAdmin ? "Admin" : "Pazienti";?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Database <?php echo $isAdmin ? "Admin" : "Pazienti";?></li>
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
                    <?php
                        if($isAdmin) {
                          echo "Tabella contenente informazioni sugli amministratori del seguente <b>gestionale</b>";
                        }
                        else {
                          echo "Tabella contenente informazioni anagrafiche dei pazienti registrati nel seguente <b>gestionale</b>";
                        } 
                    ?>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php if(!$isAdmin) :?>
                  <?php
                    $filtroCorrente = $_GET['filtro'] ?? null;
                  ?>
                  <form method="get" action="showdata.php">
                    <input type="hidden" name="admin" value="false">
                    <label>
                      <input type="radio" name="filtro" value="maggiorenni" <?php if ($filtroCorrente === 'maggiorenni') echo 'checked'; ?>>
                      Pazienti maggiorenni (≥18)
                    </label><br>
                    <label>
                      <input type="radio" name="filtro" value="over65" <?php if ($filtroCorrente === 'over65') echo 'checked'; ?>>
                      Pazienti over 65
                    </label><br>
                    <label>
                      <input type="radio" name="filtro" value="ospedale" <?php if ($filtroCorrente === 'ospedale') echo 'checked'; ?>>
                      Filtra per ospedale:
                      <input type="text" name="ospedale" value="<?php echo htmlspecialchars($_GET['ospedale'] ?? ''); ?>">
                    </label><br>
                    <label>
                      <input type="radio" name="filtro" value="" <?php if ($filtroCorrente === '' || is_null($filtroCorrente)) echo 'checked'; ?>>
                      Nessun filtro
                    </label><br>
                    <button type="submit">Applica filtro</button>
                  </form>
                  <br>
                <?php endif ?>
                <table class="table table-bordered table-hover datatable">
                  <thead>
                  <tr>
                    <?php
                    if($isAdmin){
                        echo   "<th>ID</th>
                                <th>Email</th>
                                <th>Nome</th>
                                <th>Cognome</th>
                                <th></th>
                                <th></th>";
                    }
                    else{
                        echo   "<th>ID</th>
                                <th>Codice Fiscale</th>
                                <th>Nome</th>
                                <th>Cognome</th>
                                <th>Data di Nascita</th>
                                <th>Sesso</th>
                                <th></th>
                                <th></th>
                                <th></th>";
                    }
                    ?>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                      if ($isAdmin) {
                        $result = $conn->query("SELECT ID, Email, Nome, Cognome FROM Amministratori");
                      } else {
                        $filtro = $_GET['filtro'] ?? '';
                        $ospedale = trim($_GET['ospedale'] ?? '');
                        if($filtro) {
                          switch ($filtro) {
                            case 'maggiorenni':
                                $result = $conn->query("SELECT * FROM Pazienti WHERE Data_Nascita <= date('now', '-18 years')");
                                break;
                            case 'over65':
                                $result = $conn->query("SELECT * FROM Pazienti WHERE Data_Nascita <= date('now', '-65 years')");
                                break;
                            case 'ospedale':
                                if ($ospedale !== '') {
                                  $stmt = $conn->prepare("SELECT p.* FROM Pazienti p
                                                          JOIN Diagnosi d ON p.ID = d.ID_Paziente
                                                          JOIN Ospedali o ON o.ID = d.ID_Ospedale
                                                          WHERE o.Nome = :nome");
                                  $stmt->bindValue(':nome', $ospedale, SQLITE3_TEXT);
                                  $result = $stmt->execute();
                                }
                                break;
                            default:
                                // Nessun filtro applicato
                                break;
                            }
                        } else {
                          $result = $conn->query("SELECT * FROM Pazienti");
                        }
                      }
                    
                      if ($result) {
                        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                          echo "<tr>";
                          
                          foreach ($row as $column) {
                            echo "<td>" . htmlspecialchars($column) . "</td>";
                          }
                    
                          $id = htmlspecialchars($row['ID']);
                                        
                          echo "<td class=\"action\">
                                  <a class=\"nav-link\" href=\"backend/delete.php?id=$id&admin=" . ($admin ? 'true' : 'false') . "\" role=\"button\">
                                    <i class=\"fas fa-user-alt-slash\"></i>
                                  </a>
                                </td>";
                    
                          echo "<td class=\"action\">
                                  <a class=\"nav-link\" href=\"modify.php?id=$id&admin=" . ($admin ? 'true' : 'false') . "\" role=\"button\">
                                    <i class=\"fas fa-user-edit\"></i>
                                  </a>
                                </td>";

                          if(!$isAdmin) {
                            echo "<td class=\"action\">
                                  <a class=\"nav-link\" href=\"cartella.php?id=$id\" role=\"button\">
                                    <i class=\"fas fa-eye\"></i>
                                  </a>
                                </td>";
                          }
                    
                          echo "</tr>";
                        }
                      } else {
                        echo "<tr><td colspan='100%'>Nessun dato trovato</td></tr>";
                      }
                    ?>
                  </tbody>
                  <tfoot>
                  <tr>
                  <?php
                    if($isAdmin){
                        echo   "<th>ID</th>
                                <th>Email</th>
                                <th>Nome</th>
                                <th>Cognome</th>
                                <th></th>
                                <th></th>";
                    }
                    else{
                        echo   "<th>ID</th>
                                <th>Codice Fiscale</th>
                                <th>Nome</th>
                                <th>Cognome</th>
                                <th>Data di Nascita</th>
                                <th>Sesso</th>
                                <th></th>
                                <th></th>
                                <th></th>";
                    }
                    ?>
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