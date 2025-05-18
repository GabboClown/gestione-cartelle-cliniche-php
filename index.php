<?php
    session_start();

    if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
        header("Location: login.php");
        exit;
    } else {
        if($_SESSION['isAdmin'] == true) {
            header("Location: dashboard.php");
            exit;
        } else {
            header("Location: cartella.php?id=".$_SESSION["ID"]);
            exit;
        }
    }