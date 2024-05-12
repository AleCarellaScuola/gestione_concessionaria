<?php
//TODO capire come eliminare sia il veicolo che il modello associato
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
                Concessionaria_Alimentazioni
              WHERE 
                Concessionaria_Alimentazioni.id_alimentazione = :id_alimentazione";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id_alimentazione", $id_alimentazione, PDO::PARAM_INT);


    if ($stmt->execute() === TRUE) {
        echo "Alimentazione eliminata con successo";
    } else {
        echo "Errore!";

    }

    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }
