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

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body>
  <main>
    <form action="connexion.php" method="post">
      <div class="form-group">
        <label for="login">Nom d'utilisateur :</label>
        <input type="text" name="login" id="login" class="form-control" placeholder="Votre nom d'utilisateur ici" required>
      </div>
      <div class="form-group">
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Votre mot de passe ici" required>
      </div>
      <button type="submit" class="btn btn-secondary" value="connexion">Connexion</button>
    </form>
  </main>
</body>

</html>