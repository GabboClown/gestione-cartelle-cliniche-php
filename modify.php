<?php
if (!isset($_COOKIE['login']) || $_COOKIE['login'] != 'SUCCESSFULL') {
    header('Location: login.html');
}
$mode = htmlspecialchars($_GET["admin"]);
if($mode != 'true' && $mode != 'false') header("Location: dashboard.php");
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Comune di Napoli | Modifica <?php echo htmlspecialchars($_GET["admin"]) == "true" ? "admin" : "cittadino" ?></title>

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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Modifica i dati di un <?php echo htmlspecialchars($_GET["admin"]) == "true" ? "admin" : "cittadino" ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Modifica i dati di un <?php echo htmlspecialchars($_GET["admin"]) == "true" ? "admin" : "cittadino" ?></li>
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
              <form action="backend/alter.php?admin=<?php echo htmlspecialchars($_GET["admin"])?>&id=<?php echo htmlspecialchars($_GET["id"])?>" method="post">
                <div class="card-body">
                    <?php
                      
                      $id = htmlspecialchars($_GET["id"]);
                      $mode = htmlspecialchars($_GET["admin"]);

                      $DB = new mysqli("localhost", "gabbo", "");

                      if($mode == "true"){
                        
                        $template = $DB->prepare("SELECT * FROM anagrafe.autorizzati WHERE `id` = ?");
                        $template->bind_param('i', $id);
                        $template->execute();

                        $risultato = $template->get_result()->fetch_all(MYSQLI_ASSOC);

                        echo "
                          <div class=\"input-group mb-3\">
                            <div class=\"input-group-prepend\">
                              <span class=\"input-group-text\">
                                <i class=\"fa fa-address-book\"></i>
                              </span>
                            </div>
                            <input type=\"text\" class=\"form-control\" name=\"username\" placeholder=\"Username\" value=\"".$risultato[0]["username"]."\">

                            <div class=\"input-group-prepend\">
                              <span class=\"input-group-text\">
                                <i class=\"fa fa-key\"></i>
                              </span>
                            </div>
                            <input type=\"password\" class=\"form-control\" name=\"password\" placeholder=\"Password\" value=\"".$risultato[0]["password"]."\">
                          </div>
                        ";
                      }
                      else{

                        $template = $DB->prepare("SELECT * FROM anagrafe.cittadini WHERE `id` = ?");
                        $template->bind_param('i', $id);
                        $template->execute();

                        $risultato = $template->get_result()->fetch_all(MYSQLI_ASSOC);

                        echo "
                          <div class=\"input-group mb-3\">
                            <div class=\"input-group-prepend\">
                              <span class=\"input-group-text\">
                                <i class=\"fa fa-address-book\"></i>
                              </span>
                            </div>
                            <input type=\"text\" class=\"form-control\" name=\"nome\" placeholder=\"Nome\" value=\"".$risultato[0]["nome"]."\">

                            <div class=\"input-group-prepend\">
                              <span class=\"input-group-text\">
                                <i class=\"fa fa-address-book\"></i>
                              </span>
                            </div>
                            <input type=\"text\" class=\"form-control\" name=\"cognome\" placeholder=\"Cognome\" value=\"".$risultato[0]["cognome"]."\">

                            <div class=\"input-group-prepend\">
                              <span class=\"input-group-text\">
                                <i class=\"fa fa-id-badge\"></i>
                              </span>
                            </div>
                            <input type=\"text\" class=\"form-control\" name=\"cod_fisc\" placeholder=\"Codice Fiscale\" value=\"".$risultato[0]["codice_fiscale"]."\">
                          </div>

                          <div class=\"input-group mb-3\">
                            <div class=\"input-group-prepend\">
                              <span class=\"input-group-text\">
                                <i class=\"fa fa-calendar\"></i>
                              </span>
                            </div>
                            <input type=\"date\" class=\"form-control\" name=\"d_o_b\" placeholder=\"Data di Nascita\" value=\"".$risultato[0]["data_di_nascita"]."\">

                            <div class=\"input-group-prepend\">
                              <span class=\"input-group-text\">
                                <i class=\"fa fa-map-marker\"></i>
                              </span>
                            </div>
                            <input type=\"text\" class=\"form-control\" name=\"p_o_b\" placeholder=\"Luogo di Nascita\" value=\"".$risultato[0]["luogo_di_nascita"]."\">

                            <div class=\"input-group-prepend\">
                              <span class=\"input-group-text\">
                                <i class=\"fa fa-home\"></i>
                              </span>
                            </div>
                            <input type=\"text\" class=\"form-control\" name=\"indirizzo\" placeholder=\"Indirizzo di Residenza\" value=\"".$risultato[0]["indirizzo"]."\">

                            <div class=\"input-group-prepend\">
                              <span class=\"input-group-text\">
                                <i class=\"fa fa-phone\"></i>
                              </span>
                            </div>
                            <input type=\"text\" class=\"form-control\" name=\"num_tel\" placeholder=\"Numero di Telefono\" value=\"".$risultato[0]["num_telefono"]."\">
                          </div>
                        ";
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
</body>
</html>
