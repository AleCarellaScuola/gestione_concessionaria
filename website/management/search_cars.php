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
    <div id="vehicle_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="action_vehicle"></h5>
                </div>
                <div class="modal-body" id="manage_vehicle">
                    <input type = "hidden" id = "val_vehicle">
                    <div class = "form-floating mb-3"> 
                        <figure class="figure">
                            <img src="..." class="figure-img img-fluid rounded" id = "get_vehicle">
                            <figcaption class="figure-caption" id = "modello_e_nome_veicolo"></figcaption>
                        </figure>
                    </div>
                    <p>
                        <label class = "form-label" id = "prezzo">Prezzo: €</label>
                    </p>
                    <p>
                        <label class = "form-label" id = "cilindrata">Cilindrata: </label>
                    </p>
                    <p>
                        <label class = "form-label" id = "categoria">Categoria: </label>
                    </p>
                    <p>
                        <label class = "form-label" id = "alimentazione">Alimentazione: </label>
                    </p>
                    <p class="modal-footer">
                        <button type="button" class="btn btn-secondary" id = "close_vehicle" data-dismiss="modal">Close</button>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id = "view_data">
        <table id = "auto" class = "table table-hover">
            <tr>
                <th>Casa produttrice</th>
                <th>Nome modello</th>
                <th>Veicolo</th>
                <th hidden>Cilindrata</th>
                <th hidden>Alimentazione</th>
                <th hidden>Categoria</th>
                <th hidden>Prezzo</th>
            </tr>
            <tr w3-repeat="modelli_veicoli">
                <td id = "casa_veicolo">{{casa_produttrice}}</td>
                <td id = "rif_modello">{{nome_modello}}</td>
                <td id = "rif_veicolo" value = "{{id_veicolo}}"><img src = "..\..\vehicle_photos\{{riferimento}}" id = "photo" class = "img-fluid" width="150px" height="150px"></td>
                <td id = "cilindrata_veicolo" hidden>{{valore}}</td>
                <td id = "alimentazione_veicolo" hidden>{{alimentazione}}</td>
                <td id = "categoria_veicolo" hidden>{{descrizione}}</td>
                <td id = "prezzo_veicolo" hidden>{{prezzo}}</td>
                <td id = "see_vehicle"><button class = "btn btn-outline-info" type = "button" id = "see_more" onclick = "see_vehicle_data()">Espandi</button></td>
            </tr>
        </table>
        <button class = "btn btn-outline-primary" type = "button" id = "search">Ricerca</button>
    </div>
</body>
</html>


<script>
    //TODO ricerca dei veicoli
    //TODO sull'on click di espandi oltre ad aprire il modal, inserire la visita di quell'utente su quella specifica macchina
    //TODO dargli la possibilità di filtrare i veicoli
    w3.getHttpObject("../../get/get_complete_vehicle.php", get_vehicle);
    function get_vehicle(risultato)
    {
        w3.displayObject("view_data", risultato);
    }
    
    function see_vehicle_data()
    {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#vehicle_modal")).show();
        $("#action_vehicle").text("Dati veicolo");
        $('#auto tr').on('click', function() {
            $("#get_vehicle").attr("src", $(this).find("img#photo").attr("src"));
            $("#modello_e_nome_veicolo").text($(this).find("td#casa_veicolo").text() + ", "+ $(this).find("td#rif_modello").text());
            $("#prezzo").text("Prezzo: €" + $(this).find("td#prezzo_veicolo").text());
            $("#cilindrata").text("Cilindrata: " + $(this).find("td#cilindrata_veicolo").text());
            $("#categoria").text("Categoria: " + $(this).find("td#categoria_veicolo").text());
            $("#alimentazione").text("Alimentazione: " + $(this).find("td#alimentazione_veicolo").text());
            let id_veicolo = $(this).find("td#rif_veicolo").attr("value");
            $("#val_vehicle").attr("value", id_veicolo);
        });

    }

    $("#close_vehicle").on('click', function() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#vehicle_modal")).hide();
    });
</script>
