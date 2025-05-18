<?php
    include_once 'headers.php';
    include_once '../backend/database/connection.php';
    header("Access-Control-Allow-Methods: GET");

    $query = "SELECT ID, Cod_fiscale, Nome, Cognome, Data_Nascita, Sesso, Email FROM Pazienti";
    $result = $conn->query($query);

    if ($result && $result->numColumns() > 0) {
        http_response_code(200);
        
        $arr_paziente = ["records" => []];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $arr_paziente["records"][] = $row;
        }

        echo json_encode($arr_paziente);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Nessun paziente trovato."]);
    }

    $result->finalize(); 
    $conn->close();
?>