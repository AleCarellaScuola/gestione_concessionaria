<?php 
    session_start();
    if (!array_key_exists("logged_in", $_SESSION) && !$_SESSION["logged_in"]) {
        header("Location: ../log_in_page.php");
        exit(0);
    }
    
    $_SESSION["active_page"] = "categorie";
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
</head>

<body>
    <div id="prova-modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="action"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="manage_user">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="rif_name" id="categoria" placeholder="Inserisci la categoria del veicolo">
                        <label for="categoria">Categoria</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id = "view_data">
        <table id = "auto" class = "table table-bordered">
        <tr>
            <th>Categoria</th>
            <th>Elimina</th>
            <th>Modifica</th> 
            </tr>
            <tr w3-repeat="categorie" id = "val_categoria" value = "{{id_categoria}}">
            <td>{{descrizione}}</td>
            <td><button class = "btn btn-outline-danger" type = "button" id = "delete" onclick="delete_record()">Elimina</button></td>
            <td><button class = "btn btn-outline-secondary" type = "button" id = "modify" onclick="modify_record()">Modifica</button></td>
            </tr>
        </table>
        <button class = "btn btn-outline-primary" type = "button" id = "insert">Inserisci</button>
    </div>
</body>
</html>

<script>
    w3.getHttpObject("../../get/get_categorie.php", get_categoria);

    function get_categoria(risultato) {
        w3.displayObject("view_data", risultato);
    }

    function delete_record() {
        let id_categoria = $("#val_categoria").attr("value");

        $.ajax({
            url: "../../delete/delete_categoria.php?id_categoria=" + id_categoria,
            method: 'GET',
            dataType: 'html',
            success: function(risultato) {
                alert(risultato);
                $("#view_data").empty();
                w3.getHttpObject("../../get/get_categoria.php", get_categoria);
            },
            error: function(error) {
                console.log("Errore: " + error);
            }
        });
    }

    function modify_record() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Modifica categoria");
        $("#view_data").empty();
        w3.getHttpObject("../../get/get_categoria.php", get_categoria);
    }

    function do_insert() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Inserisci categoria");
        //TODO modify modal for insert or update and then open it
        //TODO aggiustare i bottoni dei modal'
        //TODO creare le pagine php per le update
        //TODO quando l'utente deve modificare, il modal deve visualizzare i valori gia' presenti nella riga dell'utente
        //TODO insert with admin value
        
        let descrizione = $("#categoria").val();        
        $.ajax({
            url: "../../insert/insert_categoria.php?val_categoria=" + descrizione,
            method: 'GET',
            dataType: 'html',
            success: function (risultato) {
                alert(risultato);
                $("#view_data").empty();
                w3.getHttpObject("../../get/get_categoria.php", get_categoria);
            },
            error: function (error) {
                console.log("Errore: " + error);
            }
        });
    }
</script>