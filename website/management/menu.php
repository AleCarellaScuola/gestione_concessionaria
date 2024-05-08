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
        <label>Azioni</label>
        <br>
        <a href = "manage_cars.php" id = "gestisci_auto">Gestisci auto</a>
        <br>
        <a href = "manage_houses.php" id = "gestisci_case">Gestisci case automobilistiche</a>
        <br>
        <a href = "manage_categories.php" id = "gestisci_categorie">Gestisci categorie</a>
        <br>
        <a href = "manage_displacements.php" id = "gestisci_cilindrate">Gestisci cilindrate</a>
        <br>
        <a href = "manage_users.php" id = "gestisci_utenti">Gestisci utenti</a>
        <br>
        <a id = "query" href = "do_query.php">Esegui query</a>
    </div>
</body>
</html>

<script>
    function user_actions()
    {   
        $("#gestisci_auto").remove();
        $("#gestisci_case").remove();
        $("#gestisci_categorie").remove();
        $("#gestisci_cilindrate").remove();
        $("#gestisci_utenti").remove();
        $("#actions").append("<a href = \"management/search_cars.php\" id = \"ricerca_veicolo\">Ricerca veicolo</a>");
    }
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
