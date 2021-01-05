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
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Réservation</title>
</head>

<body>
  <h1><?= $curent_event->getTitle(); ?></h1>
  <h2>Créé par <?= $curent_event->getLoginUtilisateur(); ?></h2>
  <h3>Description</h3>
  <p><?= $curent_event->getDesc(); ?></p>
  <h3>Date de début :</h3>
  <p><?= $curent_event->getDebut(); ?></p>
  <h3>Date de fin :</h3>
  <p><?= $curent_event->getFin(); ?></p>
</body>

</html>