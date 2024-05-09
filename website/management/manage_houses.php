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
                        <input type="text" class="form-control" name="rif_name" id="name" placeholder="Inserisci il  nome">
                        <label for="name">Nome</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="rif_surname" id="surname" placeholder="Inserisci la partita iva">
                        <label for="surname">P. Iva</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div id="view_data">
        <table id="auto">
            <tr>
                <th>Nome</th>
                <th>P.Iva</th>
                <th>Elimina</th>
                <th>Modifica</th>
            </tr>
            <tr w3-repeat="utenti" id="val_casa" value="{{id_casa}}">
                <td>{{nome}}</td>
                <td>{{p_iva}}</td>
                <td><button type="button" id="delete" onclick="delete_record()">Elimina</button></td>
                <td><button type="button" id="modify" onclick="modify_record()">Modifica</button></td>
            </tr>
        </table>
    </div>
    <button type="button" id="insert" onclick="do_insert()">Inserisci</button>
</body>

</html>

<script>
    w3.getHttpObject("../../get/get_case.php", get_case);

    function get_case(risultato) {
        w3.displayObject("view_data", risultato);
    }

    function delete_record() {
        let id_casa = $("#val_casa").attr("value");

        $.ajax({
            url: "../../delete/delete_casa.php?id_casa=" + id_casa,
            method: 'GET',
            dataType: 'html',
            success: function(risultato) {
                alert(risultato);
                $("#view_data").empty();
                w3.getHttpObject("../../get/get_case.php", get_users);
            },
            error: function(error) {
                console.log("Errore: " + error);
            }
        });
    }

    function modify_record() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Modifica casa automobilistica");
        $("#view_data").empty();
        w3.getHttpObject("../../get/get_case.php", get_users);
    }

    function do_insert() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Inserisci casa automobilistica");
        //TODO modify modal for insert or update and then open it
        //TODO aggiustare i bottoni dei modal'
        //TODO creare le pagine php per le update
        //TODO quando l'utente deve modificare, il modal deve visualizzare i valori gia' presenti nella riga dell'utente
        //TODO insert with admin value
        
        let name   = $("#name").val();
        let p_iva  = $("#surname").val();
        
        $.ajax({
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