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
    $query = "SELECT 
                    Concessionaria_modelli.nome AS Nome_modello, 
                    COUNT(concessionaria_visite.id_veicolo) AS N_visite, 
                    concessionaria_province.nome AS Provincia, concessionaria_province.acronimo, 
                    concessionaria_categorie.descrizione, 
                    concessionaria_case_automobilistiche.nome AS Casa_produttrice
                FROM 
                    concessionaria_visite 
                JOIN 
                    concessionaria_veicoli 
                        ON concessionaria_veicoli.id_veicolo = concessionaria_visite.id_veicolo
                JOIN 
                    concessionaria_modelli 
                        ON concessionaria_modelli.id_modello = concessionaria_veicoli.id_modello
                JOIN 
                    concessionaria_categorie  
                        ON concessionaria_categorie.id_categoria = concessionaria_modelli.id_categoria
                JOIN
                    concessionaria_case_automobilistiche
                        ON concessionaria_case_automobilistiche.id_casa = concessionaria_modelli.id_casa
                JOIN
                    concessionaria_utenti
                        ON concessionaria_visite.id_utente = concessionaria_utenti.id_utente
                JOIN
                    concessionaria_province
                        ON concessionaria_province.id_provincia = concessionaria_utenti.id_provincia
                WHERE 
                    concessionaria_province.acronimo IN (\"MI\", \"RM\") 
                    AND concessionaria_categorie.descrizione = \"Moto\"
            GROUP BY concessionaria_modelli.nome
            HAVING COUNT(concessionaria_visite.id_veicolo) > 500
            ORDER BY concessionaria_case_automobilistiche.nome, concessionaria_modelli.nome;"; 
    $stmt = $conn->query($query, PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        foreach ($result as $row) {
        $risp["quarta_query"][] = $row;
        }
        echo (json_encode($risp));
    } else {
        $risp["quarta_query"][] = array(
            "N_visite" => "0",
            "Nome_modello" => "Nessun modello trovato",
            "Provincia" => "Nessuna provincia trovata",
            "acronimo" => "Nessun acronimo trovato",
            "descrizione" => "Nessuna categoria trovata",
            "Casa_produttrice" => "Nessuna casa automobilistica trovata",
        );
        echo json_encode($risp);

    }

    $conn = null;
    $result = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }