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
                INSERT INTO Concessionaria_case_automobilistiche
                (nome, p_iva)
                VALUES
                (:nome, :p_iva)";
    $stmt = $conn->prepare($query);
    $nome_casa = $_GET["nome_casa"];
    $p_iva     = $_GET["p_iva"];
    $stmt->bindParam(":nome", $nome_casa, PDO::PARAM_STR);
    $stmt->bindParam(":p_iva", $p_iva, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->execute() === TRUE) {
        echo "Casa automobilistica inserita con successo";
    } else {
        echo "Errore!";

    }
    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }
    