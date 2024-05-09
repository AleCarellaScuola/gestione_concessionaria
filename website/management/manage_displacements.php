<?php
    require "menu.php";
?>
<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://w3.p2hp.com/lib/w3.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
                        <input type="number" class="form-control" name="rif_name" id="cilindrata" placeholder="Inserisci il valore della cilindrata">
                        <label for="cilindrata">Valore</label>
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
        <table id = "auto">
        <tr>
            <th>Valore</th>
            <th>Elimina</th>
            <th>Modifica</th>
            </tr>
            <tr w3-repeat="cilindrate">
            <td>{{valore}}</td>
            <td><button type = "button" id = "delete" onclick = "delete_record()">Elimina</button></td>
            <td><button type = "button" id = "modify" onclick = "modify_record()">Modifica</button></td>
            </tr>
        </table>
    </div>
    <button type = "button" id = "insert">Inserisci</button>
</body>
</html>

<script>
    w3.getHttpObject("../../get/get_cilindrate.php", get_cilindrata);

    function get_cilindrata(risultato) {
        w3.displayObject("view_data", risultato);
    }

    function delete_record() {
        let id_cilindrata = $("#val_cilindrata").attr("value");

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
    }

    function modify_record() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Modifica cilindrata");
        $("#view_data").empty();
        w3.getHttpObject("../../get/get_cilindrate.php", get_cilindrata);
    }

    function do_insert() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Inserisci cilindrata");
        //TODO modify modal for insert or update and then open it
        //TODO aggiustare i bottoni dei modal'
        //TODO creare le pagine php per le update
        //TODO quando l'utente deve modificare, il modal deve visualizzare i valori gia' presenti nella riga dell'utente
        //TODO insert with admin value
        
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
    }
</script>