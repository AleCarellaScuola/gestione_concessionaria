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
                    UPDATE concessionaria_utenti 
                    SET 
                        nome            = :nome, 
                        cognome         = :cognome,
                        data_iscrizione = :data_iscrizione,
                        data_nascita    = :data_nascita,
                        admin           = :admin,
                        email           = :email,
                        password        = :psw,
                        indirizzo       = :indirizzo,
                        id_provincia    = :id_provincia
                    WHERE concessionaria_utenti.id_utente = :id_utente;
                ";

    $stmt = $conn->prepare($query);
    $nome_utente     = $_GET["nome_utente"];
    $cognome_utente  = $_GET["cognome_utente"];
    $data_iscrizione = $_GET["data_iscrizione"];
    $data_nascita    = $_GET["data_nascita"];
    $admin           = $_GET["admin"];
    $email           = $_GET["email"];
    $psw             = $_GET["psw"];
    $indirizzo       = $_GET["indirizzo"];
    $id_provincia    = $_GET["id_provincia"];
    $id_utente       = $_GET["id_utente"];

    
    $encrypted_psw = password_hash($psw, PASSWORD_DEFAULT);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        echo("L'email non e' valida");
        return;
    } 
    else
    {
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    }
    $stmt->bindParam(":nome", $nome_utente, PDO::PARAM_STR);
    $stmt->bindParam(":cognome", $cognome_utente, PDO::PARAM_STR);
    $stmt->bindParam(":data_iscrizione", $data_iscrizione, PDO::PARAM_STR);
    $stmt->bindParam(":data_nascita", $data_nascita, PDO::PARAM_STR);
    $stmt->bindParam(":admin", $admin, PDO::PARAM_INT);
    $stmt->bindParam(":psw", $encrypted_psw, PDO::PARAM_STR);
    $stmt->bindParam(":indirizzo", $indirizzo, PDO::PARAM_STR);
    $stmt->bindParam(":id_provincia", $id_provincia, PDO::PARAM_INT);
    $stmt->bindParam(":id_utente", $id_utente, PDO::PARAM_INT);


    if ($stmt->execute() === TRUE) {
        echo "Utente modificato con successo";
    } else {
        echo "Errore!";

    }

    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }