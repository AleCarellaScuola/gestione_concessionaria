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
                    UPDATE concessionaria_cilindrate 
                    SET valore = :valore
                    WHERE concessionaria_cilindrate.id_cilindrata = :id_cilindrata;
                ";

    $stmt = $conn->prepare($query);
    $id_cilindrata = $_GET["id_cilindrata"];
    $valore_cilindrata = $_GET["valore_cilindrata"];
    $stmt->bindParam(":valore", $valore_cilindrata, PDO::PARAM_INT);
    $stmt->bindParam(":id_cilindrata", $id_cilindrata, PDO::PARAM_INT);


    if ($stmt->execute() === TRUE) {
        echo "Cilindrata modificata con successo";
    } else {
        echo "Errore!";
    }

    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }