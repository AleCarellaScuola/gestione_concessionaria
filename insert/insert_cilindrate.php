
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
                INSERT INTO Concessionaria_cilindrate
                (valore)
                VALUES
                (:valore)";
    $stmt = $conn->prepare($query);
    $cilindrata = $_GET["val_cilindrata"];
    $stmt->bindParam(":valore", $cilindrata, PDO::PARAM_STR);
    if ($stmt->execute() === TRUE) {
        echo "Cilindrata inserita con successo";
    } else {
        echo "Errore!";

    }
    $conn = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }