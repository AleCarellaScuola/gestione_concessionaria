<?php
    $data     = json_decode(file_get_contents("../config.json"), true);
    $host     = $data['host'];
    $password = $data['password'];
    $dbname   = $data['dbname'];
    $username = $data['username'];
    try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // comando SQL  
    $query = "DELETE FROM
                Concessionaria_Utenti
              WHERE 
                Concessionaria_Utenti.id_utente = :id_utente";

    $stmt = $conn->prepare($query);
    $id_utente = $_GET["id_utente"];
    $stmt->bindParam(":id_utente", $id_utente, PDO::PARAM_INT);
    $stmt->execute();


    if ($stmt->execute() === TRUE) {
        echo "Utente eliminato con successo";
    } else {
        echo "Errore!";

    }

    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }
