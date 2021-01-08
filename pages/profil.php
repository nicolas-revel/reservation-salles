<?php

$path_index = '../';
$path_config = '../config/';
$path_pages = '';
$path_classes = '../classes/';

include($path_classes . 'user.php');

require_once($path_config . 'config.php');

$curent_user = $_SESSION['user'];

if (!empty($_SESSION['user'])) {
  if (isset($_POST['maj'])) {
    // Verification du mot de passe utilisateur
    $curent_user->verifPassword($_POST['old_password']);
    if (!empty($_POST['login'])) {
      // Checker si le login est pas déjà existant
      $curent_user->verifUser($_POST['login']);
    }
    if (!empty($_POST['new_password'])) {
      // Vérifie si le nouveau mot de passe est bien confirmé
      $curent_user->checkPassword($_POST['new_password'], $_POST['c_new_password']);
    }
    if (empty($curent_user->getErrorMessage())) {
      $curent_user->update($_POST['login'], $_POST['new_password']);
    }
  }
}

if (isset($_GET["d"])) {
  $_SESSION['user']->disconnect($path_index);
}

if (isset($_GET["del"])) {
  $_SESSION['user']->delete($path_index);
}

?>

<!DOCTYPE html>
<html lang="fr" class="w-100 h-100">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body class="w-100 h-100 d-flex flex-column justify-content-between">
  <header>
    <?php require_once($path_config . 'header.php') ?>
  </header>
  <main class="container w-75">
    <?php if (isConnected() === true) : ?>
      <h1 class="my-3">Votre profil</h1>
      <form action="profil.php" method="POST">
        <h4>Nom d'utilisateur : <?= $_SESSION['user']->getLogin(); ?></h4>
        <div class="form-group my-3">
          <label for="login">Changer mon nom d'utilisateur :</label>
          <input type="text" class="form-control" name="login" id="login" placeholder="Mon nouveau nom d'utilisateur ici">
        </div>
        <div class="form-group my-3">
          <label for="old_password">Ancien mot de passe :</label>
          <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Mon ancien mot de passe">
        </div>
        <div class="form-group my-3">
          <label for="new_password">Mon nouveau mot de passe :</label>
          <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Mon nouveau mot de passe ici">
        </div>
        <div class="form-group my-3">
          <label for="c_new_password">Confirmer mon nouveau mot de passe :</label>
          <input type="password" class="form-control" name="c_new_password" id="c_new_password" placeholder="Confirmer mon nouveau mot de passe ici">
        </div>
        <button type="submit" class="btn btn-secondary" name="maj">Mettre à jour</button>
      </form>
      <a href="<?= $_SERVER['PHP_SELF'] . '?d' ?>"><button class="btn btn-secondary btn-outline-warning m-4">Déconnexion</button></a>
      <a href="<?= $_SERVER['PHP_SELF'] . '?del' ?>"><button class="btn btn-secondary btn-outline-danger ">Supprimer mon profil</button></a>
      <?php if (isset($new_user) && !empty($new_user->getErrorMessage())) : ?>
        <div class="alert alert-danger w-auto m-3" role="alert">
          <strong><?= $new_user->getErrorMessage() ?></strong>
        </div>
      <?php endif ?>
    <?php else : ?>
      <p class="w-auto alert alert-warning d-flex justify-content-center align-items-center">
        Vous ne devriez pas vous trouver sur cette page ! Vous aller être redirigé vers la page d'accueil de notre site.
      </p>
      <?php
      header('refresh:3; url=' . $path_index . 'index.php');
      die; ?>
    <?php endif; ?>
  </main>
  <footer>
    <?php require_once($path_config . 'footer.php') ?>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>