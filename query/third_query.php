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
                    concessionaria_case_automobilistiche.nome AS nome_casa,
                    concessionaria_modelli.nome AS nome_modello,
                    concessionaria_categorie.descrizione
                FROM
                    concessionaria_veicoli
                JOIN 
                    concessionaria_modelli ON concessionaria_modelli.id_modello = concessionaria_veicoli.id_modello
                JOIN
                    concessionaria_case_automobilistiche ON concessionaria_case_automobilistiche.id_casa = concessionaria_modelli.id_casa
                JOIN
                    concessionaria_categorie ON concessionaria_categorie.id_categoria = concessionaria_modelli.id_categoria
                WHERE 
                    concessionaria_categorie.descrizione =  \"Automobile\" AND
                    concessionaria_veicoli.id_veicolo NOT IN (SELECT 
                                                                concessionaria_veicoli.id_veicolo
                                                              FROM 
                                                                concessionaria_visite
                                                              JOIN
                                                                concessionaria_veicoli ON concessionaria_visite.id_veicolo = concessionaria_veicoli.id_veicolo
                                                              WHERE 
                                                                YEAR(concessionaria_visite.data_visita) = YEAR(NOW()))"; 
    $stmt = $conn->query($query, PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        foreach ($result as $row) {
        $risp["terza_query"][] = $row;
        }
        echo (json_encode($risp));
    } else {
        $risp["terza_query"][] = $conn->errorInfo();
        echo json_encode($risp);

    }

    $conn = null;
    $result = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }