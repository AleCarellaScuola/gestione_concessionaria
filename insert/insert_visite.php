<?php
    $data     = json_decode(file_get_contents("config.json"), true);
    $host     = $data['host'];
    $password = $data['password'];
    $dbname   = $data['dbname'];
    $username = $data['username'];
    try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // comando SQL  
    $query = "
                INSERT INTO visite
                (id_veicolo, id_utente, data_visita)
                VALUES
                (:id_veicolo, :id_utente, :data_visita)";
    $stmt = $conn->prepare($query);
    $id_veicolo  = $_GET["rif_veicolo"];
    $id_utente   = $_GET["rif_utente"];
    $data_visita = $_GET["data_visita"];
    $stmt->bindParam(":id_veicolo", $id_veicolo, PDO::PARAM_INT);
    $stmt->bindParam(":id_utente", $id_utente, PDO::PARAM_INT);
    $stmt->bindParam(":data_visita", $data_visita, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->execute() === TRUE) {
        echo "Visita inserito con successo";
    } else {
        echo "Errore!";

    }
    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }