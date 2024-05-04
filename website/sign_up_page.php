<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://w3.p2hp.com/lib/w3.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="text" name="rif_name" id="name" placeholder="Nome"><br>
        <input type="text" name="rif_surname" id="surname" placeholder="Cognome"><br>
        <input type="date" name="rif_birth_date" id="birth_date">: Data di nascita<br>
        <input type="text" name="rif_address" id="address" placeholder = "Indirizzo"><br>
        <select id = "province">
            <option w3-repeat = "province" name = "rif_province" value = "{{id_provincia}}">{{nome}}, {{acronimo}}</option>
        </select>
        <br>
        <input type="email" name="rif_email" id="email" placeholder="email"><br>
        <input type="password" name="rif_psw" id="psw" placeholder="password"><br>
        <button type="button" id="registrati" name="send_data">Registrati</button>
    </form>
</body>

<script>
    w3.getHttpObject("../get/get_province.php", get_province);

    function get_province(risultato)
    {
        w3.displayObject("province", risultato);
    }

    $(document).ready(function () {
        $("#registrati").click(function () {
            let first_name = $("#name").val();
            let last_name  = $("#surname").val();
            let birth_date = $("#birth_date").val();
            let address    = $("#address").val();
            let provincia  = $("#province option:selected").val();
            let email      = $("#email").val();
            let password   = $("#psw").val();
            
            $.ajax({
                url: "insert_utenti.php?nome_utente=" + first_name
                     + "cognome_utente="              + last_name
                     + "data_nascita="                + birth_date
                     + "indirizzo_utente="            + address
                     + "email_utente="                + email
                     + "psw_utente="                  + password
                     + "provincia_utente="            + provincia,
                method: 'GET',
                dataType: 'html',
                success: function (risultato) {
                    alert(risultato);
                },
                error: function (error) {
                    console.log("Errore: " + error);
                }
            });
        });
    });
</script>

</html>

<?php
if(isset($_POST["send_data"]))
{
    //TODO start session e reidirizzamento alla pagina menu con i rispettivi cookie se e' admin o meno
}
?>