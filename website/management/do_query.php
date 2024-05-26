
<?php 
    session_start();
    if (!array_key_exists("logged_in", $_SESSION) && !$_SESSION["logged_in"]) {
        header("Location: ../log_in_page.php");
        exit(0);
    }
    
    $_SESSION["active_page"] = "do_query";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="menu_style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body style = "color: white" onload = "onload()">
    <div class="px-4">
        <p id = "first_query">
            <h3>Prima query</h3>
            <select id = "get_moto" class = "form-select" style = "width: 400px;">
                <option w3-repeat = "moto" value = "{{id_modello}}">{{casa_produttrice}} {{nome_modello}} {{valore}}cc, {{alimentazione}}</option>
            </select>
            <br>
            <button id = "send_motorcycle" class = "btn btn-primary" onclick = "numero_visite()">Seleziona</button>
            <table class = "table table-bordered" id = "prima">
                <tr>
                    <th>Numero di visite</th>
                    <th>Modello</th>
                </tr>
                <tr w3-repeat="numero_visite" >
                    <td>{{n_visite}}</td>
                    <td>{{nome}}</td>
                </tr>
            </table>
        </p>

        <p id = "second_query">
            <h3>Seconda query</h3>
            <select id = "get_auto" class = "form-select" style = "width: 400px;">
                <option w3-repeat="macchine" value = "{{id_modello}}">{{casa_produttrice}} {{nome_modello}} {{valore}}cc, {{alimentazione}}</option>
            </select>
            <br>
            <button id = "send_cars" class = "btn btn-primary" onclick = "esegui_seconda()">Seleziona</button>
            <table class = "table table-bordered" id = "seconda">
                <tr>
                    <th>Provincia</th>
                    <th>Eta</th>
                    <th>Categoria</th>
                    <th>Nome</th>
                </tr>
                <tr w3-repeat="seconda_query">
                    <td>{{nome_provincia}}</td>
                    <td>{{Eta}}</td>
                    <td>{{descrizione}}</td>
                    <td>{{nome}}</td>
                </tr>
            </table>
        </p>

        <p id = "third_query">
            <h3>Terza query</h3>
            <table class = "table table-bordered" id = "terza">
                <tr>
                    <th>Casa automobilistica</th>
                    <th>Modello</th>
                    <th>Categoria</th>
                </tr>
                <tr w3-repeat="terza_query">
                    <td>{{nome_casa}}</td>
                    <td>{{nome_modello}}</td>
                    <td>{{descrizione}}</td>
                </tr>
            </table>
        </p>

        <p id = "fourth_query">
            <h3>Quarta query</h3>
            <table class = "table table-bordered" id = "quarta">
                <tr>
                    <th>Modello</th>
                    <th>Numero di visite</th>
                    <th>Provincia</th>
                    <th>Acronimo</th>
                    <th>Categoria</th>
                    <th>Casa automobilistica</th>
                </tr>
                <tr w3-repeat="quarta_query">
                    <td>{{Nome_modello}}</td>
                    <td>{{N_visite}}</td>
                    <td>{{Provincia}}</td>
                    <td>{{acronimo}}</td>
                    <td>{{descrizione}}</td>
                    <td>{{Casa_produttrice}}</td>
                </tr>
            </table>
        </p>
        
        <p id = "fifth_query">
            <h3>Quinta query</h3>
            <select id = "get_veicoli" class = "form-select" style = "width: 400px;">
                <option w3-repeat="modelli_veicoli" value = "{{id_veicolo}}">{{casa_produttrice}} {{nome_modello}} {{valore}}cc, {{alimentazione}}</option>
            </select>
            <br>
            <button id = "send_vehicle" class = "btn btn-primary" onclick = "esegui_quinta()">Seleziona</button>
            <table class = "table table-bordered" id = "quinta">
                <tr>
                    <th>Cognome</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Numero di visite</th>
                </tr>
                <tr w3-repeat="quinta_query">
                    <td>{{cognome}}</td>
                    <td>{{nome}}</td>
                    <td>{{email}}</td>
                    <td>{{N_visite}}</td>
                </tr>
            </table>
        </p>
    </div>
</body>

<script>
    function onload()
    {
        $("#prima").hide();
        $("#seconda").hide();
        $("#quinta").hide();
    }

    w3.getHttpObject("../../get/get_motorcycle.php", get_moto);
    function get_moto(risultato)
    {
        w3.displayObject("get_moto", risultato);
    }

    w3.getHttpObject("../../get/get_cars.php", get_auto);
    function get_auto(risultato)
    {
        w3.displayObject("get_auto", risultato);
    }

    function esegui_seconda() 
    {
        let id_modello = $("#get_auto :selected").attr("value");

        w3.getHttpObject("../../query/second_query.php?rif_modello=" + id_modello, second_query);
        function second_query(risultato)
        {
            $("#seconda").show();
            w3.displayObject("seconda", risultato);
        }
    }


    w3.getHttpObject("../../get/get_complete_vehicle.php", get_vehicle);
    function get_vehicle(risultato)
    {
        w3.displayObject("get_veicoli", risultato);
    }

    function esegui_quinta()
    {
        let id_veicolo = $("#get_veicoli :selected").attr("value");

        w3.getHttpObject("../../query/fifth_query.php?rif_veicolo=" + id_veicolo, fifth_query);
        function fifth_query(risultato)
        {
            $("#quinta").show();
            w3.displayObject("quinta", risultato);
        }
    }

    function numero_visite()
    {
        let id_modello = $("#get_moto :selected").attr("value");

        w3.getHttpObject("../../query/first_query.php?rif_modello=" + id_modello, first_query);
        function first_query(risultato)
        {
            $("#prima").show();
            w3.displayObject("prima", risultato);
        }
    }

    w3.getHttpObject("../../query/third_query.php", third_query);
    function third_query(risultato)
    {
        w3.displayObject("terza", risultato);
    }

    w3.getHttpObject("../../query/fourth_query.php", fourth_query);
    function fourth_query(risultato)
    {
        w3.displayObject("quarta", risultato);
    }

</script>