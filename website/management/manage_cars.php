<?php
    require "menu.php";
    $_SESSION["active_page"] = "auto";
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
</head>

<body>
    <div id = "view_data">
        <table id = "auto" class = "table table-bordered ">
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
            <td>{{casa_produttrice}}</td>
            <td>{{nome_modello}}</td>
            <td>{{valore}}</td>
            <td>{{alimentazione}}</td>
            <td>{{descrizione}}</td>
            <td>{{prezzo}}</td>
            <td><img src = "../../vehicle_photos/{{riferimento}}" class = "mx-auto d-block img-fluid" width="150px" height="150px"></td>
            <td><button class = "btn btn-outline-danger" type = "button" id = "delete">Elimina</button></td>
            <td><button class = "btn btn-outline-secondary" type = "button" id = "modify">Modifica</button></td>
            </tr>
        </table>
        <button class = "btn btn-outline-primary" type = "button" id = "insert">Inserisci</button>
    </div>
</body>
</html>

<script>

    w3.getHttpObject("../../get/get_complete_vehicle.php", get_vehicle);

    function get_vehicle(risultato)
    {
        w3.displayObject("view_data", risultato);
    }
    //TODO prendere id del veicolo e id del modello e poi cancellare entrambi oppure capire se cancellare solo il veicolo e non il modello
    function delete_record() {
        let id_casa = $("#val_casa").attr("value");

        $.ajax({
            url: "../../delete/delete_veicolo.php?id_casa=" + id_veicolo,
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
    }

    function modify_record() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Modifica veicolo");
        $("#view_data").empty();
        w3.getHttpObject("../../get/get_complete_vehicle.php", get_vehicle);
    }

    function do_insert() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#prova-modal")).show();
        $("#action").text("Inserisci veicolo");
        //TODO modify modal for insert or update and then open it
        //TODO aggiustare i bottoni dei modal'
        //TODO creare le pagine php per le update
        //TODO quando l'utente deve modificare, il modal deve visualizzare i valori gia' presenti nella riga dell'utente
        //TODO insert with admin value
        
        //TODO per la questione dell'inserimento, l'idea e' quella di far visualizzare un primo modal per far inserire il modello,
        //se questa insert va a buon fine, allora mostrargli un secondo modal per fargli inserire il veicolo
        let name   = $("#name").val();
        let p_iva  = $("#surname").val();
        
        /*$.ajax({
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

