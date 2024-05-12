<?php
    session_start();

    if (!array_key_exists("logged_in", $_SESSION) && !$_SESSION["logged_in"]) {
        header("Location: ../log_in_page.php");
        exit(0);
    }
    
    $_SESSION["active_page"] = "auto";
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
<div id="model_vehicle_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="action"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                < class="modal-body" id="manage_model">
                    <input type = "hidden" id = "val_model">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="rif_name" id="name" placeholder="Inserisci il nome del modello">
                        <label for="name">Nome modello</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select id="case_automobilistiche" class="form-select">
                            <option selected>Seleziona la casa automobilistica</option>
                            <option w3-repeat="case" name="rif_casa" value="{{id_casa}}">{{nome}}</option>
                        </select>
                    </div>
                    <div class="form-floating mb-3">
                        <select id="alimentazioni" class="form-select">
                            <option selected>Seleziona l'alimentazione</option>
                            <option w3-repeat="alimentazioni" name="rif_alimentazione" value="{{id_alimentazione}}">{{nome}}</option>
                        </selec>
                    </div>
                    <div class="form-floating mb-3">
                        <select id="categorie" class="form-select">
                            <option selected>Seleziona la categoria</option>
                            <option w3-repeat="categorie" name="rif_categoria" value="{{id_categoria}}">{{descrizione}}</option>
                        </select>
                    </div>
                    <div class="form-floating mb-3">
                    <select id="cilindrate" class="form-select">
                            <option selected>Seleziona la cilindrata</option>
                            <option w3-repeat="cilindrate" name="rif_cilindrata" value="{{id_cilindrata}}">{{valore}}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id = "save_change_model" onclick = "call_action_model(this.value)">Save changes</button>
                    <button type="button" class="btn btn-secondary" id = "close" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="vehicle_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="action"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="manage_vehicle">
                    <input type = "hidden" id = "val_vehicle">
                    <div class = "form-floating mb-3">
                        <select id="modelli" class="form-select">
                            <option selected>Seleziona il modello</option>
                            <option w3-repeat="modelli" name="rif_modello" value="{{id_modello}}">{{nome_modello}} {{nome_casa_automobilistica}}, {{valore}}, {{alimentazione}}, {{descrizione}}</option>
                            <option id = "add_model">Aggiungi modello</option>
                        </select>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="rif_price" id="price" placeholder="Inserisci il prezzo">
                        <label for="price">Prezzo</label>
                    </div>
                    <div class="mb-3">
                        <label for="photo_vehicle" class = "form-label">Inserisci la foto del veicolo</label>
                        <input class="form-control" type="file" id="photo_vehicle" onchange = "loadFile(event)"  multiple >
                    </div>
                    <div class = "mb-3">
                        <label for = "photo_vehicle" style = "cursor: pointer" class = "form-label">Immagine caricata:</label>
                        <img id = "uploaded_image" class = "img-fluid">
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id = "save_change_vehicle" onclick = "call_action_vehicle(this.value)">Save changes</button>
                        <button type="button" class="btn btn-secondary" id = "close" data-dismiss="modal">Close</button>
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
            <th>Cilindrata</th>
            <th>Alimentazione</th>
            <th>Categoria</th>
            <th>Prezzo</th>
            <th>Veicolo</th>
        </tr>
            <tr w3-repeat="modelli_veicoli">
            <td>{{casa_produttrice}}</td>
            <td>{{nome_modello}}</td>
            <td>{{valore}}</td>
            <td>{{alimentazione}}</td>
            <td>{{descrizione}}</td>
            <td>{{prezzo}}</td>
            <td id = "rif_veicolo" value = "{{id_veicolo}}"><img src = "../../vehicle_photos/{{riferimento}}" class = "img-fluid" width="150px" height="150px"></td>
            <td><button class = "btn btn-outline-danger" type = "button" id = "delete" onclick = "delete_record()">Elimina</button></td>
            <td><button class = "btn btn-outline-secondary" type = "button" id = "modify" onclick = "modify_record()">Modifica</button></td>
            </tr>
        </table>
        <button class = "btn btn-outline-primary" type = "button" id = "insert" onclick = "do_insert()">Inserisci</button>
    </div>
</body>
</html>

<script>
    var loadFile = function(event) {
        var image = document.getElementById('uploaded_image');
        image.src = URL.createObjectURL(event.target.files[0]);
    };
    w3.getHttpObject("../../get/get_complete_vehicle.php", get_vehicle);

    function get_vehicle(risultato)
    {
        w3.displayObject("view_data", risultato);
    }

    w3.getHttpObject("../../get/get_modelli.php", get_models);

    function get_models(risultato)
    {
        w3.displayObject("modelli", risultato);
    }
    
    //TODO capire se bisogna cancellare solo il veicolo o anche il modello
    function delete_record() {
        $("#auto tr").on('click', function() {
            let id_veicolo = $(this).find("td#rif_veicolo").attr("value");
            console.log(id_veicolo);
            $.ajax({
                url: "../../delete/delete_veicolo.php?id_veicolo=" + id_veicolo,
                method: 'GET',
                dataType: 'html',
                success: function(risultato) {
                    alert(risultato);
                    $("#view_data").empty();
                    w3.getHttpObject("../../get/get_complete_vehicle.php", get_vehicle);
                },
                error: function(error) {
                    console.log("Errore: " + error);
                }
            }); 
        });
    }

    function modify_record() {
        //TODO modify cars
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#vehicle_modal")).show();
        $("#action").text("Modifica veicolo");
        //TODO per la questione della modifica far modificare il veicolo cambiando foto o prezzo o modello, se vuole modificare il modello allora farne creare uno nuovo o fargli scegliere se cambiare il modello a tutti i veicoli associati ad esso
        
        //$("#view_data").empty();
        //w3.getHttpObject("../../get/get_complete_vehicle.php", get_vehicle);
    }

    function do_insert() {
        //TODO insert vehicle
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Inserisci veicolo");
        //TODO aggiustare i bottoni dei modal'
        
        //TODO per la questione dell'inserimento, far inserire la foto del veicolo e il prezzo e fargli scegliere fra un modello esistente o altrimenti aggiungerne uno nuovo tramite modal
        let name   = $("#name").val();
        let p_iva  = $("#surname").val();
        
        /*$.ajax({
            url: "../../insert/insert_case.php?nome_casa="     + name
            + "&p_iva="                                        + p_iva,
            method: 'GET',
            dataType: 'html',
            success: function (risultato) {
                alert(risultato);
                $("#view_data").empty();
                w3.getHttpObject("../../get/get_case.php", get_case);
            },
            error: function (error) {
                console.log("Errore: " + error);
            }
        });*/
    }
</script>

