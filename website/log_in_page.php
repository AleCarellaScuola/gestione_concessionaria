<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://w3.p2hp.com/lib/w3.js"></script>
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="sign_up_style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">


<div class="container-fluid justify-content-center">
  <a class="navbar-brand" href="#">Concessionaria AutoMondo
    <span class="material-symbols-outlined">car_tag</span>
  </a>
</div>




</nav>
<nav class="navbar navbar-expand-lg navbar-light ">
<div class="container-fluid">


</nav>




    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
     <div class="riquadro col col-xl-4 col-lg-4 col-md-4 col-sm-4 mx-auto">
         <div class="form-group">
                <h3 style="color: white;">Log-in</h3>
                <div class="form-floating mb-3">  
                    <input  type="email" class="form-control" name="rif_email" id="email" placeholder="email"><br>
                    <label for="email">E-mail</label>
                </div>
                <div class="form-floating mb-3">  
                    <input type="password" class="form-control" name="rif_psw" id="psw" placeholder="password"><br>
                    <label for="psw">Password</label>
                </div> 
                    <button type="submit" class = "btn btn-light" id="accedi" name="send_data">Accedi</button>
                    <br>
                    <div class="reg">
                          <label class = "form-label text-light" style="color: white;">Non sei ancora registrato? </label>
                    <a href="sign_up_page.php">Registrati</a>  
                    </div>
                
           </div>
        </div>
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
                     Concessionaria_Utenti.id_utente,
                     Concessionaria_Utenti.nome, Concessionaria_Utenti.cognome,
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
                    echo "<script>alert(\"Accesso effettuato\")</script>";
                    $controllo = true;
                    
                    session_start();
                    $_SESSION["admin_value"] = $row["admin"];
                    $_SESSION["name"]        = $row["nome"];
                    $_SESSION["surname"]     = $row["cognome"];
                    $_SESSION["email"]       = $row["email"];
                    $_SESSION["logged_in"]   = true;
                    $_SESSION["active_page"] = "";
                    if($_SESSION["admin_value"] == 1)
                        header("refresh:0;url=management/manage_cars.php");
                    else
                        header("refresh:0;url=management/search_cars.php");
                    break;
                }
            }
           
        } else {
            $risp["utenti"][] = $conn->errorInfo();
        }

        if(!$controllo)
        {
            echo "<script>alert(\"Accesso non riuscito, ritenta tra poco\")</script>";
            header("refresh:0;url=log_in_page.php");
        }
    
    
    
        $conn   = null;
        $result = null;
        $stmt   = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }
}
?>