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
                    Concessionaria_alimentazioni.id_alimentazione, Concessionaria_alimentazioni.nome
              FROM
                    Concessionaria_alimentazioni";
    $stmt = $conn->query($query, PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        foreach ($result as $row) {
        $risp["alimentazioni"][] = $row;
        }
        echo (json_encode($risp));
    } else {
        $risp["alimentazioni"][] = array(
            "id_alimentazione" => null,
            "nome" => "Nessuna alimentazione trovata"
          );
        echo json_encode($risp);

    }

    $conn = null;
    $result = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }
