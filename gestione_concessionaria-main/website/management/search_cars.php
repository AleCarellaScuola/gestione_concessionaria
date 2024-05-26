<?php
    session_start();

    if (!array_key_exists("logged_in", $_SESSION) && !$_SESSION["logged_in"]) {
        header("Location: ../log_in_page.php");
        exit(0);
    }
    
    $_SESSION["active_page"] = "ricerca";
    require "menu.php";
    $name_user    = $_SESSION["name"];
    $surname_user = $_SESSION["surname"];
    $email_user   = $_SESSION["email"];
    $id_utente    = $_SESSION['user_id'];
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
</head>

<body>
    <div id="vehicle_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="action_vehicle"></h5>
                </div>
                <div class="modal-body" id="manage_vehicle">
                    <input type = "hidden" id = "val_vehicle">
                    <div class = "form-floating mb-3"> 
                        <figure class="figure">
                            <img src="..." class="figure-img img-fluid rounded" id = "get_vehicle">
                            <figcaption class="figure-caption" id = "modello_e_nome_veicolo"></figcaption>
                        </figure>
                    </div>
                    <p>
                        <label class = "form-label" id = "prezzo">Prezzo: €</label>
                        
                    </p>
                    <p>
                        <label class = "form-label" id = "cilindrata">Cilindrata: </label>
                    </p>
                    <p>
                        <label class = "form-label" id = "categoria">Categoria: </label>
                    </p>
                    <p>
                        <label class = "form-label" id = "alimentazione">Alimentazione: </label>
                    </p>
                    <p class="modal-footer">
                        <button type="button" class="btn btn-secondary" id = "close_vehicle" data-dismiss="modal" >Close</button>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="search_vehicle" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="action_vehicle">Ricerca veicolo</h5>
                </div>
                <div class="modal-body" id="manage_vehicle">
                    <p>
                        <label>Ordina per prezzo: </label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="cresc">
                            <label class="form-check-label">
                                Crescente
                            </label>
                        </div>
                        <div class = "form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="desc">
                            <label class="form-check-label">
                                Decrescente
                            </label>
                        </div>
                    </p>
                    <p>
                        <div class = "form-floating mb-3">
                            <input type="number" class="form-control"  id="min_price" placeholder = "0">
                            <label  for = "min_price">Prezzo minimo: </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control"  id="max_price" placeholder = "0">
                            <label for = "max_price">Prezzo massimo: </label>
                        </div>
                    </p>
                    <p>                        
                        <select id = "case_automobilistiche_search" class = "form-select">
                            <option value = "">Marca</option>
                            <option w3-repeat="case" value = "{{id_casa}}">{{nome}}</option>
                        </select>
                    </p>
                    <p>
                        <select id = "alimentazione_search" class = "form-select">
                            <option value = "">Alimentazione</option>
                            <option w3-repeat="alimentazioni" value = "{{id_alimentazione}}">{{nome}}</option>
                        </select>
                    </p>
                    <p>
                        <select id = "categoria_search" class = "form-select">
                            <option value = "">Categoria</option>
                            <option w3-repeat="categorie" value = "{{id_categoria}}">{{descrizione}}</option>
                        </select>
                    </p>
                    <p>
                        <select id = "cilindrata_search" class = "form-select">
                            <option value = "">Cilindrata</option>
                            <option w3-repeat="cilindrate" value = "{{id_cilindrata}}">{{valore}}</option>
                        </select>
                    </p>
                    <p class="modal-footer">
                        <button type="button" class="btn btn-primary" id = "do_search" onclick = "filter_vehicle()"data-dismiss="modal">Ricerca</button>
                        <button type="button" class="btn btn-secondary" id = "close_vehicle" data-dismiss="modal">Chiudi</button>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id = "view_data">
        <table id = "auto" class = "table table-hover">
            <tr>
                <th>Casa produttrice</th>
                <th>Nome modello</th>
                <th>Veicolo</th>
                <th hidden>Cilindrata</th>
                <th hidden>Alimentazione</th>
                <th hidden>Categoria</th>
                <th hidden>Prezzo</th>
                <th></th>
            </tr>
            <tr w3-repeat="veicoli_filtrati">
                <td id = "casa_veicolo">{{casa_produttrice}}</td>
                <td id = "rif_modello">{{nome_modello}}</td>
                <td id = "rif_veicolo" value = "{{id_veicolo}}"><img src = "..\..\vehicle_photos\{{riferimento}}" id = "photo" class = "img-fluid" width="150px" height="150px"></td>
                <td id = "cilindrata_veicolo" hidden>{{valore}}</td>
                <td id = "alimentazione_veicolo" hidden>{{alimentazione}}</td>
                <td id = "categoria_veicolo" hidden>{{descrizione}}</td>
                <td id = "prezzo_veicolo" hidden>{{prezzo}}</td>
                <td id = "see_vehicle"><button class = "btn btn-outline-info" type = "button" value = "" id = "see_more" onclick = "see_vehicle_data();">Espandi</button></td>
            </tr>
        </table>
        <button class = "btn btn-secondary mx-3 mb-3 ombra" type = "button" id = "search" onclick = "search_vehicle()">Ricerca</button>
    </div>
