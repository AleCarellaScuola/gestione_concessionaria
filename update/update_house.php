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
                    UPDATE concessionaria_case_automobilistiche 
                    SET nome =:nome, 
                    p_iva = :p_iva 
                    WHERE concessionaria_case_automobilistiche.id_casa = :id_casa;
                ";

    $stmt = $conn->prepare($query);
    $nome_casa = $_GET["nome_casa"];
    $p_iva_casa = $_GET["p_iva_casa"];
    $id_casa = $_GET["id_casa"];
    $stmt->bindParam(":nome", $nome_casa, PDO::PARAM_STR);
    $stmt->bindParam(":p_iva", $p_iva_casa, PDO::PARAM_STR);
    $stmt->bindParam(":id_casa", $id_casa, PDO::PARAM_INT);


    if ($stmt->execute() === TRUE) {
        echo "Casa automobilistica modificata con successo";
    } else {
        echo "Errore!";

    }

    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }
