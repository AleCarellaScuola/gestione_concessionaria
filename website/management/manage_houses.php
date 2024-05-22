<?php
    session_start();
    if (!array_key_exists("logged_in", $_SESSION) && !$_SESSION["logged_in"]) {
        header("Location: ../log_in_page.php");
        exit(0);
    }
    
    $_SESSION["active_page"] = "case";
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
                    <input type = "hidden" id = "val_casa">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="rif_name" id="name" placeholder="Inserisci il  nome">
                        <label for="name">Nome</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="rif_surname" id="p_iva" placeholder="Inserisci la partita iva">
                        <label for="surname">P. Iva</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id = "save_change" onclick = "call_action(this.value)">Save changes</button>
                    <button type="button" class="btn btn-secondary" id = "close" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div id="view_data">
        <table class = "table table-bordered" id="auto">
            <tr>
                <th>Nome</th>
                <th>P.Iva</th>
            </tr>
            <tr w3-repeat="case" id="val_casa" value="{{id_casa}}">
                <td id = "nome_casa">{{nome}}</td>
                <td id = "p_iva_casa">{{p_iva}}</td>
                <td><div class="px-2 py-2">
                        <button type="button" class="btn btn-outline-danger" id = "delete" onclick = "delete_record()" ><span class="material-symbols-outlined">delete</span></button>
                        <button type="button" class="btn btn-outline-secondary" id = "modify" onclick = "modify_record();"><span class="material-symbols-outlined">edit_note</span></button>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <button type="button" class = "btn btn-outline-primary" id="insert" onclick="do_insert()">Inserisci</button>
</body>

</html>

<script>
    $("#close").on('click', function() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).hide();
    });

    w3.getHttpObject("../../get/get_case.php", get_case);

    function get_case(risultato) {
        w3.displayObject("view_data", risultato);
    }

    function delete_record() {
        $('#auto tr').on('click', function(){
            let id_casa = $(this).attr("value");
            $.ajax({
                url: "../../delete/delete_casa.php?id_casa=" + id_casa,
                method: 'GET',
                dataType: 'html',
                success: function(risultato) {
                    alert(risultato);
                    $("#view_data").empty();
                    w3.getHttpObject("../../get/get_case.php", get_case);
                    return;
                },
                error: function(error) {
                    console.log("Errore: " + error);
                    return;
                }
            });
        });
        
    }

    function modify_record() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Modifica casa automobilistica");
        $('#auto tr').on('click', function() {
            $("#name").val($(this).find("td#nome_casa").text());
            $("#p_iva").val($(this).find("td#p_iva_casa").text());
            let id_casa = $(this).attr("value");
            $("#val_casa").attr("value", id_casa);
        });
        $("#save_change").attr("value", "update");
    }

    function do_insert() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#name").val("");
        $("#p_iva").val("");
        $("#action").text("Inserisci casa automobilistica");
        $("#save_change").attr("value", "insert");
    }

    function call_action(id_action) 
    {  
        if(id_action == "insert")
        {
            let name   = $("#name").val();
            let p_iva  = $("#p_iva").val();
            $.ajax({
                url: "../../insert/insert_case.php?nome_casa="     + name
                + "&p_iva="                                        + p_iva,
                method: 'GET',
                dataType: 'html',
                success: function (risultato) {
                    alert(risultato);
                    $("#view_data").empty();
                    w3.getHttpObject("../../get/get_case.php", get_case);
                    bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).hide();
                    return;
                },
                error: function (error) {
                    console.log("Errore: " + error);
                    return;
                }
            });
        } else if (id_action == "update")
        {
            let nome_casa = $("#name").val();
            let p_iva     = $("#p_iva").val();
            let id_casa   = $("#val_casa").attr("value");
            console.log(id_casa);
            $.ajax({
                url: "../../update/update_house.php?nome_casa=" + nome_casa
                    + "&p_iva_casa="                            + p_iva
                    + "&id_casa="                               + id_casa,
                method: 'GET',
                dataType: 'html',
                success: function(risultato) {
                    alert(risultato);
                    $("#view_data").empty();
                    w3.getHttpObject("../../get/get_case.php", get_case);
                    bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).hide();
                },
                error: function(error) {
                    alert("Errore: " + error);
                }
            });
        }
    }
</script>