</body>
</html>


<script>
    w3.getHttpObject("../../get/get_filtered_vehicle.php", get_vehicle);
    function get_vehicle(risultato)
    {
        w3.displayObject("view_data", risultato);
    }
    
    w3.getHttpObject("../../get/get_alimentazioni.php", get_alimentazione);
    function get_alimentazione(risultato)
    {
        w3.displayObject("alimentazione_search", risultato);
    }
    
    w3.getHttpObject("../../get/get_categorie.php", get_categoria);
    function get_categoria(risultato)
    {
        w3.displayObject("categoria_search", risultato);
    }
    
    w3.getHttpObject("../../get/get_cilindrate.php", get_cilindrata);
    function get_cilindrata(risultato)
    {
        w3.displayObject("cilindrata_search", risultato);
    }
    
    w3.getHttpObject("../../get/get_case.php", get_marca);
    function get_marca(risultato)
    {
        w3.displayObject("case_automobilistiche_search", risultato);
    } 
    
    function see_vehicle_data()
    {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#vehicle_modal")).show();
        $("#action_vehicle").text("Dati veicolo");
        let id_veicolo = $('#auto tr').on('click', function() {
            $("#get_vehicle").attr("src", $(this).find("img#photo").attr("src"));
            $("#modello_e_nome_veicolo").text($(this).find("td#casa_veicolo").text() + ", "+ $(this).find("td#rif_modello").text());
            $("#prezzo").text("Prezzo: €" + $(this).find("td#prezzo_veicolo").text());
            $("#cilindrata").text("Cilindrata: " + $(this).find("td#cilindrata_veicolo").text());
            $("#categoria").text("Categoria: " + $(this).find("td#categoria_veicolo").text());
            $("#alimentazione").text("Alimentazione: " + $(this).find("td#alimentazione_veicolo").text());
            let id_veicolo = $(this).find("td#rif_veicolo").attr("value");
            $("#val_vehicle").attr("value", id_veicolo);
        });
        
        
    }
    $("#vehicle_modal").on("hide.bs.modal", function() {
        insert_visit();
    })
    
    $("#close_vehicle").on('click', function() {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#vehicle_modal")).hide();
     });

    function search_vehicle()
    {
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#search_vehicle")).show();
    }

    function insert_visit()
    {
        let id_veicolo  = $("#val_vehicle").attr("value"); 
        let id_utente   = "<?php echo $_SESSION["user_id"]?>"
        let cur_date    = new Date();
        let cur_year    = cur_date.getFullYear();
        let cur_month   = cur_date.getMonth() + 1;
        let cur_day     = cur_date.getDate();
        let data_visita = cur_year + "-" + cur_month + "-" + cur_day;

        $.ajax({
                url: "../../insert/insert_visite.php?rif_veicolo=" + id_veicolo
                + "&rif_utente="                                   + id_utente
                + "&data_visita="                                  + data_visita,
                method: 'GET',
                dataType: 'html'
        }); 
    }

    function filter_vehicle()
    {
        let order_condition = "";
        if($("#cresc").is(":checked")) {
            order_condition = $("#cresc").attr("id");
        } else if($("#desc").is(":checked"))
        {
            order_condition = $("#desc").attr("id");
        } else
            order_condition = null;

        console.log(order_condition);
        let price_condition_min = $("#min_price").val();
        let price_condition_max = $("#max_price").val();
        let marca_condition = $("#case_automobilistiche_search :selected").attr("value");
        let alimentazione_condition = $("#alimentazione_search :selected").attr("value");
        let displacement_condition = $("#cilindrata_search :selected").attr("value");
        let category_condition = $("#categoria_search :selected").attr("value");
        
        console.log(marca_condition);
        
        $("#view_data").empty();
        w3.getHttpObject("../../get/get_filtered_vehicle.php?min_prezzo=" + price_condition_min
                        + "&max_prezzo="                                  + price_condition_max
                        + "&marca_condition="                             + marca_condition
                        + "&alimentazione_condition="                     + alimentazione_condition
                        + "&displacement_condition="                      + displacement_condition
                        + "&category_condition="                          + category_condition
                        + "&order_condition="                             + order_condition, 
                        get_vehicle);
        bootstrap.Modal.getOrCreateInstance(document.querySelector("#search_vehicle")).hide();

    }

</script>
