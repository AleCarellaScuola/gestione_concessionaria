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
                Concessionaria_Categorie
              WHERE 
                Concessionaria_Categorie.id_categoria = :id_categoria";

    $stmt = $conn->prepare($query);
    $id_categoria = $_GET["id_categoria"];
    $stmt->bindParam(":id_categoria", $id_categoria, PDO::PARAM_INT);


    if ($stmt->execute() === TRUE) {
        echo "Categoria eliminata con successo";
    } else {
        echo "Errore!";

    }

    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }
