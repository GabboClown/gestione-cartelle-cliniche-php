<?php
    include_once "database/connection.php";
    session_start();

    if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
        header("Location: login.html");
        exit;
    }

    if(isset($_POST)){
        $mode = htmlspecialchars($_GET["admin"]);
        
        if ($mode == "true") {
            $template = $conn->prepare("INSERT INTO Amministratori(Nome, Cognome, Email, Password) VALUES (:nome, :cognome, :email, :password)");
            $template->bindValue(':nome', $_POST["Nome"], SQLITE3_TEXT);
            $template->bindValue(':cognome', $_POST["Cognome"], SQLITE3_TEXT);
            $template->bindValue(':email', $_POST["email"], SQLITE3_TEXT);
            $template->bindValue(':password', hash('sha256', $_POST["password"]), SQLITE3_TEXT);
            $template->execute();
        } else if ($mode == "false") {
            // TODO: Aggiungere CRUD Cartella clinica (vista per ogni paziente di tutte le problematiche, con aggiunta e rimozione)
            // TODO: Aggiunta filtri visualizzazione pazienti (ultra 60enni ecc)
            $template = $conn->prepare("INSERT INTO Pazienti(Cod_fiscale, Nome, Cognome, Data_Nascita, Sesso) VALUES (:cod_fiscale, :nome, :cognome, :data_nascita, :sesso)");
            $template->bindValue(':cod_fiscale', $_POST["Cod_fiscale"], SQLITE3_TEXT);
            $template->bindValue(':nome', $_POST["Nome"], SQLITE3_TEXT);
            $template->bindValue(':cognome', $_POST["Cognome"], SQLITE3_TEXT);
            $template->bindValue(':data_nascita', $_POST["Data_Nascita"], SQLITE3_TEXT);
            $template->bindValue(':sesso', $_POST["Sesso"], SQLITE3_TEXT);
            $template->execute();
        }        

        else header("Location: ../dashboard.php");

        header("Location: ../showdata.php?admin=$mode");
    }
    else header("Location: ../dashboard.php");