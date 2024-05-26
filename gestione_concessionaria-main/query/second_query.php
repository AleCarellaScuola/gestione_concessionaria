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
                SELECT DISTINCT
                    concessionaria_province.nome AS nome_provincia,
                    FLOOR(DATEDIFF(NOW(), concessionaria_utenti.data_nascita) / 365) AS Eta,
                    Concessionaria_categorie.descrizione,
                    Concessionaria_modelli.nome
                FROM
                    concessionaria_visite
                JOIN
                    concessionaria_utenti ON concessionaria_utenti.id_utente = concessionaria_visite.id_utente
                JOIN
                    concessionaria_province ON concessionaria_utenti.id_provincia = concessionaria_province.id_provincia                
                JOIN
                    concessionaria_veicoli ON concessionaria_veicoli.id_veicolo = concessionaria_visite.id_veicolo
                JOIN
                    concessionaria_modelli ON concessionaria_modelli.id_modello = concessionaria_veicoli.id_modello
                JOIN
                    concessionaria_categorie ON concessionaria_categorie.id_categoria = concessionaria_modelli.id_categoria
                WHERE 
                    concessionaria_categorie.descrizione = \"Automobile\" AND
                    concessionaria_veicoli.id_modello = :id_modello
                                        "; 
    $stmt = $conn->prepare($query);
    $id_modello = $_GET["rif_modello"];
    $stmt->bindParam(":id_modello", $id_modello, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        foreach ($result as $row) {
        $risp["seconda_query"][] = $row;
        }
        echo (json_encode($risp));
    } else {
        $risp["seconda_query"][] = array(
            "nome_provincia" => "Nessuna provincia trovata",
            "Eta" => "Nessuna eta trovata",
            "descrizione" => "Nessuna categoria trovata",
            "nome" => "Nessun modello trovato"
        );
        echo json_encode($risp);

    }

    $conn = null;
    $result = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }