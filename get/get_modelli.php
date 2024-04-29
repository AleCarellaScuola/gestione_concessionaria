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
                    modelli.nome, 
                    case_automobilistiche.nome,
                    cilindrate.valore,
                    alimentazioni.nome,
                    categorie.descrizione
                FROM
                    modelli
                JOIN
                    case_automobilistiche
                        ON modelli.id_casa = case_automobilistiche.id_casa
                JOIN
                    cilindrate
                        ON modelli.id_cilindrata = cilindrate.id_cilindrata
                JOIN 
                    alimentazioni
                        ON modelli.id_alimentazione = alimentazioni.id_alimentazione
                JOIN
                    categorie
                        ON modelli.id_categoria = categorie.id_categoria";
    $stmt = $conn->query($query, PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        foreach ($result as $row) {
        $risp["alimentazioni"][] = $row;
        }
        echo (json_encode($risp));
    } else {
        $risp["alimentazioni"][] = $conn->errorInfo();
        echo json_encode($risp);

    }

    $conn = null;
    $result = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }