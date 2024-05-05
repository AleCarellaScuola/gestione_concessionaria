<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://w3.p2hp.com/lib/w3.js"></script>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="email" name="rif_email" id="email" placeholder="email"><br>
        <input type="password" name="rif_psw" id="psw" placeholder="password"><br>
        <button type="submit" id="accedi" name="send_data">Accedi</button>
        <br>
        <a href="sign_up_page.php">Registrati</a>
    </form>
</body>

</html>

<?php
if(isset($_POST["send_data"]))
{
    $email_utente = $_POST["rif_email"];
    $psw_utente   = $_POST["rif_psw"];
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
                     Concessionaria_Utenti.email, Concessionaria_Utenti.password, Concessionaria_Utenti.admin
                  FROM
                     Concessionaria_Utenti";
        $stmt = $conn->query($query, PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
    
    
        if (count($result) > 0) {
            $controllo = false;
            foreach ($result as $row) {
                
            
                if($row["email"] == $email_utente && password_verify($psw_utente, $row["password"]))
                {
                    echo "Accesso effettuato";
                    $controllo = true;
                    //TODO iniziare sessione e come "cookie" mettere se l'utente e' admin o meno e reinderizzarlo alla pagina menu
                    session_start();
                    $_SESSION["admin_value"] = $row["admin"];
                    //print_r($_SESSION["admin_value"]);
                    header("refresh:5;url=menu.php");
                    break;
                }
            }
           
        } else {
            $risp["utenti"][] = $conn->errorInfo();
        }

        if(!$controllo)
        {
            echo "Accesso non riuscito, ritenta tra poco";
            header("refresh:5;url=log_in_page.php");
        }
    
    
    
        $conn   = null;
        $result = null;
        $stmt   = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }
}
?>