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
                concessionaria_utenti.id_utente, concessionaria_utenti.cognome, concessionaria_utenti.nome, concessionaria_utenti.email, 
                concessionaria_veicoli.id_veicolo, 
                COUNT(concessionaria_visite.id_veicolo) AS N_visite
            FROM 
                concessionaria_visite 
            JOIN 
                concessionaria_veicoli
                    ON 
                        concessionaria_veicoli.id_veicolo = concessionaria_visite.id_veicolo
            JOIN 
                concessionaria_utenti  
                    ON 
                        concessionaria_utenti.id_utente = concessionaria_visite.id_utente
            WHERE concessionaria_veicoli.id_veicolo = :id_veicolo AND MONTH(concessionaria_visite.data_visita) = MONTH(NOW())
            GROUP BY concessionaria_utenti.id_utente
            HAVING COUNT(concessionaria_visite.id_visita) > 1
            ORDER BY COUNT(concessionaria_visite.id_veicolo) DESC
            LIMIT 5"; 
    $stmt = $conn->prepare($query);
    $id_veicolo = $_GET["rif_veicolo"];
    $stmt->bindParam(":id_veicolo", $id_veicolo, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        foreach ($result as $row) {
        $risp["quinta_query"][] = $row;
        }
        echo (json_encode($risp));
    } else {
        $risp["quinta_query"][] = array(
            "id_utente" => null,
            "nome" => "Nessun nome dell'utente trovato",
            "cognome" => "Nessuna cognome dell'utente trovato",
            "email" => "Nessuna email dell'utente trovata",
            "id_veicolo" => null,
            "N_visite" => "0",
        );
        echo json_encode($risp);

    }

    $conn = null;
    $result = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }