<?php
    include_once 'headers.php';
    include_once '../backend/database/connection.php';
    header("Access-Control-Allow-Methods: DELETE");

    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->ID)) {
        http_response_code(400);
        echo json_encode(["message" => "ID mancante."]);
        exit;
    }

    // Query parametrica per evitare SQL injection
    $query = "DELETE FROM Pazienti WHERE ID = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id', $data->ID, SQLITE3_INTEGER);

    $result = $stmt->execute();

    // Verifica se è stata eliminata almeno una riga
    if ($conn->changes() > 0) {
        http_response_code(200);
        echo json_encode(["message" => "Paziente eliminato con successo."]);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Nessun paziente trovato con l'ID fornito."]);
    }

    $conn->close();
?>