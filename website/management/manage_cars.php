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
                        </select>
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
                    <button type="button" class="btn btn-primary" id = "save_change_model" onclick = "call_action_model()">Save changes</button>
                    <button type="button" class="btn btn-secondary" id = "close_model" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="vehicle_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="action_vehicle"></h5>
                </div>
                <div class="modal-body" id="manage_vehicle">
                    <input type = "hidden" id = "val_vehicle">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype = "multipart/form-data">                    
                        <div class = "form-floating mb-3">
                            <select id="modelli" class="form-select" onchange = "open_modal_for_model(this.value)">
                                <option value = "null" selected>Seleziona il modello</option>
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
                            <button type="submit" class="btn btn-primary" id = "save_change_vehicle" name = "send_data" onclick = "call_action_vehicle(this.value)">Save changes</button>
                            <button type="button" class="btn btn-secondary" id = "close_vehicle" data-dismiss="modal">Close</button>
                        </div>
                    </form>
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
            <td id = "casa_veicolo">{{casa_produttrice}}</td>
            <td id = "rif_modello">{{nome_modello}}</td>
            <td id = "cilindrata_veicolo">{{valore}}</td>
            <td id = "alimentazione_veicolo">{{alimentazione}}</td>
            <td id = "categoria_veicolo">{{descrizione}}</td>
            <td id = "prezzo_veicolo">{{prezzo}}</td>
            <td id = "rif_veicolo" value = "{{id_veicolo}}"><img src = "..\..\vehicle_photos\{{riferimento}}" id = "photo" class = "img-fluid" width="150px" height="150px"></td>
            <td><div class="px-2 py-2">
                        <button type="button" class="btn btn-outline-danger" id = "delete" onclick = "delete_record()" ><span class="material-symbols-outlined">delete</span></button>
                        <button type="button" class="btn btn-outline-secondary" id = "modify" onclick = "modify_record();"><span class="material-symbols-outlined">edit_note</span></button>
                </div>
            </td>
            </tr>
        </table>
        <button class = "btn btn-outline-primary" type = "button" id = "insert" onclick = "do_insert()">Inserisci</button>
    </div>
</body>
</html>


<script>
    
    $("#close_vehicle").on('click', function() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#vehicle_modal")).hide();
    });
    
    $("#close_model").on('click', function() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#model_vehicle_modal")).hide();
    });

    var loadFile = function(event) {
        var image = document.getElementById('uploaded_image');
        image.src = URL.createObjectURL(event.target.files[0]);
        console.log($("#photo_vehicle").attr("value", $("#photo_vehicle").val()));
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
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#vehicle_modal")).show();
        $("#action_vehicle").text("Modifica veicolo");
        $('#auto tr').on('click', function() {
            $("#modelli option:contains(" + $(this).find("td#rif_modello").text() + ")").attr('selected', 'selected');
            $("#price").val($(this).find("td#prezzo_veicolo").text());
            let id_categoria = $(this).attr("value");
            $("#val_categoria").attr("value", id_categoria);
            $("#uploaded_image").attr("src", $(this).find("img#photo").attr("src"));
            $("#photo_vehicle").attr("value", $(this).find("img#photo").attr("src"));
        });
        $("#save_change_vehicle").attr("value", "update");
        
    }

    function do_insert() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#vehicle_modal")).show();
        $("#action_vehicle").text("Inserisci veicolo");
        $("#modelli").val("null").attr('selected', 'selected');
        $("#price").val("");
        $("#uploaded_image").attr("src", "");
        $("#save_change_vehicle").attr("value", "insert");
    }
    
    function call_action_vehicle(action)
    {
        
        if(action === "insert")
        {
            let prezzo     = $("#price").val();
            let src_photo  = $("#photo_vehicle").val().split('\\').pop();
            let id_modello = $("#modelli option:selected").val();   
            
            $.ajax({
                url: "../../insert/insert_veicoli.php?prezzo_veicolo=" + prezzo
                + "&rif_foto="                                         + src_photo
                + "&id_modello="                                       + id_modello,
                method: 'GET',
                dataType: 'html',
                success: function (risultato) {
                    alert(risultato);
                    $("#view_data").empty();
                    w3.getHttpObject("../../get/get_complete_vehicle.php", get_vehicle);
                    bootstrap.Modal.getOrCreateInstance(document.querySelector("#vehicle_modal")).hide();
                },
                error: function (error) {
                    console.log("Errore: " + error);
                }
            });
       } else if (action === "update")
       {
            let prezzo     = $("#price").val();
            let src_photo  = $("#photo_vehicle").attr("value").split('\\').pop();
            let id_modello = $("#modelli option:selected").val();   
            let id_veicolo = $("#rif_veicolo").attr("value");
            $.ajax({
                url: "../../update/update_vehicle.php?prezzo=" + prezzo
                + "&link_foto="                                + src_photo
                + "&id_modello="                               + id_modello
                + "&id_veicolo="                               + id_veicolo,
                method: 'GET',
                dataType: 'html',
                success: function (risultato) {
                    alert(risultato);
                    $("#view_data").empty();
                    w3.getHttpObject("../../get/get_complete_vehicle.php", get_vehicle);
                    bootstrap.Modal.getOrCreateInstance(document.querySelector("#vehicle_modal")).hide();
                },
                error: function (error) {
                    console.log("Errore: " + error);
                }
            });
       }
    }
    
    
    function open_modal_for_model(value)
    {
        if(value === "add")
        {
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
            bootstrap.Modal.getOrCreateInstance(document.querySelector("#model_vehicle_modal")).show();
            bootstrap.Modal.getOrCreateInstance(document.querySelector("#vehicle_modal")).hide();
            $("#action_model").text("Inserisci modello");
        }
    } 
    
    function call_action_model(action)
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
                $("#modelli").empty();
                w3.getHttpObject("../../get/get_modelli.php", get_models);
                bootstrap.Modal.getOrCreateInstance(document.querySelector("#model_vehicle_modal")).hide();
                bootstrap.Modal.getOrCreateInstance(document.querySelector("#vehicle_modal")).show();
            },
            error: function (error) {
                console.log("Errore: " + error);
            }
        });

    }
</script>

<?php
//TODO delete file on button click
    $uploads_dir = 'D:\Program Files\Xampp\xampp\htdocs\ESERCIZI\Concessionaria_sito\gestione_concessionaria\vehicle_photos ';
    if(isset($_POST["send_data"]) === true)
    {
        $error = $_FILES["send_photo"]["error"];
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["send_photo"]["tmp_name"];
            // basename() may prevent filesystem traversal attacks;
            // further validation/sanitation of the filename may be appropriate
            $name = basename($_FILES["send_photo"]["name"]);
            move_uploaded_file($tmp_name, "$uploads_dir\\$name");
        }
    }
?>
