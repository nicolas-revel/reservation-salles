<?php

$path_index = '../';
$path_config = '../config/';
$path_pages = '';
$path_classes = '../classes/';

include($path_classes . 'user.php');
include($path_classes . 'event.php');

require_once($path_config . 'config.php');

$curent_event = new event();
$curent_event->recupEvent($_GET['id']);

var_dump($curent_event);
var_dump($_GET);

?>

<!DOCTYPE html>
<html lang="fr" class="w-100 h-100">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <title>Réservation</title>
</head>

<body class="w-100 h-100 d-flex flex-column justify-content-between">
  <header>
    <?php require_once($path_config . 'header.php') ?>
  </header>
  <main>
    <h1><?= $curent_event->getTitle(); ?></h1>
    <h2>Créé par <?= $curent_event->getLoginUtilisateur(); ?></h2>
    <h3>Description</h3>
    <p><?= $curent_event->getDesc(); ?></p>
    <h3>Date de début :</h3>
    <p><?= $curent_event->getDebut(); ?></p>
    <h3>Date de fin :</h3>
    <p><?= $curent_event->getFin(); ?></p>
  </main>
  <footer>
  <?php require_once($path_config . 'footer.php') ?>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>