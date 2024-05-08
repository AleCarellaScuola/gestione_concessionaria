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
                Concessionaria_Cilindrate
              WHERE 
                Concessionaria_Cilindrate.id_cilindrata = :id_cilindrata";

    $stmt = $conn->prepare($query);
    $id_cilindrata = $_GET["id_cilindrata"];
    $stmt->bindParam(":id_cilindrata", $id_cilindrata, PDO::PARAM_INT);
    $stmt->execute();


    if ($stmt->execute() === TRUE) {
        echo "Cilindrata eliminata con successo";
    } else {
        echo "Errore!";

    }

    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }
