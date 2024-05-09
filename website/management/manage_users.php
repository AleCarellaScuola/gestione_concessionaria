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
                        <input type="text" class="form-control" name="rif_name" id="name" placeholder="Inserisci il tuo nome">
                        <label for="name">Nome</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="rif_surname" id="surname" placeholder="Inserisci il tuo cognome">
                        <label for="surname">Cognome</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" name="rif_birth_date" id="birth_date">
                        <label for="birth_date">Data di nascita</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="rif_address" id="address" placeholder="Inserisci il tuo indirizzo..."><br>
                        <label for="address">Indirizzo</label>
                    </div>
                    <div class="form mb-3">

                        <select id="province" class="form-select">
                            <option selected>Seleziona la provincia</option>
                            <option w3-repeat="province" name="rif_province" value="{{id_provincia}}">{{nome}}, {{acronimo}}</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="rif_email" id="email" placeholder="email"><br>
                        <label for="email">E-mail</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="rif_psw" id="psw" placeholder="password"><br>
                        <label for="psw">Password</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="no_admin" checked>
                        <label class="form-check-label">
                            No
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="admin">
                        <label class="form-check-label">
                            Si
                        </label>
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
                <th>Cognome</th>
                <th>Data iscrizione</th>
                <th>Data nascita</th>
                <th>Email</th>
                <th>Indirizzo</th>
                <th>Provincia</th>
                <th>Elimina</th>
                <th>Modifica</th>
            </tr>
            <tr w3-repeat="utenti" id="val_utente" value="{{id_utente}}">
                <td>{{nome}}</td>
                <td>{{cognome}}</td>
                <td>{{data_iscrizione}}</td>
                <td>{{data_nascita}}</td>
                <td>{{email}}</td>
                <td>{{indirizzo}}</td>
                <td>{{nome_provincia}}, {{acronimo}}</td>
                <td><button type="button" id="delete" onclick="delete_record()">Elimina</button></td>
                <td><button type="button" id="modify" onclick="modify_record()">Modifica</button></td>
            </tr>
        </table>
        <button type="button" id="insert" onclick="do_insert()">Inserisci</button>
    </div>
</body>

</html>

<script>
    w3.getHttpObject("../../get/get_utenti.php", get_users);

    function get_users(risultato) {
        w3.displayObject("view_data", risultato);
    }

    function delete_record() {
        let id_utente = $("#val_utente").attr("value");

        $.ajax({
            url: "../../delete/delete_utente.php?id_utente=" + id_utente,
            method: 'GET',
            dataType: 'html',
            success: function(risultato) {
                alert(risultato);
                $("#view_data").empty();
                w3.getHttpObject("../../get/get_utenti.php", get_users);
            },
            error: function(error) {
                console.log("Errore: " + error);
            }
        });
    }

    function modify_record() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Modifica utente");
        $("#view_data").empty();
        w3.getHttpObject("../../get/get_utenti.php", get_users);
    }

    function do_insert() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Inserisci utente");
        //TODO modify modal for insert or update and then open it
        //TODO aggiustare i bottoni dei modal'
        //TODO creare le pagine php per le update
        //TODO quando l'utente deve modificare, il modal deve visualizzare i valori gia' presenti nella riga dell'utente
        //TODO insert with admin value
        
        /*let first_name = $("#name").val();
        let last_name  = $("#surname").val();
        let birth_date = $("#birth_date").val();
        let address    = $("#address").val();
        let provincia  = $("#province option:selected").val();
        let email      = $("#email").val();
        let password   = $("#psw").val();
        let admin      = $("#admin").val();
        
        $.ajax({
            url: "../../insert/insert_utenti.php?nome_utente="     + first_name
            + "&cognome_utente="                                   + last_name
            + "&data_nascita="                                     + birth_date
            + "&indirizzo_utente="                                 + address
            + "&email_utente="                                     + email
            + "&psw_utente="                                       + password
            + "&provincia_utente="                                 + provincia,
            method: 'GET',
            dataType: 'html',
            success: function (risultato) {
                alert(risultato);
                $("#view_data").empty();
                w3.getHttpObject("../../get/get_utenti.php", get_users);
            },
            error: function (error) {
                console.log("Errore: " + error);
            }
        });*/
    }
</script>