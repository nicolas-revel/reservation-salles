<?php

$path_index = '../';
$path_config = '../config/';
$path_pages = '';
$path_classes = '../classes/';

include($path_classes . 'user.php');
include($path_classes . 'event.php');

require_once($path_config . 'config.php');

if (isset($_GET['next'])) {
  $_SESSION['week']++;
  header('Location:planning.php');
}
if (isset($_GET['previous'])) {
  $_SESSION['week']--;
  header('Location:planning.php');
}

$planning = creaTableEvent(8, 13, $_SESSION['week']);

?>

<!DOCTYPE html>
<html lang="fr" class="w-100 h-100">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <title>Planning</title>
</head>

<body class="w-100 h-100 d-flex flex-column justify-content-between">
  <header>
    <?php require_once($path_config . 'header.php') ?>
  </header>
  <main>
    <?php if (isConnected() === true) : ?>
      <a class="btn btn-dark" href="<?= $path_pages ?>reservation-form.php" role="button">Faire une réservation</a>
    <?php endif; ?>
    <a class="btn btn-dark btn-sm " href="<?= $_SERVER['PHP_SELF'] ?>?previous" role="button">Semaine précédente</a>
    <a class="btn btn-dark btn-sm " href="<?= $_SERVER['PHP_SELF'] ?>?next" role="button">Semaine suivante</a>
    <table class="table">
      <?php dispTableEvent($planning); ?>
    </table>
  </main>
  <footer>
    <?php require_once($path_config . 'footer.php') ?>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>