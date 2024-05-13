<?php
    session_start();
    if (!array_key_exists("logged_in", $_SESSION) && !$_SESSION["logged_in"]) {
        header("Location: ../log_in_page.php");
        exit(0);
    }
    
    $_SESSION["active_page"] = "cilindrate";
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
                </div>
                <div class="modal-body" id="manage_user">
                    <input type = "hidden" id = "val_cilindrata">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="rif_name" id="cilindrata" placeholder="Inserisci il valore della cilindrata">
                        <label for="cilindrata">Valore</label>
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
        <table class = "table table-bordered" id = "auto">
        <tr>
            <th>Valore</th>
            <th>Elimina</th>
            <th>Modifica</th>
            </tr>
            <tr w3-repeat="cilindrate" id = "val_cilindrata" value = "{{id_cilindrata}}">
            <td id = "valore_cilindrata">{{valore}}</td>
            <td><button class = "btn btn-outline-danger" type = "button" id = "delete" onclick = "delete_record()">Elimina</button></td>
            <td><button class = "btn btn-outline-secondary" type = "button" id = "modify" onclick = "modify_record()">Modifica</button></td>
            </tr>
        </table>
    </div>
    <button class = "btn btn-outline-primary" type = "button" id = "insert" onclick = "do_insert()">Inserisci</button>
</body>
</html>

<script>
    $("#close").on('click', function() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).hide();
    });

    w3.getHttpObject("../../get/get_cilindrate.php", get_cilindrata);

    function get_cilindrata(risultato) {
        w3.displayObject("view_data", risultato);
    }

    function delete_record() {
        $('#auto tr').on('click', function(){
            let id_cilindrata = $(this).attr("value");
            $.ajax({
                url: "../../delete/delete_cilindrata.php?id_cilindrata=" + id_cilindrata,
                method: 'GET',
                dataType: 'html',
                success: function(risultato) {
                    alert(risultato);
                    $("#view_data").empty();
                    w3.getHttpObject("../../get/get_cilindrate.php", get_cilindrata);
                },
                error: function(error) {
                    console.log("Errore: " + error);
                }
            });
        });
    }       

    function modify_record() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Modifica cilindrata");
        $('#auto tr').on('click', function() {
            $("#cilindrata").val($(this).find("td#valore_cilindrata").text());
            let id_cilindrata = $(this).attr("value");
            $("#val_cilindrata").attr("value", id_cilindrata);
        });
        $("#save_change").attr("value", "update");
    }

    function do_insert() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Inserisci cilindrata");
        $("#cilindrata").val("");
        $("#save_change").attr("value", "insert");
    }

    function call_action(id_action)
    {
        if(id_action == "insert")
        {
            let valore = $("#cilindrata").val();        
            $.ajax({
                url: "../../insert/insert_cilindrate.php?val_cilindrata=" + valore,
                method: 'GET',
                dataType: 'html',
                success: function (risultato) {
                    alert(risultato);
                    $("#view_data").empty();
                    w3.getHttpObject("../../get/get_cilindrate.php", get_cilindrata);
                },
                error: function (error) {
                    console.log("Errore: " + error);
                }
            });
        } else if (id_action == "update")
        {
            let valore        = $("#cilindrata").val();
            let id_cilindrata = $("#val_cilindrata").attr("value");
            $.ajax({
                url: "../../update/update_displacement.php?valore_cilindrata=" + valore
                    + "&id_cilindrata="                                        + id_cilindrata,
                method: 'GET',
                dataType: 'html',
                success: function(risultato) {
                    alert(risultato);
                    $("#view_data").empty();
                    w3.getHttpObject("../../get/get_cilindrate.php", get_cilindrata);
                },
                error: function(error) {
                    alert("Errore: " + error);
                }
            });
        }
    }
</script>