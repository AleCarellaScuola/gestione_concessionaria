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
                    Concessionaria_categorie.id_categoria, Concessionaria_categorie.descrizione
                FROM
                    Concessionaria_categorie";
    $stmt = $conn->query($query, PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        foreach ($result as $row) {
        $risp["categorie"][] = $row;
        }
        echo (json_encode($risp));
    } else {
        $risp["categorie"][] =array(
            "id_categoria" => null,
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