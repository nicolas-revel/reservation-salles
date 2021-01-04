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
  $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
  $requete = 'SELECT * FROM reservations ORDER BY debut ASC';
  $query = $pdo->query($requete);
  $result = $query->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $events => $proprietes) {
    $event = new event();
    $event->setId($result[$events]['id']);
    $event->setTitle($result[$events]['title']);
    $event->setDesc($result[$events]['description']);
    $event->setDebut($result[$events]['debut'], null);
    $event->setFin($result[$events]['fin'], null);
    $event->setId_Utilisateur($result[$events]['id_utilisateur']);
    $event->setErrorMessage(null);
    $result[$events] = $event;
  }
  return $result;
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

function creaTableEvent(int $col, int $row)
{
  for ($i = 0; $i < $col; $i++) {
    for ($j = 0; $j < $row; $j++) {
      $date = new DateTime("yesterday 8am", new DateTimeZone("Europe/Paris"));
      $date->add(new DateInterval('P' . $i . 'DT' . $j . 'H'));
      if ($date->format('N') == 6 || $date->format('N') == 7) {
        $table[$i][$j] = 'Indisponible';
      } else {
        $table[$i][$j] = $date->format("Y-m-d H:i");
      }
      if ($i < 1) {
        $deb = $j + 7;
        $fin = $j + 8;
        $table[$i][$j] = "{$deb}:00 - {$fin}:00";
      }
      if ($j < 1) {
        if ($i < 1) {
          $table[$i][$j] = 'Créneaux / Jours';
        } else {
          $m = $i - 1;
          $jour = new DateTime("now 8am", new DateTimeZone("Europe/Paris"));
          $jour->add(new DateInterval('P' . $m . 'D'));
          $jsemaine = displayDay($jour->format('N'));
          $mois = displayMonth($jour->format('m'));
          var_dump($jsemaine);
          $table[$i][$j] = "$jsemaine " . $jour->format("d") . " $mois";
        }
      }
    }
  }
  $events = recupAllEvent();
  foreach ($table as $row => $value) {
    foreach ($table[$row] as $col => $value) {
      foreach ($events as $event => $value) {
        if ($table[$row][$col] === $events[$event]->getDebut()) {
          $start = true;
          $reserved = true;
          break;
        } elseif ($table[$row][$col] === $events[$event]->getFin()) {
          $end = true;
          $start = null;
          $reserved = null;
          break;
        } else {
          $start = null;
          $end = null;
          $table[$row][$col] = $table[$row][$col];
        }
      }
      if (!empty($start)) {
        $table[$row][$col] = "Commence";
      } elseif (!empty($reserved)) {
        $table[$row][$col] = "Réservé";
      } elseif (!empty($end)) {
        $table[$row][$col] = "Fini";
      } else {
        $table[$row][$col] = $table[$row][$col];
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
      if ($col == 0 || $row == 0) {
        echo '<th>' . $table[$col][$row] . '</th>';
      } else {
        echo '<td>' . $table[$col][$row] . '</td>';
      }
    }
    echo "</tr>";
    $col = $col + 1;
  }
}
