<?php
    if(isset($_POST)){
        $mode = htmlspecialchars($_GET["admin"]);
        $DB = new mysqli("localhost", "gabbo", "");

        if($mode == "true"){
            $template = $DB->prepare("INSERT INTO anagrafe.autorizzati VALUES(NULL, ?, ?)");
            $template->bind_param("ss", $_POST["username"], hash('sha256', $_POST["password"]));
            $template->execute();
        }

        else if($mode == 'false'){
            $template = $DB->prepare("INSERT INTO anagrafe.cittadini VALUES(NULL, ?, ?, ?, ?, ?, ?, ?)");
            $template->bind_param("sssssss", $_POST["nome"], $_POST["cognome"], $_POST["cod_fisc"], $_POST["d_o_b"], $_POST["p_o_b"], $_POST["indirizzo"], $_POST["num_tel"]);
            $template->execute();
        }

        else header("Location: ../dashboard.php");

        header("Location: ../insertnew.php?admin=$mode");
    }
    else header("Location: ../dashboard.php");