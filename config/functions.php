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

function creaTableEvent(int $col, int $row)
{
  for ($i = 0; $i < $col; $i++) {
    for ($j = 0; $j < $row; $j++) {
      $date = new DateTime("now 8am", new DateTimeZone("Europe/Paris"));
      $date->add(new DateInterval('P' . $i . 'DT' . $j . 'H'));
      $table[$i][$j] = $date->format("Y-m-d H:i");
      if ($i < 1) {
        $deb = $j+8;
        $fin = $j+9;
        $table[$i][$j] = "{$deb}:00 - {$fin}:00";
      }
      if ($j < 1) {
        
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
      echo '<td>' . $table[$col][$row] . '</td>';
    }
    echo "</tr>";
    $col = $col + 1;
  }
}
