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

      
  <ul class="nav navbar-nav mx-3" style="display:block;">
        <li class="nav-item userData">
          <span class="material-symbols-outlined">account_circle</span>
          <div class="row">
            <div id="name_user"></div>
            <div id="email_user"></div>
            
          </div>
         
        </li>
      </ul>




    <div class="container-fluid justify-content-center">
      <a class="navbar-brand" href="#">Concessionaria AutoMondo
        <span class="material-symbols-outlined">car_tag</span>
      </a>
    </div>


      <ul class="nav navbar-nav navbar-right mx-3">
        <a href="#" data-toggle="modal" data-target="#logoutModal">
          <button type="button" class="btn btn-outline-secondary btn-sm">Logout
            <span class="material-symbols-outlined">logout</span>
          </button>

        </a>
      </ul>

  </nav>
  <nav class="navbar navbar-expand-lg navbar-light " >
    <div class="container-fluid">


      <ul class="navbar-nav"  id = "actions">
        <li class="nav-item" >
          <a href="manage_cars.php"  id="gestisci_auto">Gestisci auto</a>
        </li>
        <li class="nav-item">
          <a href="manage_houses.php" id="gestisci_case">Gestisci case automobilistiche</a>
        </li>
        <li class="nav-item">
          <a href="manage_categories.php" id="gestisci_categorie">Gestisci categorie</a>
        </li>
        <li>
          <a href="manage_displacements.php" id="gestisci_cilindrate">Gestisci cilindrate</a>
        </li>
        <li>
          <a href="manage_users.php" id="gestisci_utenti">Gestisci utenti</a>
        </li>
        <li>
          <a id="query" href="do_query.php">Esegui query</a>
        </li>
      </ul>

  </nav>
  <hr class="hr hr-blurry" />
</body>

</html>

<script>
  function user_actions() {
    $("#gestisci_case").before("<a href='search_vehicle.php' id=\"ricerca_veicolo\">Ricerca veicolo</a>");
    $("#gestisci_auto").remove();
    $("#gestisci_case").remove();
    $("#gestisci_categorie").remove();
    $("#gestisci_cilindrate").remove();
    $("#gestisci_utenti").remove();
  }
//da fixare
 function highlight(){
   
  $("#actions").addClass(".li_onclick");
 }


</script>



<?php
session_start();
$name_user    = $_SESSION["name"];
$surname_user = $_SESSION["surname"];
$email_user   = $_SESSION["email"];
/*$user_details = "<label id = 'name_surname_user'>$name_user, $surname_user</label><br>"
  . "<label id = 'email_user'>$email_user</label>";*/
echo "<script>$(\"#name_user\").text(\"$name_user, $surname_user\");"
     . "$(\"#email_user\").text(\"$email_user\")</script>";

if ($_SESSION["admin_value"] == 0) {
  echo "<script>user_actions()</script>";
}

?>