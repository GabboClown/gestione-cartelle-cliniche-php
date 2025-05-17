<?php
    include_once 'headers.php';
    include_once '../backend/database/connection.php';
    header("Access-Control-Allow-Methods: POST");

    // Decodifica del dato JSON ricevuto
    $data = json_decode(file_get_contents("php://input"));

    // Controllo che i dati necessari siano presenti
    if (!empty($data->Cod_fiscale) && !empty($data->Nome) && !empty($data->Cognome) && !empty($data->Data_Nascita) && !empty($data->Sesso)) {
        
        // Preparazione della query parametrica
        $query = "INSERT INTO Pazienti (Cod_fiscale, Nome, Cognome, Data_Nascita, Sesso) 
                  VALUES (:Cod_fiscale, :Nome, :Cognome, :Data_Nascita, :Sesso)";
        
        $stmt = $conn->prepare($query);
        
        // Associazione dei parametri
        $stmt->bindValue(':Cod_fiscale', $data->Cod_fiscale, SQLITE3_TEXT);
        $stmt->bindValue(':Nome', $data->Nome, SQLITE3_TEXT);
        $stmt->bindValue(':Cognome', $data->Cognome, SQLITE3_TEXT);
        $stmt->bindValue(':Data_Nascita', $data->Data_Nascita, SQLITE3_TEXT);
        $stmt->bindValue(':Sesso', $data->Sesso, SQLITE3_TEXT);
        
        // Esecuzione della query
        $result = $stmt->execute();
        
        if ($result) {
            http_response_code(201); // codice http restituito: creazione completata
            echo json_encode(["message" => "Paziente creato con successo."]);
        } else {
            http_response_code(500); // Errore interno del server
            echo json_encode(["message" => "Errore durante la creazione del Paziente: ". $conn->lastErrorMsg()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Non hai fornito tutti i dati."]);
    }

    // Chiusura della connessione
    $conn->close();
?>
