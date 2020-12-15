<?php

$path_index = '../';
$path_config = '../config/';
$path_pages = '';
$path_classes = '../classes/';

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
    <form action="profil.php" method="POST">
      <h4>Nom d'utilisateur : <?php ?></h4>
      <div class="form-group">
        <label for="login">Changer mon nom d'utilisateur :</label>
        <input type="text" class="form-control" name="login" id="login" placeholder="Mon nouveau nom d'utilisateur ici">
      </div>
      <div class="form-group">
        <label for="old_password">Ancien mot de passe :</label>
        <input type="text" class="form-control" name="old_password" id="old_password" placeholder="Mon ancien mot de passe">
      </div>
      <div class="form-group">
        <label for="new_password">Mon nouveau mot de passe :</label>
        <input type="text" class="form-control" name="new_password" id="new_password" placeholder="Mon nouveau mot de passe ici">
      </div>
      <div class="form-group">
        <label for="c_new_password">Confirmer mon nouveau mot de passe :</label>
        <input type="text" class="form-control" name="c_new_password" id="c_new_password" placeholder="Confirmer mon nouveau mot de passe ici">
      </div>
    </form>
  </main>
</body>

</html>