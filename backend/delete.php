<?php
    include_once "database/connection.php";
    session_start();

    if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true || $_SESSION['isAdmin'] !== true) {
        header("Location: login.php");
        exit;
    }

    $id = htmlspecialchars($_GET["id"]);
    $admin = htmlspecialchars($_GET["admin"]);

    $table = match($admin) {
        "true" => "Amministratori",
        "false" => "Pazienti",
        default => null
    };

    if($table === null){
        header("Location ../showdata.php?admin=$admin");
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM $table WHERE ID = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->execute();

    
    header("Location: ../showdata.php?admin=$admin");