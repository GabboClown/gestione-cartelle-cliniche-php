<?php
    include_once "database/connection.php";
    session_start();

    if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
        header("Location: ../login.php");
        exit;
    }

    if(isset($_POST)){
        $mode = htmlspecialchars($_GET["admin"]);
        $id = htmlspecialchars($_GET["id"]);

        if ($mode === "true" && $_SESSION['isAdmin'] == true) {
            $stmt = $conn->prepare('SELECT Password FROM Amministratori WHERE ID = :id');
            $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
            $result = $stmt->execute();

            $row = $result->fetchArray(SQLITE3_ASSOC);
            $oldPwd = $row['Password'];
            $newPwd = $_POST["password"];

            // Se la nuova password cambiata, allora viene rehashata, altrimenti non verrà cambiata
            $newPwd = $oldPwd == $newPwd ? $oldPwd : hash('sha256', $newPwd);

            $stmt = $conn->prepare("UPDATE Amministratori SET Nome = :nome, Cognome= :cognome, Email = :email, password = :password WHERE id = :id");
            $stmt->bindValue(':nome', $_POST["Nome"], SQLITE3_TEXT);
            $stmt->bindValue(':cognome', $_POST["Cognome"], SQLITE3_TEXT);
            $stmt->bindValue(':email', $_POST["email"], SQLITE3_TEXT);
            $stmt->bindValue(':password', $newPwd, SQLITE3_TEXT);
            $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
            $stmt->execute();
        } 
        else if ($mode === "false") {
            $stmt = $conn->prepare('SELECT Password FROM Pazienti WHERE ID = :id');
            $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
            $result = $stmt->execute();

            $row = $result->fetchArray(SQLITE3_ASSOC);
            $oldPwd = $row['Password'];
            $newPwd = $_POST["Password"];

            // Se la nuova password cambiata, allora viene rehashata, altrimenti non verrà cambiata
            $newPwd = $oldPwd == $newPwd ? $oldPwd : hash('sha256', $newPwd);

            $stmt = $conn->prepare("UPDATE Pazienti SET 
                Nome = :nome, 
                Cognome = :cognome, 
                Cod_fiscale = :codice_fiscale, 
                Data_Nascita = :data_di_nascita, 
                Sesso = :sesso,
                Email = :email,
                Password = :password
                WHERE id = :id");

            $stmt->bindValue(':nome', $_POST["Nome"], SQLITE3_TEXT);
            $stmt->bindValue(':cognome', $_POST["Cognome"], SQLITE3_TEXT);
            $stmt->bindValue(':codice_fiscale', $_POST["Cod_fiscale"], SQLITE3_TEXT);
            $stmt->bindValue(':data_di_nascita', $_POST["Data_Nascita"], SQLITE3_TEXT);
            $stmt->bindValue(':sesso', $_POST["Sesso"], SQLITE3_TEXT);
            $stmt->bindValue(':email', $_POST["Email"], SQLITE3_TEXT);
            $stmt->bindValue(':password', $newPwd, SQLITE3_TEXT);
            $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
            $stmt->execute();
        }

        else header("Location: ../dashboard.php");

        header("Location: ../showdata.php?admin=$mode");
    }
    else header("Location: ../dashboard.php");