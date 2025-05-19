<?php
  include_once "backend/database/connection.php";
  session_start();

  if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    header("Location: login.php");
    exit;
  }
  
  $id = htmlspecialchars($_GET["id"]);
  if ($id != $_SESSION["ID"] && $_SESSION["isAdmin"] !== true) {
    header("Location: login.php");
    exit;
  }
  $mode = htmlspecialchars($_GET["admin"]);
  if($mode != 'true' && $mode != 'false') header("Location: dashboard.php");
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestione Cartelle Cliniche | Modifica <?php echo htmlspecialchars($_GET["admin"]) == "true" ? "admin" : "paziente" ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="dipendenze/plugins/fontawesome-free/css/all.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="dipendenze/plugins/summernote/summernote-bs4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dipendenze/dist/css/adminlte.min.css">
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
        <?php if($_SESSION['isAdmin'] == true) :?>
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
                            <i class="fa fa-notes-medical nav-icon"></i>
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
        <?php else :?>
          <li class="nav-item">
            <a href=<?= "modify.php?id=" . $_SESSION['ID'] ."&admin=false" ?> class="nav-link">
              <i class="nav-icon fas fa-user-edit"></i>
              <p>
              Modifica il tuo profilo
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href=<?= "cartella.php?id=" . $_SESSION['ID'] ?> class="nav-link">
              <i class="nav-icon fas fa-eye"></i>
              <p>
              Visualizza la cartella
              </p>
            </a>
          </li>
        <?php endif ?>
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
            <h1>Modifica i dati di un <?php echo htmlspecialchars($_GET["admin"]) == "true" && $_SESSION['isAdmin'] == true ? "admin" : "paziente" ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Modifica i dati di un <?php echo htmlspecialchars($_GET["admin"]) == "true" && $_SESSION['isAdmin'] == true ? "admin" : "paziente" ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Inserisci qui i nuovi dati.</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="backend/alter.php?admin=<?php echo htmlspecialchars($_GET["admin"]) ?>&id=<?php echo $id ?>" method="post">
                <div class="card-body">
                  <?php
                    $id = (int) $_GET["id"];
                    $mode = htmlspecialchars($_GET["admin"]);

                    if ($mode == "true" && $_SESSION['isAdmin'] !== true) {
                      $template = $conn->prepare("SELECT * FROM Amministratori WHERE ID = :id");
                      $template->bindValue(':id', $id, SQLITE3_INTEGER);
                      $result = $template->execute();
                      $row = $result->fetchArray(SQLITE3_ASSOC);

                      echo "
                        <div class=\"input-group mb-3\">
                        <div class=\"input-group-prepend\">
                          <span class=\"input-group-text\">
                            <i class=\"fa fa-address-book\"></i>
                          </span>
                        </div>
                        <input type=\"text\" class=\"form-control\" name=\"Nome\" placeholder=\"Nome\" value=\"" . htmlspecialchars($row["Nome"]) . "\">

                        <div class=\"input-group-prepend\">
                          <span class=\"input-group-text\">
                            <i class=\"fa fa-address-book\"></i>
                          </span>
                        </div>
                        <input type=\"text\" class=\"form-control\" name=\"Cognome\" placeholder=\"Cognome\" value=\"" . htmlspecialchars($row["Cognome"]) . "\">

                        <div class=\"input-group-prepend\">
                          <span class=\"input-group-text\">
                            <i class=\"fa fa-address-book\"></i>
                          </span>
                        </div>
                        <input type=\"email\" class=\"form-control\" name=\"email\" placeholder=\"Username\" value=\"" . htmlspecialchars($row["Email"]) . "\">
                        
                          <div class=\"input-group-prepend\">
                            <span class=\"input-group-text\">
                              <i class=\"fa fa-key\"></i>
                            </span>
                          </div>
                          <input type=\"password\" class=\"form-control\" name=\"password\" placeholder=\"Password\" value=\"" . htmlspecialchars($row["Password"]) . "\">
                        </div>
                      ";
                    } else {
                      $template = $conn->prepare("SELECT * FROM Pazienti WHERE id = :id");
                      $template->bindValue(':id', $id, SQLITE3_INTEGER);
                      $result = $template->execute();
                      $row = $result->fetchArray(SQLITE3_ASSOC);

                      echo '
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fa fa-address-book"></i>
                            </span>
                          </div>
                          <input type="text" class="form-control" name="Nome" placeholder="Nome" value="' . htmlspecialchars($row["Nome"]) . '">
                        </div>

                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fa fa-address-book"></i>
                            </span>
                          </div>
                          <input type="text" class="form-control" name="Cognome" placeholder="Cognome" value="' . htmlspecialchars($row["Cognome"]) . '">
                        </div>

                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fa fa-id-badge"></i>
                            </span>
                          </div>
                          <input type="text" class="form-control" name="Cod_fiscale" placeholder="Codice Fiscale" value="' . htmlspecialchars($row["Cod_fiscale"]) . '">
                        </div>

                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fa fa-calendar"></i>
                            </span>
                          </div>
                          <input type="date" class="form-control" name="Data_Nascita" placeholder="Data di Nascita" value="' . htmlspecialchars($row["Data_Nascita"]) . '">
                        </div>

                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fa fa-address-book"></i>
                            </span>
                          </div>
                          <input type="email" class="form-control" name="Email" placeholder="Email" value="' . htmlspecialchars($row["Email"]) . '">
                        </div>

                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fa fa-address-book"></i>
                            </span>
                          </div>
                          <input type="password" class="form-control" name="Password" placeholder="Password" value="' . htmlspecialchars($row["Password"]) . '">
                        </div>

                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="sesso">
                              <i class="fa fa-venus-mars"></i>
                            </label>
                          </div>
                          <select class="custom-select" name="Sesso" id="sesso">
                            <option value="M" ' . ($row["Sesso"] == "M" ? "selected" : "") . '>Maschio</option>
                            <option value="F" ' . ($row["Sesso"] == "F" ? "selected" : "") . '>Femmina</option>
                          </select>
                        </div>
                      ';
                    }
                  ?>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Invia</button>
                  </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
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
<!-- Bootstrap 4 -->
<script src="dipendenze/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dipendenze/dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="dipendenze/plugins/sparklines/sparkline.js"></script>
<!-- AdminLTE for demo purposes -->

<!-- Summernote -->
<script src="dipendenze/plugins/summernote/summernote-bs4.min.js"></script>
<script src="dipendenze/dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
<?php $conn->close() ?>
</body>
</html>
