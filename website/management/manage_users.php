<?php
    session_start();
    if (!array_key_exists("logged_in", $_SESSION) && !$_SESSION["logged_in"]) {
        header("Location: ../log_in_page.php");
        exit(0);
    }
    
    $_SESSION["active_page"] = "utenti";
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
                    <input type = "hidden" id = "val_utente">
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
                    <div class="form-floating mb-3" id = "data_iscrizione">
                        <input type="date" class="form-control" name="rif_registration_date" id="registration_date">
                        <label for="birth_date">Data di iscrizione</label>
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
                        <input type="password" class="form-control" name="rif_password" id="psw" placeholder="password"><br>
                        <label for="psw">Password</label>
                    </div>
                    
                    <div id = "admin">
                        Admin:
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="no_admin" checked>
                            <label class="form-check-label">
                                No
                            </label>
                        </div>
                        <div class = "form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="yes_admin">
                            <label class="form-check-label">
                                Si
                            </label>
                        </div>
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
        <table id="auto" class = "table table-bordered">
            <tr>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Data iscrizione</th>
                <th>Data nascita</th>
                <th>Email</th>
                <th>Indirizzo</th>
                <th>Provincia</th>
            </tr>
            <tr w3-repeat="utenti" id="val_utente" value="{{id_utente}}">
                <td id = "user_name">{{nome}}</td>
                <td id = "surname_user">{{cognome}}</td>
                <td id = "registration_date_user">{{data_iscrizione}}</td>
                <td id = "birth_date_user">{{data_nascita}}</td>
                <td id = "email_user">{{email}}</td>
                <td id = "address_user">{{indirizzo}}</td>
                <td id = "province_user">{{nome_provincia}}, {{acronimo}}</td>
                <td><div class="px-2 py-2">
                        <button type="button" class="btn btn-outline-danger" id = "delete" onclick = "delete_record()" ><span class="material-symbols-outlined">delete</span></button>
                        <button type="button" class="btn btn-outline-secondary" id = "modify" onclick = "modify_record();"><span class="material-symbols-outlined">edit_note</span></button>
                    </div>
                </td>
            </tr>
        </table>
        <button type="button" class = "btn btn-outline-primary" id="insert" onclick="do_insert()">Inserisci</button>
    </div>
</body>

</html>

<script>

    $("#close").on('click', function() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).hide();
    });

    w3.getHttpObject("../../get/get_province.php", get_province);

    function get_province(risultato) {
        w3.displayObject("province", risultato);
    }

    w3.getHttpObject("../../get/get_utenti.php", get_users);

    function get_users(risultato) {
        w3.displayObject("view_data", risultato);
    }

    function delete_record() {
        $('#auto tr').on('click', function(){
            let id_utente = $(this).attr("value");
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
        });
    }

    function modify_record() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Modifica utente");
        $('#auto tr').on('click', function() {
            console.log($(this).find("td#user_name").text());
            $("#name").val($(this).find("td#user_name").text());
            $("#surname").val($(this).find("td#surname_user").text());
            $("#birth_date").val($(this).find("td#birth_date_user").text());
            $("#data_iscrizione").show();
            $("#registration_date").val($(this).find("td#registration_date_user").text());
            $("#address").val($(this).find("td#address_user").text());
            $("#province option:contains(" + $(this).find("td#province_user").text() + ")").attr('selected', 'selected');
            $("#email").val($(this).find("td#email_user").text());
            $("#psw").val("");
            let id_utente = $(this).attr("value");
            $("#val_utente").attr("value", id_utente);
        });
        $("#save_change").attr("value", "update");
    }

    function do_insert() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Inserisci utente");
        $("#name").val("");
        $("#surname").val("");
        $("#birth_date").val("");
        $("#data_iscrizione").hide();
        $("#address").val("");
        $("#province option:contains(Seleziona la provincia)").prop("selected", true);
        $("#email").val("");
        $("#psw").val("");
        $("#save_change").attr("value", "insert");
    }

    function call_action(id_action)
    {
        if(id_action == "insert")
        {
            let first_name = $("#name").val();
            let last_name  = $("#surname").val();
            let birth_date = $("#birth_date").val();
            let address    = $("#address").val();
            let provincia  = $("#province option:selected").val();
            let email      = $("#email").val();
            let password   = $("#psw").val();
            let admin      = $("#yes_admin").is(":checked") ? 1 : 0;
           
            $.ajax({
                url: "../../insert/insert_utenti.php?nome_utente="     + first_name
                + "&cognome_utente="                                   + last_name
                + "&data_nascita="                                     + birth_date
                + "&indirizzo_utente="                                 + address
                + "&email_utente="                                     + email
                + "&psw_utente="                                       + password
                + "&admin="                                            + admin
                + "&provincia_utente="                                 + provincia,
                method: 'GET',
                dataType: 'html',
                success: function (risultato) {
                    alert(risultato);
                    $("#view_data").empty();
                    w3.getHttpObject("../../get/get_utenti.php", get_users);
                    bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).hide();
                },
                error: function (error) {
                    console.log("Errore: " + error);
                }
            });
        } else if (id_action == "update")
        {
            let first_name = $("#name").val();
            let last_name  = $("#surname").val();
            let birth_date = $("#birth_date").val();
            let reg_date   = $("#registration_date").val();
            let address    = $("#address").val();
            let provincia  = $("#province option:selected").val();
            let email      = $("#email").val();
            let password   = $("#psw").val();
            let id_utente  = $("#val_utente").attr("value");
            let admin      = $("#yes_admin").is(":checked") ? 1 : 0;
            
            $.ajax({
                url: "../../update/update_user.php?nome_utente=" + first_name
                + "&cognome_utente="                             + last_name
                + "&data_nascita="                               + birth_date
                + "&data_iscrizione="                            + reg_date
                + "&indirizzo="                                  + address
                + "&email="                                      + email
                + "&psw="                                        + password
                + "&admin="                                      + admin
                + "&id_provincia="                               + provincia
                + "&id_utente="                                  + id_utente,
                method: 'GET',
                dataType: 'html',
                success: function (risultato) {
                    alert(risultato);
                    $("#view_data").empty();
                    w3.getHttpObject("../../get/get_utenti.php", get_users);
                    bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).hide();
                },
                error: function (error) {
                    console.log("Errore: " + error);
                }
            });
        }
    }

</script>