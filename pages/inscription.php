<?php

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