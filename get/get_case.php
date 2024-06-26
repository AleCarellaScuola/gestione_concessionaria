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
                    Concessionaria_case_automobilistiche.id_casa, Concessionaria_case_automobilistiche.nome, Concessionaria_case_automobilistiche.p_iva
                FROM
                    Concessionaria_case_automobilistiche";
    $stmt = $conn->query($query, PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        foreach ($result as $row) {
        $risp["case"][] = $row;
        }
        echo (json_encode($risp));
    } else {
        $risp["case"][] =array(
            "id_casa" => null,
            "nome" => "Nessuna casa automobilistica trovata",
            "p_iva" => "Nessuna partita iva trovata associata alla casa automobilistica",
          );
        echo json_encode($risp);

    }

    $conn = null;
    $result = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }