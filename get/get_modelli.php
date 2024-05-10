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
                SELECT
                    Concessionaria_modelli.nome, 
                    Concessionaria_case_automobilistiche.nome,
                    Concessionaria_cilindrate.valore,
                    Concessionaria_alimentazioni.nome,
                    Concessionaria_categorie.descrizione
                FROM
                    Concessionaria_modelli
                JOIN
                    Concessionaria_case_automobilistiche
                        ON Concessionaria_modelli.id_casa = Concessionaria_case_automobilistiche.id_casa
                JOIN
                    Concessionaria_cilindrate
                        ON Concessionaria_modelli.id_cilindrata = Concessionaria_cilindrate.id_cilindrata
                JOIN 
                    Concessionaria_alimentazioni
                        ON Concessionaria_modelli.id_alimentazione = Concessionaria_alimentazioni.id_alimentazione
                JOIN
                    Concessionaria_categorie
                        ON Concessionaria_modelli.id_categoria = Concessionaria_categorie.id_categoria";
    $stmt = $conn->query($query, PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        foreach ($result as $row) {
        $risp["modelli"][] = $row;
        }
        echo (json_encode($risp));
    } else {
        $risp["modelli"][] = $conn->errorInfo();
        echo json_encode($risp);

    }

    $conn = null;
    $result = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }