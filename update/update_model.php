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
                    UPDATE concessionaria_modelli 
                    SET 
                        nome             = :nome, 
                        id_casa          = :id_casa,
                        id_alimentazione = :id_alimentazione,
                        id_categoria     = :id_categoria,
                        id_cilindrata    = :id_cilindrata
                    WHERE concessionaria_modelli.id_modello = :id_modello;
                ";

    $stmt = $conn->prepare($query);
    $nome             = $_GET["rif_modello"];
    $id_casa          = $_GET["rif_casa"];
    $id_alimentazione = $_GET["rif_alimentazione"];
    $id_categoria     = $_GET["rif_categoria"];
    $id_cilindrata    = $_GET["rif_cilindrata"];
    $id_modello       = $_GET["id_modello"];
    $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
    $stmt->bindParam(":id_casa", $id_casa, PDO::PARAM_INT);
    $stmt->bindParam(":id_alimentazione", $id_alimentazione, PDO::PARAM_INT);
    $stmt->bindParam(":id_categoria", $id_categoria, PDO::PARAM_INT);
    $stmt->bindParam(":id_cilindrata", $id_cilindrata, PDO::PARAM_INT);
    $stmt->bindParam(":id_modello", $id_modello, PDO::PARAM_INT);


    if ($stmt->execute() === TRUE) {
        echo "Modello modificato con successo";
    } else {
        echo "Errore!";

    }

    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }