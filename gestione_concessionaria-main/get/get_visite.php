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
                    Concessionaria_visite.data_visita,
                    Concessionaria_utenti.nome, Concessionaria_utenti.cognome,
                    Concessionaria_veicoli.prezzo,
                    Concessionaria_modelli.nome AS nome_modello
                FROM
                    Concessionaria_visite
                JOIN
                    Concessionaria_utenti
                        ON Concessionaria_visite.id_utente = Concessionaria_utenti.id_utente
                JOIN
                    Concessionaria_veicoli
                        ON Concessionaria_visite.id_veicolo = Concessionaria_veicoli.id_veicolo
                JOIN
                    Concessionaria_modelli
                        ON Concessionaria_modelli.id_modello = Concessionaria_veicoli.id_modello";
    $stmt = $conn->query($query, PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        foreach ($result as $row) {
        $risp["visite"][] = $row;
        }
        echo (json_encode($risp));
    } else {
        $risp["visite"][] = array(
            "data_visita" => "Nessuna data della visita trovata",
            "nome" => "Nessun nome dell'utente trovato",
            "cognome" => "Nessun cognome dell'utente trovato",
            "prezzo" => "Nessuna prezzo trovato",
            "nome_modello" => "Nessun modello trovato"
        );
        echo json_encode($risp);

    }

    $conn = null;
    $result = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }