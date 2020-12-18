<?php

$path_index = '../';
$path_config = '../config/';
$path_pages = '';
$path_classes = '../classes/';

include($path_classes . "event.php");
include($path_classes . "user.php");

require_once($path_config . "config.php");

if (!empty($_POST)) {
  $new_event = new event($_POST["title"], $_POST['description'], $_POST['begin_creneau'], $_POST['end_creneau'], $_SESSION['user']->getId());
  var_dump($new_event);
  if(empty($new_event->getErrorMessage())){
    $new_event->uploadEvent();
  }
}

var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulaire de réservation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body>
  <main class="container">
    <form action="reservation-form.php" method="post">
      <div class="form-group">
        <label for="title">Titre :</label>
        <input type="text" name="title" id="title" class="form-control">
      </div>
      <div class="form-group">
        <label for="description">Description :</label>
        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
      </div>
      <div class="form-group">
        <label for="begin_creneau">Début de la réservation :</label>
        <input type="datetime-local" name="begin_creneau" id="begin_creneau" class="form-control">
      </div>
      <div class="form-group">
        <label for="end_creneau">Fin de la réservation :</label>
        <input type="datetime-local" name="end_creneau" id="end_creneau" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
  </main>
</body>

</html>