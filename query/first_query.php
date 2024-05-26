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
                    COUNT(Concessionaria_visite.id_veicolo) AS n_visite,
                    Concessionaria_modelli.nome,
                    Concessionaria_categorie.descrizione
                FROM
                    Concessionaria_visite 
                JOIN
                    Concessionaria_veicoli ON Concessionaria_visite.id_veicolo = Concessionaria_veicoli.id_veicolo
                JOIN
                    Concessionaria_modelli ON Concessionaria_modelli.id_modello = Concessionaria_veicoli.id_modello
                JOIN
                    Concessionaria_categorie ON Concessionaria_categorie.id_categoria = Concessionaria_modelli.id_categoria
                WHERE 
                    Concessionaria_categorie.descrizione = \"Moto\" 
                    AND MONTH(Concessionaria_visite.data_visita) BETWEEN 1 AND 3 
                    AND YEAR(Concessionaria_visite.data_visita) = YEAR(NOW()) 
                    AND Concessionaria_veicoli.id_modello = :id_modello
                ORDER BY Concessionaria_modelli.nome
                    "; 
    $stmt = $conn->prepare($query);
    $id_modello = $_GET["rif_modello"];
    $stmt->bindParam(":id_modello", $id_modello, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $find = true;
    if (count($result) > 0) {
        if($result[0]["nome"] === null && $result[0]["descrizione"] === null && $result[0]["n_visite"] === "0") 
        {
            $find = false;
            $risp["numero_visite"][] = array(
                "n_visite" => "0",
                "nome" => "Nessun modello trovato",
                "descrizione" => "Nessuna categoria trovata"
            );
        }
           
        if($find)
        {          
            foreach ($result as $row) {
                $risp["numero_visite"][] = $row;
            }
        }

        echo (json_encode($risp));
    } else {
        $risp["numero_visite"][] = array(
            "n_visite" => "0",
            "nome" => "Nessun modello trovato",
            "descrizione" => "Nessuna categoria trovata"
        );
        echo json_encode($risp);

    }

    $conn = null;
    $result = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }