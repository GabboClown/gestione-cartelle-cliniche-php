<?php
  include_once "backend/database/connection.php";
  session_start();

  if (isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] == true) {
    if($_SESSION['isAdmin'] == true) {
      header("Location: dashboard.php");
      exit;
    } else {
      header("Location: cartella.php?id=".$_SESSION["ID"]);
      exit;
    }
  }
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestione Cartelle Cliniche | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="dipendenze/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dipendenze/dist/css/adminlte.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="dipendenze/plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition login-page dark-mode">
<div class="login-box">
  <div class="login-logo">
    <img src="dipendenze/dist/img/Caduceus.svg"></img>
  </div>
  <div class="login-logo">
    Gestione <b>Cartelle Cliniche</b>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Autenticati per accedere al terminale</p>

      <form action="backend/adminLogin.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Entra</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <span style="display: flex; justify-content: center;">Sei un paziente? Accedi <a href="login.php" style="margin-left: 3px;">qui</a></span>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- Summernote -->
<script src="dipendenze/plugins/summernote/summernote-bs4.min.js"></script>
<!-- Sparkline -->
<script src="dipendenze/plugins/sparklines/sparkline.js"></script>
<script>
  // Funzione per leggere i parametri GET
  function getQueryParam(param) {
      const params = new URLSearchParams(window.location.search);
      return params.get(param);
  }

  const error = getQueryParam("error");
  if (error === "1") {
      alert("Credenziali errate.");
  }
</script>
</body>
</html>