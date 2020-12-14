<?php

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
  <main>
    <form action="reservation-form.php" method="post">
      <div class="form-group">
        <label for="title">Titre :</label>
        <input type="text" name="title" id="title" class="form-control">
      </div>
      <div class="form-group">
        <label for="description">Description :</label>
        <input type="text" name="description" id="description" class="form-control">
      </div>
      <div class="form-group">
        <label for="time_creneau">Heure :</label>
        <select class="custom-select" name="time_creneau" id="time_creneau">
          <!-- Pour ce qui est des options de sélection :
        - faire une boucle pour chaque créneau de disponible -->
        </select>
      </div>
      <div class="form-group">
        <label for="date_creneau">Date :</label>
        <input type="date" name="date_creneau" id="date_creneau" class="form-control">
      </div>
    </form>
  </main>
</body>

</html>