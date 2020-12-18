<?php

class event
{
  // Propriétés

  private $id;
  private $title;
  private $desc;
  private $debut;
  private $fin;
  private $id_utilisateur;
  private $errorMessage;

  //Méthodes

  public function __construct($title, $desc, $date_debut, $date_fin, $id_utilisateur)
  {
    $datetime_debut = new DateTime($date_debut, new DateTimeZone("Europe/Paris"));
    $datetime_fin = new DateTime($date_fin, new DateTimeZone("Europe/Paris"));
    $diff = ($datetime_fin->getTimestamp()) - ($datetime_debut->getTimestamp());
    var_dump($diff);
    if ($diff > 0) {
      $this->setTitle($title);
      $this->setDesc($desc);
      $this->setDebut($date_debut);
      $this->setFin($date_fin);
      $this->setId_Utilisateur($id_utilisateur);
    } else {
      $this->errorMessage = "Merci de choisir une date de fin ultérieur à la date de début.";
    }
  }

  public function setTitle($title)
  {
    if (!empty($title)) {
      $this->title = htmlspecialchars(trim($title));
    } else {
      $this->errorMessage = "Merci d'indiquer un titre à votre réservation";
    }
  }

  public function setDesc($desc)
  {
    if (!empty($desc)) {
      $this->desc = htmlspecialchars(trim($desc));
    } else {
      $this->errorMessage = "Merci de faire une description de votre réservation";
    }
  }

  public function setDebut($date_debut)
  {
    $datetime_debut = new DateTime($date_debut, new DateTimeZone("Europe/Paris"));
    $jour_date_debut = $datetime_debut->format("N");
    var_dump($jour_date_debut);
    if ($jour_date_debut !== '6' && $jour_date_debut !== '7') {
      $this->debut = $datetime_debut->format('Y-m-d H:i');
    } else {
      $this->errorMessage = "Merci d'indiquer un jour entre Lundi et Vendredi";
    }
  }

  public function setFin($date_fin)
  {
    $datetime_fin = new DateTime($date_fin, new DateTimeZone("Europe/Paris"));
    $jour_date_fin = $datetime_fin->format("N");
    var_dump($jour_date_fin);
    if ($jour_date_fin !== '6' && $jour_date_fin !== '7') {
      $this->fin = $datetime_fin->format('Y-m-d H:i');
    } else {
      $this->errorMessage = "Merci d'indiquer un jour entre Lundi et Vendredi";
    }
  }

  public function setId_Utilisateur($id_utilisateur)
  {
    $this->id_utilisateur = $id_utilisateur;
  }

  public function getTitle()
  {
    return $this->title;
  }

  public function getDesc()
  {
    return $this->desc;
  }

  public function getDebut()
  {
    return $this->debut;
  }

  public function getFin()
  {
    return $this->fin;
  }

  public function getErrorMessage()
  {
    return $this->errorMessage;
  }

  public function uploadEvent()
  {
    $pdo = new PDO("mysql:host=localhost;dbname=test", "root", "");
    $requete = "INSERT INTO reservations (title, description, debut, fin, id_utilisateur) VALUES (:titre, :description, :debut, :fin, :id_utilisateur)";
    $query = $pdo->prepare($requete);
    var_dump($query);
    $result = $query->execute([
      ":titre" => $this->title,
      ":description" => $this->desc,
      ":debut" => $this->debut,
      ":fin" => $this->fin,
      ":id_utilisateur" => $this->id_utilisateur,
    ]);
    var_dump($result);
  }
}
