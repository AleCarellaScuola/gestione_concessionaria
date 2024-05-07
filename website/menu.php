<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://w3.p2hp.com/lib/w3.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div id = "user">
        <label id = "email_user"></label>   
    </div>

    <div id = "actions">
        <select id = "get_action">
            <option>Azioni</option>
            <option id = "modify_car">Modifica auto</option>
            <option id = "modify_case">Modifica casa autombilistica</option>
            <option id = "modify_categorie">Modifica categoria</option>
            <option id = "modify_cilindrate">Modifica cilindrata</option>
            <option id = "modify_utenti">Modifica utenti</option>
            <option id = "query">Esegui query</option>
        </select>
    </div>

    <div id = "result_query">
    </div>

    <input type="email" name="rif_email" id="email" placeholder="email"><br>
    <input type="password" name="rif_psw" id="psw" placeholder="password"><br>
    <button type="button" id="registrati" name="send_data">Registrati</button>
</body>
</html>

