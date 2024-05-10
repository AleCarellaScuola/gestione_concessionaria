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
    $query = "
                INSERT INTO Concessionaria_veicoli
                (prezzo, riferimento, id_modello)
                VALUES
                (:prezzo, :riferimento_foto, :modello)";
    $stmt = $conn->prepare($query);
    $prezzo     = $_GET["prezzo_veicolo"];
    $rif_foto   = $_GET["rif_foto"];
    $id_modello = $_GET["id_modello"];
    $stmt->bindParam(":prezzo", $prezzo, PDO::PARAM_INT);
    $stmt->bindParam(":riferimento_foto", $rif_foto, PDO::PARAM_STR);
    $stmt->bindParam(":modello", $id_modello, PDO::PARAM_INT);
    if ($stmt->execute() === TRUE) {
        echo "Veicolo inserito con successo";
    } else {
        echo "Errore!";

    }
    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }