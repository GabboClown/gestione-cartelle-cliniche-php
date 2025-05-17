<?php
    session_start();

    if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
        header("Location: login.html");
        exit;
    } else {
        header("Location: dashboard.php");
        exit;
    }