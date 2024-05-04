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
                INSERT INTO Concessionaria_province
                (nome, acronimo)
                VALUES
                (:nome_provincia, :acronimo_provincia)";
    $stmt = $conn->prepare($query);
    $nome_provincia     = $_GET["nome_provincia"];
    $acronimo_provincia = $_GET["acronimo_provincia"];
    $stmt->bindParam(":nome_provincia", $nome_provincia, PDO::PARAM_STR);
    $stmt->bindParam(":acronimo_provincia", $acronimo_provincia, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->execute() === TRUE) {
        echo "Provincia inserita con successo";
    } else {
        echo "Errore!";

    }
    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }