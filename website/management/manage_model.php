
<?php 
    session_start();
    if (!array_key_exists("logged_in", $_SESSION) && !$_SESSION["logged_in"]) {
        header("Location: ../log_in_page.php");
        exit(0);
    }
    
    $_SESSION["active_page"] = "modelli";
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

<body>
<div id="model_vehicle_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="action_model"></h5>
                </div>
                <div class="modal-body" id="manage_model">
                    <input type = "hidden" id = "val_model">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="rif_name" id="nome_modello" placeholder="Inserisci il nome del modello">
                        <label for="name">Nome modello</label>
                    </div>
                    <div class="mb-3">
                    <label>Seleziona la casa automobilistica:</label>
                        <select id="case_automobilistiche" class="form-select">
                            <option selected>Seleziona la casa automobilistica</option>
                            <option w3-repeat="case" name="rif_casa" value="{{id_casa}}">{{nome}}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                    <label>Seleziona l'alimentazione:</label>                    
                        <select id="alimentazioni" class="form-select">
                            <option selected>Seleziona l'alimentazione</option>
                            <option w3-repeat="alimentazioni" name="rif_alimentazione" value="{{id_alimentazione}}">{{nome}}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                    <label>Seleziona la categoria:</label>
                        <select id="categorie" class="form-select">
                            <option selected>Seleziona la categoria</option>
                            <option w3-repeat="categorie" name="rif_categoria" value="{{id_categoria}}">{{descrizione}}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                    <label>Seleziona la cilindrata:</label>
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
    <div id = "view_data">
        <table id = "auto" class = "table table-hover">
        <tr>
            <th>Nome modello</th>
            <th>Casa automobilistica</th>
            <th>Cilindrata</th> 
            <th>Alimentazione</th> 
            <th>Categoria</th> 
            <th>Opzioni</th> 
        </tr>
            <tr w3-repeat="modelli" id = "val_categoria" value = "{{id_modello}}">
            <td id = "modello">{{nome_modello}}</td>
            <td id = "casa_automobilistica">{{nome_casa_automobilistica}}</td>
            <td id = "cilindrata">{{valore}}</td>
            <td id = "alimentazione">{{alimentazione}}</td>
            <td id = "categoria">{{descrizione}}</td>
            <td><div class="px-2 py-2">
                        <button type="button" class="btn btn-outline-danger" id = "delete" onclick = "delete_record()" ><span class="material-symbols-outlined">delete</span></button>
                        <button type="button" class="btn btn-outline-secondary" id = "modify" onclick = "modify_record();"><span class="material-symbols-outlined">edit_note</span></button>
                </div>
            </td>
            </tr>
        </table>
        <button class = "btn btn-outline-primary ombra mx-3 mb-3" type = "button" id = "insert" onclick = "do_insert()">Inserisci</button>
    </div>
</body>
</html>

<script>
    $("#close").on('click', function() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#model_vehicle_modal")).hide();
    });

    w3.getHttpObject("../../get/get_case.php", get_house);
    function get_house(risultato)
    {
        w3.displayObject("case_automobilistiche", risultato);
    }

    w3.getHttpObject("../../get/get_alimentazioni.php", get_alimentazione);
    function get_alimentazione(risultato)
    {
        w3.displayObject("alimentazioni", risultato);
    }

    w3.getHttpObject("../../get/get_categorie.php", get_category);
    function get_category(risultato)
    {
        w3.displayObject("categorie", risultato);
    }

    w3.getHttpObject("../../get/get_cilindrate.php", get_cilindrata);
    function get_cilindrata(risultato)
    {
        w3.displayObject("cilindrate", risultato);
    }

    w3.getHttpObject("../../get/get_modelli.php", get_modelli);
    function get_modelli(risultato) {
        w3.displayObject("view_data", risultato);
    }

    function delete_record() {
        $('#auto tr').on('click', function(){
            let disclaimer = "Attenzione!\nSe elimini il modello, verranno eliminati tutti i veicoli associati ad esso.\nSei sicuro di voler procedere?\n"; 
            if(confirm(disclaimer) === true)
            {
                let id_modello = $(this).attr("value");
                $.ajax({
                    url: "../../delete/delete_model.php?id_modello=" + id_modello,
                    method: 'GET',
                    dataType: 'html',
                    success: function(risultato) {
                        alert(risultato);
                        $("#view_data").empty();
                        w3.getHttpObject("../../get/get_modelli.php", get_modelli);
                    },
                    error: function(error) {
                        console.log("Errore: " + error);
                    }
                });
            }
            return;
        });
    }

    function modify_record() 
    {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#model_vehicle_modal")).show();
        $("#action_model").text("Modifica modello");
        $('#auto tr').on('click', function() {
            $("#nome_modello").val($(this).find("td#modello").text());
            $("#case_automobilistiche option:contains(" + $(this).find("td#casa_automobilistica").text() + ")").attr("selected", "selected");
            $("#categorie option:contains(" + $(this).find("td#categoria").text() + ")").attr("selected", "selected");
            $("#cilindrate option:contains(" + $(this).find("td#cilindrata").text() + ")").attr("selected", "selected");
            $("#alimentazioni option:contains(" + $(this).find("td#alimentazione").text() + ")").attr("selected", "selected");
            let id_modello = $(this).attr("value");
            $("#val_model").attr("value", id_modello);
            
        });
        $("#save_change_model").attr("value", "update");
    }

    function do_insert() 
    {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#model_vehicle_modal")).show();
        $("#action_model").text("Inserisci modello");
        $("#nome_modello").val("");
        $("#case_automobilistiche option:contains(Seleziona la casa automobilistica)").prop("selected", true);
        $("#alimentazioni option:contains(Seleziona l'alimentazione)").prop("selected", true);
        $("#categorie option:contains(Seleziona la categoria)").prop("selected", true);
        $("#cilindrate option:contains(Seleziona la cilindrata)").prop("selected", true);
        $("#save_change_model").attr("value", "insert");
    }

    function call_action_model(id_action)
    {
        if(id_action == "insert")
        {
            let nome_modello     = $("#nome_modello").val();
            let id_casa          = $("#case_automobilistiche option:selected").val();
            let id_cilindrata    = $("#cilindrate option:selected").val();   
            let id_alimentazione = $("#alimentazioni option:selected").val();
            let id_categoria     = $("#categorie option:selected").val();

            $.ajax({
                url: "../../insert/insert_modelli.php?rif_modello=" + nome_modello
                + "&rif_casa="                                      + id_casa
                + "&rif_cilindrata="                                + id_cilindrata
                + "&rif_alimentazione="                             + id_alimentazione
                + "&rif_categoria="                                 + id_categoria,
                method: 'GET',
                dataType: 'html',
                success: function (risultato) {
                    alert(risultato);
                    $("#view_data").empty();
                    w3.getHttpObject("../../get/get_modelli.php", get_modelli);
                    bootstrap.Modal.getOrCreateInstance(document.querySelector("#model_vehicle_modal")).hide();
                },
                error: function (error) {
                    console.log("Errore: " + error);
                }
            });
        } else if (id_action == "update")
        {
            let nome_modello     = $("#nome_modello").val();
            let id_casa          = $("#case_automobilistiche option:selected").val();
            let id_cilindrata    = $("#cilindrate option:selected").val();   
            let id_alimentazione = $("#alimentazioni option:selected").val();
            let id_categoria     = $("#categorie option:selected").val();
            let id_modello       = $("#val_model").attr("value");

            $.ajax({
                url: "../../update/update_model.php?rif_modello=" + nome_modello
                + "&rif_casa="                                    + id_casa
                + "&rif_cilindrata="                              + id_cilindrata
                + "&rif_alimentazione="                           + id_alimentazione
                + "&rif_categoria="                               + id_categoria
                + "&id_modello="                                  + id_modello,
                method: 'GET',
                dataType: 'html',
                success: function (risultato) {
                    alert(risultato);
                    $("#view_data").empty();
                    w3.getHttpObject("../../get/get_modelli.php", get_modelli);
                    bootstrap.Modal.getOrCreateInstance(document.querySelector("#model_vehicle_modal")).hide();
                },
                error: function (error) {
                    console.log("Errore: " + error);
                }
            });
            
        }
    }
    
</script>