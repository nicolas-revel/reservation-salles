<?php

$path_index = '../';
$path_config = '../config/';
$path_pages = '';
$path_classes = '../classes/';

include($path_classes . "event.php");
include($path_classes . "user.php");

require_once($path_config . "config.php");

if (!empty($_POST)) {
  $new_event = new event($_POST["title"], $_POST['description'], $_POST['date'], $_POST['begin_time'], $_POST['end_time'], $_SESSION['user']->getId());
  $new_event->checkConditionDate();
  var_dump($new_event);
  if (empty($new_event->getErrorMessage())) {
    // Si il n'y a pas de message d'erreur, envoie l'évènement dans la BDD.
    $new_event->uploadEvent();
  }
}

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
  <header>
    <?php require_once($path_config . 'header.php') ?>
  </header>
  <main class="container">
    <?php if (isConnected() === true) : ?>
      <form action="reservation-form.php" method="post">
        <div class="form-group">
          <label for="title">Titre :</label>
          <input type="text" name="title" id="title" class="form-control" autofocus placeholder="Le titre de votre évènement ici">
        </div>
        <div class="form-group">
          <label for="description">Description :</label>
          <textarea class="form-control" name="description" id="description" rows="3" placeholder="La description de votre événement ici ..."></textarea>
        </div>
        <div class="form-group">
          <label for="date">Début de la réservation :</label>
          <input type="date" name="date" id="date" class="form-control">
        </div>
        <div class="form-group">
          <label for="begin_time">Heure de début :</label>
          <select class="form-control" name="begin_time" id="begin_time">
            <option value=""></option>
            <option value="08:00">08:00</option>
            <option value="09:00">09:00</option>
            <option value="10:00">10:00</option>
            <option value="11:00">11:00</option>
            <option value="12:00">12:00</option>
            <option value="13:00">13:00</option>
            <option value="14:00">14:00</option>
            <option value="15:00">15:00</option>
            <option value="16:00">16:00</option>
            <option value="17:00">17:00</option>
            <option value="18:00">18:00</option>
          </select>
        </div>
        <div class="form-group">
          <label for="end_time">Heure de fin :</label>
          <select class="form-control" name="end_time" id="end_time">
            <option value=""></option>
            <option value="09:00">09:00</option>
            <option value="10:00">10:00</option>
            <option value="11:00">11:00</option>
            <option value="12:00">12:00</option>
            <option value="13:00">13:00</option>
            <option value="14:00">14:00</option>
            <option value="15:00">15:00</option>
            <option value="16:00">16:00</option>
            <option value="17:00">17:00</option>
            <option value="18:00">18:00</option>
            <option value="19:00">19:00</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
      </form>
    <?php else : ?>
      <div class="alert alert-warning" role="alert">
        <strong>Vous devez être connecté pour accéder à cette page, vous aller être redirigé vers la page d'accueil.</strong>
        <?php
        header('refresh:3; url=' . $path_index . 'index.php');
        ?>
      </div>
    <?php endif; ?>
  </main>
  <footer>
    <?php require_once($path_config . 'footer.php') ?>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>