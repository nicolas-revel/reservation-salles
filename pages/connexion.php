<?php

$path_index = '../';
$path_config = '../config/';
$path_pages = '';
$path_classes = '../classes/';

include($path_classes . 'user.php');

require_once($path_config . 'config.php');

if (!empty($_POST['login']) && !empty($_POST['password'])) {
  $curent_user = new user($_POST['login'], $_POST['password']);
  if (empty($curent_user->getErrorMessage())) {
    $_SESSION['user'] = $curent_user->connect();
  }
}

if (isset($_GET["d"])) {
  $_SESSION['user']->disconnect($path_index);
}

?>

<!DOCTYPE html>
<html lang="fr" class="w-100 h-100">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body class="w-100 h-100 d-flex flex-column justify-content-between">
  <header>
    <?php require_once($path_config . 'header.php') ?>
  </header>
  <main class="container w-50 d-flex flex-column justify-content-between">
    <?php if (isConnected() === false) : ?>
      <h1>Vous connecter</h1>
      <form action="connexion.php" method="post">
        <div class="form-group my-3">
          <label for="login">Nom d'utilisateur :</label>
          <input type="text" name="login" id="login" class="form-control" placeholder="Votre nom d'utilisateur ici" required>
        </div>
        <div class="form-group my-3">
          <label for="password">Mot de passe :</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Votre mot de passe ici" required>
        </div>
        <button type="submit" class="btn btn-secondary my-3" value="connexion">Connexion</button>
      </form>
    <?php else : ?>
      <p class="w-auto alert alert-warning d-flex justify-content-center align-items-center">
        Vous ne devriez pas vous trouver sur cette page ! Vous aller être redirigé vers la page d'accueil de notre site.
      </p>
      <?php header('refresh:3; url=' . $path_index . 'index.php'); ?>
    <?php endif; ?>
    <?php if (isset($curent_user) && !empty($curent_user->getErrorMessage())) : ?>
      <div class="alert alert-danger" role="alert">
        <strong><?= $curent_user->getErrorMessage() ?></strong>
      </div>
    <?php endif ?>
  </main>
  <footer>
    <?php require_once($path_config . 'header.php') ?>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>