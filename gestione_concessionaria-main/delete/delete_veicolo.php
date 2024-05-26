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
                Concessionaria_Veicoli
              WHERE 
                Concessionaria_Veicoli.id_veicolo = :id_veicolo";

    $stmt = $conn->prepare($query);
    $id_veicolo = $_GET["id_veicolo"];
    $stmt->bindParam(":id_veicolo", $id_veicolo, PDO::PARAM_INT);


    if ($stmt->execute() === TRUE) {
        echo "Veicolo eliminato con successo";
    } else {
        echo "Errore!";

    }

    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }
