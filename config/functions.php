<?php

function verifPassword($password, $c_password)
{
  if (!empty($password) && !empty($c_password)) {
    if ($password === $c_password) {
      return true;
    } else {
      return false;
    }
  }
}

function recupAllEvent()
{
  $pdo = new PDO('mysql:host=localhost;dbname=reservationsalles', 'root', '');
  $requete = 'SELECT reservations.id, titre, description, debut, fin, id_utilisateur, utilisateurs.login FROM reservations INNER JOIN utilisateurs ON utilisateurs.id = reservations.id_utilisateur ORDER BY debut ASC';
  $query = $pdo->query($requete);
  $result = $query->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $events => $properties) {
    $event = new event();
    $event->setId($result[$events]['id']);
    $event->setTitle($result[$events]['titre']);
    $event->setDesc($result[$events]['description']);
    $event->setDebut($result[$events]['debut'], null);
    $event->setFin($result[$events]['fin'], null);
    $event->setId_Utilisateur($result[$events]['id_utilisateur']);
    $event->setLogin_Utilisateur($result[$events]['login']);
    $event->setErrorMessage(null);
    $result[$events] = $event;
  }if ($result !== null) {
    return $result;
  } else {
    return false;
  }
}

function displayDay($day)
{
  switch ($day) {
    case '1':
      return 'Lundi';
    case '2':
      return 'Mardi';
    case '3':
      return 'Mercredi';
    case '4':
      return 'Jeudi';
    case '5':
      return 'Vendredi';
    case '6':
      return 'Samedi';
    case '7':
      return 'Dimanche';
  }
}

function displayMonth($month)
{
  switch ($month) {
    case '01':
      return 'Janvier';
    case '02':
      return 'Février';
    case '03':
      return 'Mars';
    case '04':
      return 'Avril';
    case '05':
      return 'Mai';
    case '06':
      return 'Juin';
    case '07':
      return 'Juillet';
    case '08':
      return 'Aout';
    case '09':
      return 'Septembre';
    case '10':
      return 'Octobre';
    case '11':
      return 'Novembre';
    case '12':
      return 'Décembre';
  }
}

function creaTableEvent(int $col, int $row, int $week)
{
  for ($i = 0; $i < $col; $i++) {
    for ($j = 0; $j < $row; $j++) {
      // Pour chaque case du tableau, créer un objet datetime que dont tu incrémente le jour et l'heure respectivement en fonction de $i et $j;
      $date = new DateTime("last sunday 7am $week week", new DateTimeZone("Europe/Paris"));
      $date->add(new DateInterval('P' . $i . 'DT' . $j . 'H'));
      if ($date->format('N') == 6 || $date->format('N') == 7) {
        // Si c'est un Samedi ou un Dimanche, la case vaut "Indisponible";
        $table[$i][$j] = "<td class = 'undisp'>Indisponible</td>";
      } else {
        // Sinon la case prend la valeur de la date générée précédemment;
        $table[$i][$j] = $date->format("Y-m-d H:i");
      }
      if ($i < 1) {
        // Si $i < 1 cela veut dire que nous sommes dans la première colonne et chaque case prend la valeur du créneau associé;
        $horraire = $j + 7;
        $table[$i][$j] = "<th class='table-dark' scope='row'>{$horraire}:00</th>";
      }
      if ($j < 1) {
        // Si $j < 1 cela veut dire que nous sommes dans la première ligne et chaque case prend la valeur du jour associé;
        if ($i < 1) {
          // Si première case de première ligne, affiche;
          $table[$i][$j] = "<th class='table-dark'>Créneaux / Jours</th>";
        } else {
          // Si autre que première case, case = Jour de la semaine Numéro du jour Mois;
          $m = $i - 1;
          $jour = new DateTime("this week 7am $week week", new DateTimeZone("Europe/Paris"));
          $jour->add(new DateInterval('P' . $m . 'D'));
          $jsemaine = displayDay($jour->format('N'));
          $mois = displayMonth($jour->format('m'));
          $table[$i][$j] = "<th class='table-dark' scope='col'>$jsemaine " . $jour->format("d") . " $mois</th>";
        }
      }
    }
  }
  $events = recupAllEvent();
  foreach ($table as $row => $value) {
    foreach ($table[$row] as $col => $value) {
      foreach ($events as $event => $value) {
        if ($table[$row][$col] === $events[$event]->getDebut()) {
          // Si la case correspond au début de l'évènement, alors active start et reserved, sort de la boucle
          $content = "<a href='reservation.php?id={$events[$event]->getId()}'>{$events[$event]->getTitle()}</a><p class ='desc'>{$events[$event]->getDesc()}</p><p class='person'>Evènement organisé par {$events[$event]->getLoginUtilisateur()}</p>";
          $start = true;
          $reserved = true;
          break;
        } elseif ($table[$row][$col] === $events[$event]->getFin()) {
          // Si la case correspond à la fin de l'évènement, alors active end et déactive start et reserved, sort de la boucle
          $end = true;
          $start = null;
          $reserved = null;
          break;
        } else {
          // Sinon, remets tout à null sauf reserved car il reste actif tant qu'il ne rencontre pas de fin
          $content = "<p class='para-reserved'>Réservé par {$events[$event]->getLoginUtilisateur()}</p>";
          $start = null;
          $end = null;
          $table[$row][$col] = $table[$row][$col];
        }
      }
      if (!empty($start)) {
        $table[$row][$col] = "<td class = 'table-success'>$content</td>";
      } elseif (!empty($reserved)) {
        $table[$row][$col] = "<td class = 'table-secondary'>$content</td>";
      } elseif (!empty($end)) {
        $table[$row][$col] = "<td class = 'table-dark'>Fini</td>";
      } else {
        if ($row != 0 && $col != 0 && $table[$row][$col] !== "<td class = 'undisp'>Indisponible</td>") {
          $table[$row][$col] = "<td class = 'table-light'><p>Disponible</p></td>";
        }
      }
    }
  }
  return $table;
}

function dispTableEvent(array $table)
{
  $col = 0;
  foreach ($table[$col] as $row => $value) {
    echo "<tr>";
    foreach ($table as $col => $value) {
      echo $table[$col][$row];
    }
    echo "</tr>";
    $col = $col + 1;
  }
}

function isConnected()
{
  if (empty($_SESSION['user']) || $_SESSION['user']->getLogin() === null) {
    return false;
  } else {
    return true;
  }
}