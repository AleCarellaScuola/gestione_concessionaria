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
                Concessionaria_Alimentazioni
              WHERE 
                Concessionaria_Alimentazioni.id_alimentazione = :id_alimentazione";

    $stmt = $conn->prepare($query);
    $id_alimentazione = $_GET["id_alimentazione"];
    $stmt->bindParam(":id_alimentazione", $id_alimentazione, PDO::PARAM_INT);
    $stmt->execute();


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
