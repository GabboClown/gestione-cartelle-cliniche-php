<?php
    include_once 'headers.php'; 
    include_once '../backend/database/connection.php';
    header("Access-Control-Allow-Methods: PUT");

    $data = json_decode(file_get_contents("php://input"));

    if (
        !empty($data->ID) &&
        !empty($data->Cod_fiscale) &&
        !empty($data->Nome) &&
        !empty($data->Cognome) &&
        !empty($data->Data_Nascita) &&
        !empty($data->Sesso)
    ) {
        $query = "UPDATE Pazienti 
                  SET Cod_fiscale = :cod_fiscale,
                      Nome = :nome,
                      Cognome = :cognome,
                      Data_Nascita = :data_nascita,
                      Sesso = :sesso
                  WHERE ID = :id";

        $stmt = $conn->prepare($query);

        $stmt->bindValue(':cod_fiscale', $data->Cod_fiscale, SQLITE3_TEXT);
        $stmt->bindValue(':nome', $data->Nome, SQLITE3_TEXT);
        $stmt->bindValue(':cognome', $data->Cognome, SQLITE3_TEXT);
        $stmt->bindValue(':data_nascita', $data->Data_Nascita, SQLITE3_TEXT);
        $stmt->bindValue(':sesso', $data->Sesso, SQLITE3_TEXT);
        $stmt->bindValue(':id', $data->ID, SQLITE3_INTEGER);

        $result = $stmt->execute();

        if ($conn->changes() > 0) {
            http_response_code(200);
            echo json_encode(["message" => "Paziente aggiornato con successo."]);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Nessun paziente trovato con l'ID fornito."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Dati incompleti."]);
    }

    $conn->close();
?>
