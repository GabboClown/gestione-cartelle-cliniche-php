<?php
    if(isset($_POST)){
        $mode = htmlspecialchars($_GET["admin"]);
        $id = htmlspecialchars($_GET["id"]);
        $DB = new mysqli("localhost", "gabbo", "");

        if($mode == "true"){
            $template = $DB->prepare("UPDATE anagrafe.autorizzati SET username = ?, password = ? WHERE id = ?");
            $template->bind_param("ssi", $_POST["username"], hash('sha256', $_POST["password"]), $id);
            $template->execute();
        }

        else if($mode == 'false'){
            $template = $DB->prepare("UPDATE anagrafe.cittadini SET nome = ?, cognome = ?, codice_fiscale = ?, data_di_nascita = ?, luogo_di_nascita = ?, indirizzo = ?, num_telefono = ? WHERE id = ?");
            $template->bind_param("sssssssi", $_POST["nome"], $_POST["cognome"], $_POST["cod_fisc"], $_POST["d_o_b"], $_POST["p_o_b"], $_POST["indirizzo"], $_POST["num_tel"], $id);
            $template->execute();
        }

        else header("Location: ../dashboard.php");

        header("Location: ../insertnew.php?admin=$mode");
    }
    else header("Location: ../dashboard.php");