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
                INSERT INTO alimentazioni
                (nome)
                VALUES
                (:tipo_alimentazione)";
    $stmt = $conn->prepare($query);
    $alimentazione = $_GET["alimentazione"];
    $stmt->bindParam(":tipo_alimentazione", $alimentazione, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->execute() === TRUE) {
        echo "Alimentazione inserita con successo";
    } else {
        echo "Errore!";

    }
    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }
    