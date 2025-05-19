<?php
  include_once "backend/database/connection.php";
  session_start();

  if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true || $_SESSION['isAdmin'] !== true) {
    header("Location: login.php");
    exit;
  }
  $fisc = htmlspecialchars($_GET["fiscale"]) ?? "";
?>

<!DOCTYPE html>
<html lang="it">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestione Cartelle Cliniche | Aggiungi nuova Diagnosi</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="dipendenze/plugins/fontawesome-free/css/all.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="dipendenze/plugins/summernote/summernote-bs4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dipendenze/dist/css/adminlte.min.css">
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    </head>
    <body class="hold-transition sidebar-mini dark-mode">
        <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="dashboard.php" class="nav-link">Home</a>
            </li>
            </ul>

            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="backend/logout.php" role="button">
                <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="dashboard.php" class="brand-link">
            <img src="dipendenze/dist/img/Caduceus.svg" alt="Logo Gestione Cartelle Cliniche" class="brand-image img-circle">
            <span class="brand-text font-weight-light"><b>Gestionale</b></span>
            </a>

            <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Gestionale</li>
                <?php if ($_SESSION['isAdmin'] == true) : ?>
                    <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Statistiche</p>
                    </a>
                    </li>
                    <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                        Pazienti
                        <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
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
                    <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-lock"></i>
                        <p>
                        Amministratori
                        <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
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
                <?php else : ?>
                    <li class="nav-item">
                    <a href="<?= "modify.php?id=" . $_SESSION['ID'] . "&admin=false" ?>" class="nav-link">
                        <i class="nav-icon fas fa-user-edit"></i>
                        <p>Modifica il tuo profilo</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="<?= "cartella.php?id=" . $_SESSION['ID'] ?>" class="nav-link">
                        <i class="nav-icon fas fa-eye"></i>
                        <p>Visualizza la cartella</p>
                    </a>
                    </li>
                <?php endif ?>
                </ul>
            </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Aggiungi nuova Diagnosi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Aggiungi nuova Diagnosi</li>
                    </ol>
                </div>
                </div>
            </div>
            </section>

            <section class="content">
            <div class="container-fluid">
                <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Inserisci qui la nuova diagnosi</h3>
                    </div>
                    <form action="backend/addDiagnosis.php" method="post">
                        <div class="card-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-id-card"></i>
                            </span>
                            </div>
                            <input type="text" class="form-control" name="Cod_fiscale" required placeholder="Codice Fiscale Paziente" value="<?= $fisc ?>">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-hospital"></i>
                            </span>
                            </div>
                            <input type="text" class="form-control" name="Ospedale" required placeholder="Nome Ospedale">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-map-marker-alt"></i>
                            </span>
                            </div>
                            <input type="text" class="form-control" name="Indirizzo" required placeholder="Indirizzo Ospedale">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-calendar"></i>
                            </span>
                            </div>
                            <input type="date" class="form-control" name="Data" placeholder="Data Diagnosi">
                        </div>
                        
                        <div x-data="{ quesiti: [''] }">
                            <template x-for="(q, i) in quesiti" :key="i">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-medkit"></i>
                                        </span>
                                    </div>
                                    <input type="text"
                                        class="form-control"
                                        name="Quesiti[]"
                                        placeholder="Quesito Diagnostico"
                                        x-model="quesiti[i]"
                                        @input="if (i === quesiti.length - 1 && q.trim() !== '') quesiti.push('')"
                                        :required="i === 0">
                                </div>
                            </template>
                        </div>
                        </div>
                        <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Invia</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
            </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
            <b>Versione</b> 1.2.0
            </div>
            <strong>Copyright &copy; 2025-2026 
            <a href="https://github.com/GabboClown/gestione-cartelle-cliniche-php">
                Gestione <b>Cartelle Cliniche</b>
            </a>.
            </strong> Tutti i diritti riservati.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark"></aside>
        </div>

        <!-- Scripts -->
        <script src="dipendenze/plugins/jquery/jquery.min.js"></script>
        <script src="dipendenze/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="dipendenze/plugins/summernote/summernote-bs4.min.js"></script>
        <script src="dipendenze/dist/js/adminlte.min.js"></script>
        <script>
        $(function () {
            bsCustomFileInput?.init();
        });
        </script>
        <?php $conn->close(); ?>
    </body>
</html>
