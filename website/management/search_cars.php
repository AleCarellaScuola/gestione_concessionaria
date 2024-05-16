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
                        <select id="modelli" class="form-select" onchange = "open_modal_for_model(this.value)">
                            <option selected>Seleziona il modello</option>
                            <option w3-repeat="modelli" name="rif_modello" value="{{id_modello}}">{{nome_modello}} {{nome_casa_automobilistica}}, {{valore}}, {{alimentazione}}, {{descrizione}}</option>
                            <option id = "add_model" value = "add">Aggiungi modello</option>
                        </select>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="rif_price" id="price" placeholder="Inserisci il prezzo">
                        <label for="price">Prezzo</label>
                    </div>
                    <div class="mb-3">
                        <label for="photo_vehicle" class = "form-label">Inserisci la foto del veicolo</label>
                        <input class="form-control" type="file" id="photo_vehicle" name = "send_photo" onchange = "loadFile(event)" >
                    </div>
                    <div class = "mb-3">
                        <label for = "photo_vehicle" style = "cursor: pointer" class = "form-label">Immagine caricata:</label>
                        <img id = "uploaded_image" class = "img-fluid">
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id = "close_vehicle" data-dismiss="modal">Close</button>
                    </div>
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
                <th id = "cilindrata">Cilindrata</th>
                <th id = "alimentazione">Alimentazione</th>
                <th id = "categoria">Categoria</th>
                <th id = "prezzo">Prezzo</th>
            </tr>
            <tr w3-repeat="modelli_veicoli">
                <td id = "casa_veicolo">{{casa_produttrice}}</td>
                <td id = "rif_modello">{{nome_modello}}</td>
                <td id = "rif_veicolo" value = "{{id_veicolo}}"><img src = "..\..\vehicle_photos\{{riferimento}}" id = "photo" class = "img-fluid" width="150px" height="150px"></td>
                <td id = "cilindrata_veicolo">{{valore}}</td>
                <td id = "alimentazione_veicolo">{{alimentazione}}</td>
                <td id = "categoria_veicolo">{{descrizione}}</td>
                <td id = "prezzo_veicolo">{{prezzo}}</td>
                <td id = "see_vehicle"><button class = "btn btn-outline-info" type = "button" id = "see_more" onclick = "see_vehicle_data()">Espandi</button></td>
            </tr>
        </table>
        <button class = "btn btn-outline-primary" type = "button" id = "search">Ricerca</button>
    </div>
</body>
</html>


<script>
    //TODO visualizzare solo il nome della casa automobilistica, il nome del modello e la foto del veicolo, quando clicca, salvare la visita e mostrargli le altre informazioni
    //TODO ricerca dei veicoli
    w3.getHttpObject("../../get/get_complete_vehicle.php", get_vehicle);
    function get_vehicle(risultato)
    {
        w3.displayObject("view_data", risultato);
    }

    $(document).ready(function() {
        $("#cilindrata").hide();
        $("#alimentazione").hide();
        $("#categoria").hide();
        $("#prezzo").hide();
        $("#cilindrata_veicolo").hide();
        $("#categoria_veicolo").hide();
        $("#prezzo_veicolo").hide();
        $("#alimentazione_veicolo").hide();
    });
    
    function see_vehicle_data()
    {
        //bootstrap.Modal.getOrCreateInstance(document.querySelector("#vehicle_modal")).show();
        $("#action_vehicle").text("Dati veicolo");
        $("#cilindrata").show();
        $("#alimentazione").show();
        $("#categoria").show();
        $("#prezzo").show();
        $('#auto tr').on('click', function() {
            $(this).find("td#cilindrata_veicolo").show();
            $(this).find("td#categoria_veicolo").show();
            $(this).find("td#prezzo_veicolo").show();
            $(this).find("td#alimentazione_veicolo").show();
        });
    }
    
</script>
