<?php
    $DB = new mysqli("localhost", "gabbo", "");
    $id = htmlspecialchars($_GET["id"]);
    $pwd = htmlspecialchars($_GET["pwd"]);
    $admin = htmlspecialchars($_GET["admin"]);

    if($admin == "true") $table = "autorizzati";
    else if($admin == "false") $table = "cittadini";
    else header("Location ../showdata.php?admin=$admin");

    $template = $DB->prepare("SELECT * FROM anagrafe.autorizzati WHERE `password` = ?");
    $template->bind_param("s", $pwd);
    $template->execute();

    if($template->get_result()->num_rows > 0)
        $template = $DB->prepare("DELETE FROM anagrafe.$table WHERE `id` = ?");
        $template->bind_param("i", $id);
        $template->execute();
    
    header("Location: ../showdata.php?admin=$admin");