<?php
include_once "database/connection.php";
session_start();

if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true || $_SESSION['isAdmin'] !== true) {
    header("Location: ../login.php");
    exit;
}

function sanitize($input) {
    return htmlspecialchars(trim($input));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codFiscale = strtoupper(sanitize($_POST['Cod_fiscale'] ?? ''));
    $ospedaleNome = sanitize($_POST['Ospedale'] ?? '');
    $ospedaleIndirizzo = sanitize($_POST['Indirizzo'] ?? '');
    $dataDiagnosi = sanitize($_POST['Data'] ?? '');
    $quesiti = $_POST['Quesiti'] ?? [];

    if (!$codFiscale || !$ospedaleNome || !$ospedaleIndirizzo || !$dataDiagnosi || count($quesiti) === 0) {
        die("Errore: dati mancanti.");
    }

    // Rimuovo quesiti vuoti
    $quesiti = array_filter($quesiti, fn($q) => trim($q) !== '');

    // Inizio transazione
    $conn->exec('BEGIN TRANSACTION');

    try {
        // 1. Trovo paziente da Cod_fiscale
        $stmt = $conn->prepare('SELECT ID FROM Pazienti WHERE Cod_fiscale = :cod');
        $stmt->bindValue(':cod', $codFiscale, SQLITE3_TEXT);
        $result = $stmt->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);
        if (!$row) {
            throw new Exception("Paziente non trovato con codice fiscale $codFiscale");
        }
        $idPaziente = $row['ID'];

        // 2. Controllo se ospedale esiste (Nome + Indirizzo)
        $stmt = $conn->prepare('SELECT ID FROM Ospedali WHERE Nome = :nome AND Indirizzo = :indirizzo');
        $stmt->bindValue(':nome', $ospedaleNome, SQLITE3_TEXT);
        $stmt->bindValue(':indirizzo', $ospedaleIndirizzo, SQLITE3_TEXT);
        $result = $stmt->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);

        if ($row) {
            $idOspedale = $row['ID'];
        } else {
            // Inserisco nuovo ospedale
            $stmt = $conn->prepare('INSERT INTO Ospedali (Nome, Indirizzo) VALUES (:nome, :indirizzo)');
            $stmt->bindValue(':nome', $ospedaleNome, SQLITE3_TEXT);
            $stmt->bindValue(':indirizzo', $ospedaleIndirizzo, SQLITE3_TEXT);
            $stmt->execute();
            $idOspedale = $conn->lastInsertRowID();
        }

        // 3. Inserisco Diagnosi
        $stmt = $conn->prepare('INSERT INTO Diagnosi (Data_Diagnosi, ID_Paziente, ID_Ospedale) VALUES (:data, :idPaziente, :idOspedale)');
        $stmt->bindValue(':data', $dataDiagnosi, SQLITE3_TEXT);
        $stmt->bindValue(':idPaziente', $idPaziente, SQLITE3_INTEGER);
        $stmt->bindValue(':idOspedale', $idOspedale, SQLITE3_INTEGER);
        $stmt->execute();
        $idDiagnosi = $conn->lastInsertRowID();

        // 4. Inserisco i quesiti
        $stmtSelectQuesito = $conn->prepare('SELECT ID FROM Quesiti_Diagnostici WHERE Descrizione = :descrizione');
        $stmtInsertQuesito = $conn->prepare('INSERT INTO Quesiti_Diagnostici (Descrizione) VALUES (:descrizione)');
        $stmtInsertRelazione = $conn->prepare('INSERT INTO Diagnosi_Quesiti (ID_Diagnosi, ID_Quesito) VALUES (:idDiagnosi, :idQuesito)');

        foreach ($quesiti as $q) {
            $descrizione = trim($q);
            if ($descrizione === '') continue;

            $stmtSelectQuesito->bindValue(':descrizione', $descrizione, SQLITE3_TEXT);
            $result = $stmtSelectQuesito->execute();
            $row = $result->fetchArray(SQLITE3_ASSOC);

            if ($row) {
                $idQuesito = $row['ID'];
            } else {
                $stmtInsertQuesito->bindValue(':descrizione', $descrizione, SQLITE3_TEXT);
                $stmtInsertQuesito->execute();
                $idQuesito = $conn->lastInsertRowID();
            }

            $stmtInsertRelazione->bindValue(':idDiagnosi', $idDiagnosi, SQLITE3_INTEGER);
            $stmtInsertRelazione->bindValue(':idQuesito', $idQuesito, SQLITE3_INTEGER);
            $stmtInsertRelazione->execute();
        }

        // Commit
        $conn->exec('COMMIT');

        header("Location: ../newdiagnosis.php?success=1");
        exit;

    } catch (Exception $e) {
        $conn->exec('ROLLBACK');
        die("Errore durante l'inserimento: " . $e->getMessage());
    }

} else {
    header("Location: ../newdiagnosis.php");
    exit;
}
