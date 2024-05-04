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
                    Concessionaria_Utenti.nome, Concessionaria_Utenti.cognome, Concessionaria_Utenti.data_iscrizione, Concessionaria_Utenti.data_nascita, Concessionaria_Utenti.email, Concessionaria_Utenti.indirizzo,
                    Concessionaria_Province.nome AS nome_provincia, Concessionaria_Province.acronimo
                FROM
                    Concessionaria_Utenti
                JOIN 
                    Concessionaria_Province
                        ON Concessionaria_Utenti.id_provincia = Concessionaria_Province.id_provincia";
    $stmt = $conn->query($query, PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    
    if (count($result) > 0) {
        foreach ($result as $row) {
            $risp["utenti"][] = $row;
        }
        echo (json_encode($risp));
    } else {
        $risp["utenti"][] = $conn->errorInfo();
        echo json_encode($risp);

    }

    

    $conn   = null;
    $result = null;
    $stmt   = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }