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
                    Concessionaria_cilindrate.id_cilindrata, Concessionaria_cilindrate.valore
                FROM
                    Concessionaria_cilindrate
                ORDER BY Concessionaria_cilindrate.valore";
    $stmt = $conn->query($query, PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        foreach ($result as $row) {
        $risp["cilindrate"][] = $row;
        }
        echo (json_encode($risp));
    } else {
        $risp["cilindrate"][] = array(
            "id_cilindrata" => null,
            "valore" => "Nessuna cilindrata trovata"
          );
        echo json_encode($risp);

    }

    $conn = null;
    $result = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }