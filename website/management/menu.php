<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://w3.p2hp.com/lib/w3.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="menu_style.css">
    <!--link icone google apis-->
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    </head>

<body>
   
       <nav class="navbar navbar-expand-lg navbar-light bg-light">
             <div class="container-fluid">
    <a class="navbar-brand" href="#">Concessionaria AutoMondo
    <span class="material-symbols-outlined">car_tag</span>
    </a>
    
      <ul class="nav navbar-nav mx-auto" style="display:block;">
      <li class="nav-item userData mx-2">
      <span class="material-symbols-outlined">account_circle</span>
       
          <div id="name_user">{NOME}</div>
          <div id="surname_user">{COGNOME}</div>
        </li>
      
     
        </ul>

        <ul class="nav navbar-nav navbar-right">
        <a href="#" data-toggle="modal" data-target="#logoutModal">
          <button type="button" class="btn btn-outline-secondary btn-sm">Logout
            <span class="material-symbols-outlined">logout</span>
          </button>
       
        </a>
      
       
      </ul>
  
</nav>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
             <div class="container-fluid">


      <ul class="navbar-nav">
        <li class="nav-item">
        <a href = "manage_cars.php" id = "gestisci_auto">Gestisci auto</a>
        </li>
        <li class="nav-item">
        <a href = "manage_houses.php" id = "gestisci_case">Gestisci case automobilistiche</a> 
        </li>
        <li class="nav-item">
        <a href = "manage_categories.php" id = "gestisci_categorie">Gestisci categorie</a>
        </li>
        <li>
        <a href = "manage_displacements.php" id = "gestisci_cilindrate">Gestisci cilindrate</a>
        </li>
        <li>
        <a href = "manage_users.php" id = "gestisci_utenti">Gestisci utenti</a> 
        </li>
        <li>
        <a  id = "query" href = "do_query.php">Esegui query</a>
        </li>
      </ul>
  
</nav>
<div class="container"> 
           <div class="riquadro col col-xl-4 col-lg-4 col-md-4 col-sm-4 mx-auto">
           
           <div style="padding:5px">
           nome<br>cognome<br>ewrwr
            <p id = "user">
            
                </p>
          </div>
          
        
    

        <div id = "actions">
            <label>Azioni</label>
            <br>
          
            <a href = "manage_cars.php" id = "gestisci_auto">Gestisci auto</a>
            <br>
            <a href = "manage_houses.php" id = "gestisci_case">Gestisci case automobilistiche</a> 
            <br>
            <a href = "manage_categories.php" id = "gestisci_categorie">Gestisci categorie</a>
            <br>
            <a href = "manage_displacements.php" id = "gestisci_cilindrate">Gestisci cilindrate</a>
            <br>
            <a href = "manage_users.php" id = "gestisci_utenti">Gestisci utenti</a> 
            <br>
            <a id = "query" href = "do_query.php">Esegui query</a>
            </ul>
        </div>
    </div>
 </div>
</body>
</html>

<script>
    function user_actions()
    {   
     
   
        $("#gestisci_auto").remove();
        $("#gestisci_case").remove();
        $("#gestisci_categorie").remove();
        $("#gestisci_cilindrate").remove();
        $("#gestisci_utenti").remove();
        $("#actions").append("<a href = \"management/search_cars.php\" id = \"ricerca_veicolo\">Ricerca veicolo</a>");
    }
</script>


<?php
    session_start();
    $name_user    = $_SESSION["name"];
    $surname_user = $_SESSION["surname"];
    $email_user   = $_SESSION["email"];
    $user_details = "<label id = 'name_surname_user'>$name_user, $surname_user</label><br>"
                    . "<label id = 'email_user'>$email_user</label>";
    echo "<script>$(\"#user\").html(\"$user_details\");</script>";

    if($_SESSION["admin_value"] == 0)
    {
        echo "<script>user_actions()</script>";
    }

?>
