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
                Concessionaria_case_automobilistiche
              WHERE 
                Concessionaria_case_automobilistiche.id_casa = :id_casa";

    $stmt = $conn->prepare($query);
    $id_casa = $_GET["id_casa"];
    $stmt->bindParam(":id_casa", $id_casa, PDO::PARAM_INT);
    $stmt->execute();


    if ($stmt->execute() === TRUE) {
        echo "Casa automobilistica eliminata con successo";
    } else {
        echo "Errore!";

    }

    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }
