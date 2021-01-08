<?php

$path_index = '../';
$path_config = '../config/';
$path_pages = '';
$path_classes = '../classes/';

include($path_classes . 'user.php');

require_once($path_config . 'config.php');

if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['c_password'])) {
  // Vérification du mot de passe de l'utilisateur
  $new_user = new user($_POST['login'], $_POST['password']);
  if ($new_user->checkPassword($_POST['password'], $_POST['c_password'])) {
    // Si le mot de passe est bien confirmé, alors on créer un nouvel objet user
    $new_user->verifUser($_POST['login']);
    if ($new_user->getErrorMessage() === null) {
      $new_user->register();
    }
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
  <title>Inscription</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body class="w-100 h-100 d-flex flex-column justify-content-between">
  <header>
    <?php require_once($path_config . 'header.php') ?>
  </header>
  <main class="container d-flex flex-column">
    <?php if (isConnected() === false) : ?>
      <h1>Vous inscrire</h1>
      <form action="inscription.php" method="post">
        <div class="form-group">
          <label for="login">Nom d'utilisateurs :</label>
          <input type="text" class="form-control" name="login" id="login" placeholder="Créez votre nom d'utilisateur">
        </div>
        <div class="form-group">
          <label for="password">Mot de passe :</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Créez votre mot de passe">
        </div>
        <div class="form-group">
          <label for="c_password">Confirmation mot de passe :</label>
          <input type="password" class="form-control" name="c_password" id="c_password" placeholder="Confirmer votre mot de passe">
        </div>
        <button type="submit" class="btn btn-secondary" value="register">Inscription</button>
      </form>
    <?php if (isset($new_user) && !empty($new_user->getErrorMessage())) : ?>
      <div class="alert alert-danger" role="alert">
        <strong><?= $new_user->getErrorMessage() ?></strong>
      </div>
    <?php endif ?>
    <?php else : ?>
      <p class="w-auto alert alert-warning d-flex justify-content-center align-items-center">
        Pour faire une inscription, merci de vous déconnecter en premier lieu.
      </p>
      <?php header('refresh:3; url=' . $path_index . 'index.php'); ?>
    <?php endif; ?>
  </main>
  <footer>
    <?php require_once($path_config . 'footer.php') ?>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>