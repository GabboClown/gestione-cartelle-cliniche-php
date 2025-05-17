<?php
    // Connessione al database SQLite
    $conn = new SQLite3(__DIR__."/database.sqlite");

    // Verifica la connessione
    if (!$conn) {
        die("Connessione fallita: " . $conn->lastErrorMsg());
    }

