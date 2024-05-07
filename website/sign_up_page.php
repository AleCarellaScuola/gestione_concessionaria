<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://w3.p2hp.com/lib/w3.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="form-group">
        <div class="form-floating mb-3">
            
             <label for="name">Nome</label>
            <input type="text"  class="form-control" name="rif_name" id="name" placeholder="Nome"><br>
        </div>
        <div class="form-floating mb-3">
            <label for="surname">Cognome</label>
            <input type="text" class="form-control" name="rif_surname" id="surname" placeholder="Cognome"><br>
        </div>
         <div class="form-floating mb-3">
                <label for="birth_date">Data di nascita</label><br>
                <input type="text" class="form-control" name="rif_birth_date" id="birth_date" placeholder = "Data di nascita" onclick = "this.type = 'date'">
            </div>
         <div class="form-floating mb-3">
         <label for="address">indirizzo</label><br>
            <input type="text" class="form-control" name="rif_address" id="address" placeholder = "Insereisci il tuo indirizzo..."><br>
         <select id = "province">
            <option w3-repeat = "province" name = "rif_province" value = "{{id_provincia}}">{{nome}}, {{acronimo}}</option>
        </select>
        </div>
        <br>
        <input type="email" name="rif_email" id="email" placeholder="email"><br>
        <input type="password" name="rif_psw" id="psw" placeholder="password"><br>
        </div>
        <button type="button" id="registrati" name="send_data">Registrati</button>
    </form>
</div>
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
                url: "../insert/insert_utenti.php?nome_utente="  + first_name
                     + "&cognome_utente="                        + last_name
                     + "&data_nascita="                          + birth_date
                     + "&indirizzo_utente="                      + address
                     + "&email_utente="                          + email
                     + "&psw_utente="                            + password
                     + "&provincia_utente="                      + provincia,
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
    //TODO Understand how to pass the admin value
}
?>