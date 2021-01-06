<?php

$path_index = '../';
$path_config = '../config/';
$path_pages = '';
$path_classes = '../classes/';

require_once($path_config . 'config.php');

include($path_classes . 'user.php');

if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['c_password'])) {
  // Vérification du mot de passe de l'utilisateur
  $check_pass = verifPassword($_POST['password'], $_POST['c_password']);
  if ($check_pass === true) {
    // Si le mot de passe est bien confirmé, alors on créer un nouvel objet user
    $new_user = new user($_POST['login'], $_POST['password']);
    $new_user->verifUser();
    if ($new_user->getErrorMessage() === null) {
      $crea_acount = $new_user->register();
    }
  }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body>
  <main>
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
  </main>
</body>

</html>