<?php

$path_index = '';
$path_config = 'config/';
$path_pages = 'pages/';
$path_classes = 'classes/';
$path_css = 'css/';


include($path_classes . 'user.php');
include($path_classes . 'event.php');

require_once($path_config . 'config.php');

if (isset($_GET["d"])) {
    $_SESSION['user']->disconnect($path_index);
}
var_dump($_SERVER);
?>

<!DOCTYPE html>
<html lang="fr" class="w-100 h-100">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="<?=$path_css?>custom.css">
</head>

<body class="w-100 h-100 d-flex flex-column justify-content-between">
  <header>
    <?php require_once($path_config . 'header.php') ?>
  </header>
  <main class="container h-50 d-flex flex-column justify-content-between">
    <?php if (isConnected() === false) : ?>
      <h1>Réservation de la salle 0101</h1>
      <h2>
        Bonjour et bienvenue sur le site de réservation de la salle 0101.
      </h2>
      <p>
        Vous pouvez consulter <strong><a href="<?=$path_pages?>planning.php">le planning</a></strong> afin de voir les différentes réservations effectuées sur la salle.
      </p>
      <p>
        Si vous souhaitez réserver la salle 0101, nous vous invitons tout d'abord à <strong><a href="<?=$path_pages?>connexion.php">vous connecter</a></strong>, puis à effectuer une(des) réservation(s) en passant par <strong><a href="<?=$path_pages?>planning.php">le planning</a></strong>.
      </p>
      <p>
        Si vous ne possédez pas encore de compte, vous pouvez <strong><a href="<?=$path_pages?>inscription.php">vous inscrire</a></strong> afin de pouvoir effectuer une(des) réservation(s).
      </p>
    <?php else : ?>
      <h1>Réservation de la salle 0101</h1>
      <h2>Bonjour <?=$_SESSION['user']->getLogin();?> et bienvenue sur le site de réservation de la salle 0101</h2>
      <p>
        Maintenant que vous êtes connecté, vous pouvez faire <strong><a href="<?=$path_pages?>reservation-form.php">une réservation</a></strong> et consulter <strong><a href="<?=$path_pages?>planning.php">le planning</a></strong>.
      </p>
      <p>
        Vous pouvez aussi consulter <strong><a href="<?=$path_pages?>profil.php">votre profil</a></strong> et modifier vos informations personnelles si vous le souhaitez.
      </p>
      <p>
        Si vous souhaitez inscrire un nouveau compte, nous vous invitons à vous <strong><a href="<?=$path_index?>index.php?d">déconnecter</a></strong> puis à vous inscrire via notre formulaire d'inscription.
      </p>
    <?php endif; ?>
  </main>
  <footer>
    <?php require_once($path_config . 'footer.php') ?>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>