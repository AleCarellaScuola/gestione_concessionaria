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
                INSERT INTO modelli
                (nome, id_casa, id_cilindrata, id_alimentazione, id_categoria)
                VALUES
                (:nome, :rif_casa, :rif_cilindrata, :rif_alimentazione, :rif_categoria)";
    $stmt = $conn->prepare($query);
    $tipo_modello     = $_GET["rif_modello"];
    $id_casa          = $_GET["rif_casa"];
    $id_cilindrata    = $_GET["rif_cilindrata"];
    $id_alimentazione = $_GET["rif_alimentazione"];
    $id_categoria     = $_GET["rif_categoria"];
    $stmt->bindParam(":nome", $tipo_modello, PDO::PARAM_STR);
    $stmt->bindParam(":rif_casa", $id_casa, PDO::PARAM_INT);
    $stmt->bindParam(":rif_cilindrata", $id_cilindrata, PDO::PARAM_INT);
    $stmt->bindParam(":rif_alimentazione", $id_alimentazione, PDO::PARAM_INT);
    $stmt->bindParam(":rif_categoria", $id_categoria, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->execute() === TRUE) {
        echo "Modello inserito con successo";
    } else {
        echo "Errore!";

    }
    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }