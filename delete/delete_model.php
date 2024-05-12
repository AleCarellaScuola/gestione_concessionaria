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
                Concessionaria_Modelli
              WHERE 
                Concessionaria_Modelli.id_modello = :id_modello";

    $stmt = $conn->prepare($query);
    $id_modello = $_GET["id_modello"];
    $stmt->bindParam(":id_modello", $id_modello, PDO::PARAM_INT);


    if ($stmt->execute() === TRUE) {
        echo "Modello eliminato con successo";
    } else {
        echo "Errore!";

    }

    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }
