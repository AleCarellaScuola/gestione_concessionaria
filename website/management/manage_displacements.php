<?php
    require "../menu.php";
?>
<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://w3.p2hp.com/lib/w3.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div id = "view_data">
        <table id = "auto">
        <tr>
            <th>Valore</th>
            <th>Elimina</th>
            <th>Modifica</th>
            </tr>
            <tr w3-repeat="cilindrate">
            <td>{{valore}}</td>
            <td><button type = "button" id = "delete">Elimina</button></td>
            <td><button type = "button" id = "modify">Modifica</button></td>
            </tr>
        </table>
        <button type = "button" id = "insert">Inserisci</button>
    </div>
</body>
</html>

<script>

    w3.getHttpObject("../../get/get_cilindrate.php", get_displacements);

    function get_displacements(risultato)
    {
        w3.displayObject("data", risultato);
        console.log(risultato);
    }
</script>