<?php
    include_once "database/connection.php";
    session_start();

    function login($conn, $email, $pwd) {
        $pwd = hash("sha256", $pwd);
        $stmt = $conn->prepare("SELECT ID FROM Pazienti WHERE Email = :email AND Password = :password");
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);
        $stmt->bindValue(':password', $pwd, SQLITE3_TEXT);
        $result = $stmt->execute();

        if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            return $row["ID"];
        } else {
            return -1;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST["email"] ?? '';
        $pwd = $_POST["password"] ?? '';
        $ID = login($conn, $email, $pwd);
        
        if($ID != -1) {
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['isAdmin'] = false;
            $_SESSION['ID'] = $ID;
            header("Location: ../cartella.php?id=$ID");
        } else {
            header("Location: ../login.php?error=1");
        }
        $conn->close();
    }

