<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://w3.p2hp.com/lib/w3.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <p id = "user">
    </p>

    <div id = "actions">
        <select id = "get_action">
            <option>Azioni</option>
            <option id = "modifica_auto" value = "auto">Gestisci auto</option>
            <option id = "modifica_case" value = "case">Gestisci casa autombilistica</option>
            <option id = "modifica_categorie" value = "categorie">Gestisci categoria</option>
            <option id = "modifica_cilindrate" value = "cilindrate">Gestisci cilindrata</option>
            <option id = "modifica_utenti" value = "utenti">Gestisci utenti</option>
        </select>
        <br>
        <div id = choose_action>
            <button type = "button" id = "insert">Inserisci</button>
            <button type = "button" id = "delete">Elimina</button>
            <button type = "button" id = "visualize">Visualizza</button>
        </div> 
        <a id = "query" href = "do_query.php">Esegui query</a>

        <div id = "visualize_data">

        </div>
    </div>
</body>
</html>

<script>
    //TODO capire come far visualizzare i dati in base a cosa sceglie l'utente nel menu a tendina, quindi visualizzare di default e offrire la scelta di inserire, modificare o eliminare 
    // e in questi casi reinderizzare l'utente in un pagina a parte
    $(document).ready(function() {
        $("#choose_action").hide();
    });

    function visualize(path_to_file)
    {
        w3.getHttpObject(pato_to_file, get_data);
    }
    
    function get_data(risultato, id_div)
    {
        w3.displayObject(id_div, risultato);
    }

    function user_actions()
    {   
        $("#get_action").append("<option id = \"ricerca_veicolo\">Ricerca veicolo</option>");
        $("#modifica_auto").hide();
        $("#modifica_case").hide();
        $("#modifica_categorie").hide();
        $("#modifica_cilindrate").hide();
        $("#modifica_utenti").hide();
    }

    $(document).ready(function() {
        console.log($("#get_action option:selected").val());
        $("#get_action").on('change', function() {
            switch($("#get_action option:selected").val())
            {
                case "auto":
                    $("#choose_action").show();
                    break;
                case "case":
                    $("#choose_action").show();
                    break;
                case "categorie":
                    $("#choose_action").show();
                    break;
                case "cilindrate":
                    $("#choose_action").show();
                    break;
                case "utenti":
                    $("#choose_action").show();
                    break;
                default:   
                    $("#choose_action").hide();
                    break;
            }
        })
    });
</script>


<?php
    session_start();
    $name_user    = $_SESSION["name"];
    $surname_user = $_SESSION["surname"];
    $email_user   = $_SESSION["email"];
    $user_details = "<label id = 'name_surname_user'>$name_user, $surname_user</label><br>"
                    . "<label id = 'email_user'>$email_user</label>";
    echo "<script>$(\"#user\").html(\"$user_details\");</script>";

    if($_SESSION["admin_value"] == 0)
    {
        echo "<script>user_actions()</script>";
    }

?>

