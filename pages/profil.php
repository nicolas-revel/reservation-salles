<?php

$path_index = '../';
$path_config = '../config/';
$path_pages = '';
$path_classes = '../classes/';

include($path_classes . 'user.php');

require_once($path_config . 'config.php');

if (!empty($_SESSION['user'])) {
  if (isset($_POST['maj'])) {
    /* Permet de vérifier si le nouveau mdp est bien confirmé */
    $check_pass = verifPassword($_POST['new_password'], $_POST['c_new_password']);
    if (!$check_pass && password_verify($_POST['old_password'], $curent_user->getPassword())) {
      /* Dans le cas où il n'y a pas de nouveau mdp */
      $curent_user->update($_POST['login'], $_POST['new_password']);
    } elseif ($check_pass && password_verify($_POST['old_password'], $curent_user->getPassword())) {
      /* Dans le cas où il y a un nouveau mdp */
      $curent_user->update($_POST['login'], $_POST['new_password']);
    }
  }
}

if (isset($_GET["disc"])) {
  $_SESSION['user']->disconnect();
}

if (isset($_GET["del"])) {
  $_SESSION['user']->delete();
}

var_dump($_SESSION);

var_dump($_GET);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body>
  <main>
    <?php if ($_SESSION['user']->getLogin() !== null) : ?>
      <form action="profil.php" method="POST">
        <h4>Nom d'utilisateur : <?= $_SESSION['user']->getLogin(); ?></h4>
        <div class="form-group">
          <label for="login">Changer mon nom d'utilisateur :</label>
          <input type="text" class="form-control" name="login" id="login" placeholder="Mon nouveau nom d'utilisateur ici">
        </div>
        <div class="form-group">
          <label for="old_password">Ancien mot de passe :</label>
          <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Mon ancien mot de passe">
        </div>
        <div class="form-group">
          <label for="new_password">Mon nouveau mot de passe :</label>
          <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Mon nouveau mot de passe ici">
        </div>
        <div class="form-group">
          <label for="c_new_password">Confirmer mon nouveau mot de passe :</label>
          <input type="password" class="form-control" name="c_new_password" id="c_new_password" placeholder="Confirmer mon nouveau mot de passe ici">
        </div>
        <button type="submit" class="btn btn-secondary" name="maj">Mettre à jour</button>
      </form>
      <form action="profil.php" method="get">
        <button class="btn btn-danger" name="del">Supprimer mon profil</button>
        <button class="btn btn-warning" name="disc">Déconnexion</button>
      </form>
    <?php endif; ?>
  </main>
</body>

</html>