<?php

    function login($DB, $username, $pwd){
        $pwd = hash("sha256", $pwd);
        setcookie("username", $username, time() + 86400, "/");
        setcookie("userpassword", $pwd, time() + 86400, "/");
        $template = $DB->prepare("SELECT * FROM anagrafe.autorizzati WHERE anagrafe.autorizzati.username = ? AND anagrafe.autorizzati.password = ?");
        $template->bind_param("ss", $username, $pwd);
        $template->execute();

        return $template->get_result()->num_rows > 0;
    }


    if(isset($_POST)){
        $userDB = new mysqli("localhost", "gabbo", "");
        $username = $_POST["username"];
        $pwd = $_POST["password"];
        setcookie("login", login($userDB, $username, $pwd) === TRUE ? "SUCCESSFULL" : "NOT SUCCESSFULL", time() + 86400, "/");
        $userDB->close();
        header("Location: ../login.html");
    }
    else header("Location: ../login.html");
