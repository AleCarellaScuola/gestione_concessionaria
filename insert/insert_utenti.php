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
                INSERT INTO Concessionaria_utenti
                (nome, cognome, data_nascita, email, password, indirizzo, id_provincia)
                VALUES
                (:nome_utente, :cognome_utente, :data_nascita, :email_utente, :psw_utente, :indirizzo_utente, :provincia_utente)";
    $stmt = $conn->prepare($query);
    $nome_utente       = $_GET["nome_utente"];
    $cognome_utente    = $_GET["cognome_utente"];
    $data_nascita      = $_GET["data_nascita"];
    $indirizzo         = $_GET["indirizzo_utente"];
    $email_utente      = $_GET["email_utente"];
    $psw_utente        = $_GET["psw_utente"];
    $provincia_utente  = $_GET["provincia_utente"];

    $encrypted_psw     = password_hash($psw_utente, PASSWORD_DEFAULT);
    if(!filter_var($email_utente, FILTER_VALIDATE_EMAIL))
    {
        echo("L'email non e' valida");
        return;
    } 
    else
    {
        $stmt->bindParam(":email_utente", $email_utente, PDO::PARAM_STR);
    }
    $stmt->bindParam(":nome_utente", $nome_utente, PDO::PARAM_STR);
    $stmt->bindParam(":cognome_utente", $cognome_utente, PDO::PARAM_STR);
    $stmt->bindParam(":data_nascita", $data_nascita, PDO::PARAM_STR);
    $stmt->bindParam(":psw_utente", $encrypted_psw, PDO::PARAM_STR);
    $stmt->bindParam(":indirizzo_utente", $indirizzo, PDO::PARAM_STR);
    $stmt->bindParam(":provincia_utente", $provincia_utente, PDO::PARAM_INT);
    if ($stmt->execute() === TRUE) {
        echo "Utente inserito con successo";
    } else {
        echo "Errore!";

    }
    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }