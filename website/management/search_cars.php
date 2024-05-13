<?php
    //TODO search_cars
    session_start();

    if (!array_key_exists("logged_in", $_SESSION) && !$_SESSION["logged_in"]) {
        header("Location: ../log_in_page.php");
        exit(0);
    }
    
    $_SESSION["active_page"] = "ricerca";
    require "menu.php";
    $name_user    = $_SESSION["name"];
    $surname_user = $_SESSION["surname"];
    $email_user   = $_SESSION["email"];
  
    echo "<script>$(\"#name_user\").text(\"$name_user, $surname_user\");"
      . "$(\"#email_user\").text(\"$email_user\")</script>";
?>
<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://w3.p2hp.com/lib/w3.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="menu_style.css">
</head>

<body>

    <div id = "view_data">
        <table id = "auto" class = "table table-hover">
        <tr>
            <th>Casa produttrice</th>
            <th>Nome modello</th>
            <th>Cilindrata</th>
            <th>Alimentazione</th>
            <th>Categoria</th>
            <th>Prezzo</th>
            <th>Veicolo</th>
        </tr>
            <tr w3-repeat="modelli_veicoli">
            <td id = "casa_veicolo">{{casa_produttrice}}</td>
            <td id = "rif_modello">{{nome_modello}}</td>
            <td id = "cilindrata_veicolo">{{valore}}</td>
            <td id = "alimentazione_veicolo">{{alimentazione}}</td>
            <td id = "categoria_veicolo">{{descrizione}}</td>
            <td id = "prezzo_veicolo">{{prezzo}}</td>
            <td id = "rif_veicolo" value = "{{id_veicolo}}"><img src = "..\..\vehicle_photos\{{riferimento}}" id = "photo" class = "img-fluid" width="150px" height="150px"></td>
            </tr>
        </table>
        <button class = "btn btn-outline-primary" type = "button" id = "insert">Ricerca</button>
    </div>
</body>
</html>


<script>
    //TODO ricerca dei veicoli
    w3.getHttpObject("../../get/get_complete_vehicle.php", get_vehicle);
    function get_vehicle(risultato)
    {
        w3.displayObject("view_data", risultato);
    }
</script>
