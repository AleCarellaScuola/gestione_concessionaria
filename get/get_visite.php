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
                SELECT
                    visite.data_visita,
                    utenti.nome, utenti.cognome,
                    veicoli.prezzo,
                    modelli.nome
                FROM
                    visite
                JOIN
                    utenti
                        ON visite.id_utente = utenti.id_utente
                JOIN
                    veicoli
                        ON visite.id_veicolo = veicolo.id_veicolo
                JOIN
                    modelli
                        ON modelli.id_modello = veicoli.id_modello";
    $stmt = $conn->query($query, PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        foreach ($result as $row) {
        $risp["visite"][] = $row;
        }
        echo (json_encode($risp));
    } else {
        $risp["visite"][] = $conn->errorInfo();
        echo json_encode($risp);

    }

    $conn = null;
    $result = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }