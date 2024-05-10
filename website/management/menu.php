<?php

  session_start();
  if (!array_key_exists("logged_in", $_SESSION) && !$_SESSION["logged_in"]) {
    header("Location: ../log_in_page.php");
    exit(0);
  }
  function page($page_id, $page_name, $url_page)
  {
    if ($_SESSION["active_page"] === $page_id) {
      echo "<li class = \"nav-item\"><a style = \"color: white;\"class=\"nav-link active\" aria-current=\"page\" href=\"$url_page\">$page_name</a></li>";
    } else {
      echo "<li class=\"nav-item\"><a style = \"color: white;\"class=\"nav-link\" href=\"$url_page\">$page_name</a></li>";
    }
  }
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
  <!--link icone google apis-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">


    <ul class="nav navbar-nav mx-3" style="display:block;">
      <li class="nav-item userData">
        <span class="material-symbols-outlined">account_circle</span>
        <div class="row">
          <div id="name_user"></div>
          <div id="email_user"></div>
        </div>
      </li>
    </ul>


    <div class="container-fluid justify-content-center">
      <a class="navbar-brand" href="#">Concessionaria AutoMondo
        <span class="material-symbols-outlined">car_tag</span>
      </a>
    </div>


    <ul class="nav navbar-nav navbar-right mx-3">
      <a href="#" data-toggle="modal" data-target="#logoutModal">
        <button type="button" class="btn btn-outline-secondary btn-sm">Logout
          <span class="material-symbols-outlined">logout</span>
        </button>

      </a>
    </ul>

  </nav>
  <nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container-fluid">


      <ul class="navbar-nav" id="actions">
        <?php
        if ($_SESSION["admin_value"] == 0)
          page("ricerca", "Ricerca veicolo", "search_cars.php");
        else {
          page("auto", "Gestisci auto", "manage_cars.php");
          page("categorie", "Gestisci categorie", "manage_categories.php");
          page("cilindrate", "Gestisci cilindrate", "manage_displacements.php");
          page("case", "Gestisci case", "manage_houses.php");
          page("utenti", "Gestisci utenti", "manage_users.php");
        }
        ?>
      </ul>

  </nav>
</body>

</html>

<?php
  $name_user    = $_SESSION["name"];
  $surname_user = $_SESSION["surname"];
  $email_user   = $_SESSION["email"];

  echo "<script>$(\"#name_user\").text(\"$name_user, $surname_user\");"
    . "$(\"#email_user\").text(\"$email_user\")</script>";
?>