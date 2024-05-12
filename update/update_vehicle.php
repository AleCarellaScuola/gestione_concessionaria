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
                    UPDATE concessionaria_veicoli 
                    SET 
                        prezzo      = :prezzo, 
                        riferimento = :riferimento,
                        id_modello  = :id_modello
                    WHERE concessionaria_veicoli.id_veicolo = :id_veicolo;
                ";

    $stmt = $conn->prepare($query);
    $prezzo     = $_GET["prezzo"];
    $url_photo  = $_GET["link_foto"];
    $id_modello = $_GET["id_modello"];
    $id_veicolo = $_GET["id_veicolo"];
    
    $stmt->bindParam(":prezzo", $prezzo, PDO::PARAM_INT);
    $stmt->bindParam(":riferimento", $url_photo, PDO::PARAM_STR);
    $stmt->bindParam(":id_modello", $id_modello, PDO::PARAM_INT);
    $stmt->bindParam(":id_veicolo", $id_veicolo, PDO::PARAM_INT);


    if ($stmt->execute() === TRUE) {
        echo "Veicolo modificato con successo";
    } else {
        echo "Errore!";

    }

    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }