<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://w3.p2hp.com/lib/w3.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link rel="stylesheet" href="sign_up_style.css" type="text/css">


</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid justify-content-center">
            <a class="navbar-brand" href="#">Concessionaria AutoMondo
                <span class="material-symbols-outlined">car_tag</span>
            </a>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-light ">
        <div class="container-fluid">
    </nav>

    <div class="signup mx-auto">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="riquadro d-flex justify-content-center">
                <div class="form-group">
                    <h3 style="color:white;">Sign-Up</h3>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="rif_name" id="name" placeholder="Inserisci il tuo nome">
                                <label for="name">Nome</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="rif_surname" id="surname" placeholder="Inserisci il tuo cognome">
                                <label for="surname">Cognome</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" name="rif_birth_date" id="birth_date">
                        <label for="birth_date">Data di nascita</label>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">

                                <input type="text" class="form-control" name="rif_address" id="address" placeholder="Inserisci il tuo indirizzo..."><br>
                                <label for="address">Indirizzo</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select id="province" class="form-select">
                                    <option selected></option>
                                    <option w3-repeat="province" name="rif_province" value="{{id_provincia}}">{{nome}}, {{acronimo}}</option>
                                </select>
                                <label for="provincia">Selezione provincia</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="rif_email" id="email" placeholder="email"><br>
                        <label for="email">E-mail</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="rif_psw" id="psw" placeholder="password"><br>
                        <label for="psw">Password</label>
                    </div>
                    <button type="button" class="btn btn-light" id="registrati" name="send_data">Registrati</button>
                </div>
            </div>
        </form>
    </div>
</body>

<script>
    w3.getHttpObject("../get/get_province.php", get_province);

    function get_province(risultato) {
        w3.displayObject("province", risultato);
    }

    $(document).ready(function() {
        $("#registrati").click(function() {
            let first_name = $("#name").val();
            let last_name  = $("#surname").val();
            let birth_date = $("#birth_date").val();
            let address    = $("#address").val();
            let provincia  = $("#province option:selected").val();
            let email      = $("#email").val();
            let password   = $("#psw").val();

            $.ajax({
                url: "../insert/insert_utenti.php?nome_utente=" + first_name +
                    "&cognome_utente="                          + last_name +
                    "&data_nascita="                            + birth_date +
                    "&indirizzo_utente="                        + address +
                    "&email_utente="                            + email +
                    "&psw_utente="                              + password +
                    "&provincia_utente="                        + provincia,
                method: 'GET',
                dataType: 'html',
                success: function(risultato) {
                    alert(risultato);
                    window.location.href = "log_in_page.php";
                },
                error: function(error) {
                    console.log("Errore: " + error);
                }
            });
        });
    });
</script>

</html>

<?php
//TODO check input
if (isset($_POST["send_data"])) {
    session_start();
    $_SESSION["admin_value"] = 0;
    $_SESSION["name"]        = $_POST["rif_name"];
    $_SESSION["surname"]     = $_POST["rif_surname"];
    $_SESSION["email"]       = $_POST["rif_email"];
    $_SESSION["logged_in"]   = true;
    $_SESSION["active_page"] = "";
}
?>