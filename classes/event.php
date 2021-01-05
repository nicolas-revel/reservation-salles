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
  private $login_utilisateur;
  private $errorMessage;

  //Méthodes

  public function __construct($title = null, $desc = null, $date = null, $debut = null, $fin = null, $id_utilisateur = null)
  {
    if (empty($this->errorMessage)) {
      // Si il n'y a pas de message d'erreur alors créé l'objet.
      $datetime_debut = new DateTime($date . $debut, new DateTimeZone("Europe/Paris"));
      $datetime_fin = new DateTime($date . $fin, new DateTimeZone("Europe/Paris"));
      $this->setTitle($title);
      $this->setDesc($desc);
      $this->setDebut($date, $debut);
      $this->setFin($date, $fin);
      $this->setId_Utilisateur($id_utilisateur);
      if ($datetime_debut->getTimestamp() > $datetime_fin->getTimestamp()) {
        $this->errorMessage = "Merci de choisir une heure de fin ultérieur à celle de début.";
        return false;
      }
      return true;
    } else {
      return $this->errorMessage;
    }
  }

  // Setters

  public function setId($id)
  {
    $this->id = $id;
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

  public function setDebut($date, $debut)
  {
    $datetime_actuel = new DateTime('now', new DateTimeZone("Europe/Paris"));
    $datetime_debut = new DateTime($date . $debut, new DateTimeZone("Europe/Paris"));
    if ($datetime_debut->getTimestamp() > $datetime_actuel->getTimestamp()) {
      // Si la date de début est ultérieure à la date actuelle, alors continue
      $jour_date_debut = $datetime_debut->format("N");
      // Récupère le jour du DateTime
      if ($jour_date_debut !== '6' && $jour_date_debut !== '7') {
        // Si le jour et différent de Samedi et Dimanche, alors set la date de début
        $this->debut = $datetime_debut->format('Y-m-d H:i');
        return true;
      } else {
        $this->errorMessage = "Merci d'indiquer un jour entre Lundi et Vendredi";
        return false;
      }
    } else {
      $this->errorMessage = "Merci d'indiquer une date et heure de début ultérieure à la date et heure du jour";
      return false;
    }
  }

  public function setFin($date, $fin)
  {
    $datetime_actuel = new DateTime('now', new DateTimeZone("Europe/Paris"));
    $datetime_fin = new DateTime($date . $fin, new DateTimeZone("Europe/Paris"));
    if ($datetime_fin->getTimestamp() > $datetime_actuel->getTimestamp()) {
      // Si la date de fin est ultérieure à la date actuelle, alors continue
      $jour_date_fin = $datetime_fin->format("N");
      // Récupère le jour du DateTime
      if ($jour_date_fin !== '6' && $jour_date_fin !== '7') {
        // Si le jour et différent de Samedi et Dimanche, alors set la date de fin
        $this->fin = $datetime_fin->format('Y-m-d H:i');
        return true;
      } else {
        $this->errorMessage = "Merci d'indiquer un jour entre Lundi et Vendredi";
        return false;
      }
    } else {
      $this->errorMessage = "Merci d'indiquer une date et une heure de fin ultérieur à la date et heure du jour";
      return false;
    }
  }

  public function setId_Utilisateur($id_utilisateur)
  {
    return $this->id_utilisateur = $id_utilisateur;
  }

  public function setLogin_Utilisateur($login_utilisateur)
  {
    return $this->login_utilisateur = $login_utilisateur;
  }

  public function setErrorMessage($errorMessage)
  {
    return $this->errorMessage = $errorMessage;
  }

  // Getters

  public function getId()
  {
    return $this->id;
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

  public function getLoginUtilisateur()
  {
    return $this->login_utilisateur;
  }

  public function getErrorMessage()
  {
    return $this->errorMessage;
  }

  // Other fonctions

  public function uploadEvent()
  {
    $pdo = new PDO("mysql:host=localhost;dbname=test", "root", "");
    $requete = "INSERT INTO reservations (title, description, debut, fin, id_utilisateur) VALUES (:titre, :description, :debut, :fin, :id_utilisateur)";
    $query = $pdo->prepare($requete);
    $result = $query->execute([
      ":titre" => $this->title,
      ":description" => $this->desc,
      ":debut" => $this->debut,
      ":fin" => $this->fin,
      ":id_utilisateur" => $this->id_utilisateur,
    ]);
  }
}
