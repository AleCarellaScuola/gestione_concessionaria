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
                    Concessionaria_Utenti.id_utente, Concessionaria_Utenti.nome, Concessionaria_Utenti.cognome, Concessionaria_Utenti.data_iscrizione, Concessionaria_Utenti.data_nascita, Concessionaria_Utenti.email, Concessionaria_Utenti.indirizzo,
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
        $risp["utenti"][] = array(
            "id_utente" => null,
            "nome" => "Nessun nome dell'utente trovato",
            "cognome" => "Nessun cognome dell'utente trovato",
            "data_iscrizione" => "Nessuna data di iscrizione trovata",
            "data_nascita" => "Nessuna data di nascita trovata",
            "email" => "Nessuna email trovata",
            "indirizzo" => "Nessun indirizzo trovato",
            "nome_provincia" => "Nessuna provincia trovata",
            "acronimo" => "Nessun acronimo della provincia trovato"
        );
        echo json_encode($risp);

    }

    $conn   = null;
    $result = null;
    $stmt   = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }