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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <div id="prova-modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="action"></h5>
                </div>
                <div class="modal-body" id="manage_user">
                    <input type = "hidden" id = "val_categoria">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="rif_name" id="categoria" placeholder="Inserisci la categoria del veicolo">
                        <label for="categoria">Categoria</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id = "save_change" onclick = "call_action(this.value)">Save changes</button>
                    <button type="button" class="btn btn-secondary" id = "close" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id = "view_data">
        <table id = "auto" class = "table table-hover">
        <tr>
            <th>Categoria</th>
            </tr>
            <tr w3-repeat="categorie" id = "val_categoria" value = "{{id_categoria}}">
            <td id = "descrizione_categoria">{{descrizione}}</td>
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
    $("#close").on('click', function() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).hide();
    });

    w3.getHttpObject("../../get/get_categorie.php", get_categoria);
    function get_categoria(risultato) {
        w3.displayObject("view_data", risultato);
    }

    function delete_record() {
        $('#auto tr').on('click', function(){
            let id_categoria = $(this).attr("value");
            $.ajax({
                url: "../../delete/delete_categoria.php?id_categoria=" + id_categoria,
                method: 'GET',
                dataType: 'html',
                success: function(risultato) {
                    alert(risultato);
                    $("#view_data").empty();
                    w3.getHttpObject("../../get/get_categorie.php", get_categoria);
                },
                error: function(error) {
                    console.log("Errore: " + error);
                }
            });
        });
    }

    function modify_record() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Modifica categoria");
        $('#auto tr').on('click', function() {
            $("#categoria").val($(this).find("td#descrizione_categoria").text());
            let id_categoria = $(this).attr("value");
            $("#val_categoria").attr("value", id_categoria);
        });
        $("#save_change").attr("value", "update");
    }

    function do_insert() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Inserisci categoria");
        $("#categoria").val("");
        $("#save_change").attr("value", "insert");
    }

    function call_action(id_action)
    {
        if(id_action == "insert")
        {
            let descrizione = $("#categoria").val();
            console.log(descrizione);        
            $.ajax({
                url: "../../insert/insert_categorie.php?descr_categoria=" + descrizione,
                method: 'GET',
                dataType: 'html',
                success: function (risultato) {
                    alert(risultato);
                    $("#view_data").empty();
                    w3.getHttpObject("../../get/get_categorie.php", get_categoria);
                    bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).hide();
                },
                error: function (error) {
                    console.log("Errore: " + error);
                }
            });
        } else if (id_action == "update")
        {
            let categoria    = $("#categoria").val();
            let id_categoria = $("#val_categoria").attr("value");
            $.ajax({
                url: "../../update/update_category.php?descrizione_categoria=" + categoria
                    + "&id_categoria="                                        + id_categoria,
                method: 'GET',
                dataType: 'html',
                success: function(risultato) {
                    alert(risultato);
                    $("#view_data").empty();
                    w3.getHttpObject("../../get/get_categorie.php", get_categoria);
                    bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).hide();
                },
                error: function(error) {
                    alert("Errore: " + error);
                }
            });
        }
    }
    
</script>