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
    $this->setTitle($title);
    $this->setDesc($desc);
    $this->setDebut($date, $debut);
    $this->setFin($date, $fin);
    $this->setId_Utilisateur($id_utilisateur);
  }

  // Setters

  public function setId($id)
  {
    return $this->id = $id;
  }

  public function setTitle($title)
  {
    if (!empty($title)) {
      return $this->title = htmlspecialchars(trim($title));
    } else {
      return $this->errorMessage = "Merci d'indiquer un titre à votre réservation";
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
    $datetime_debut = new DateTime($date . $debut, new DateTimeZone("Europe/Paris"));
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
  }

  public function setFin($date, $fin)
  {
    $datetime_fin = new DateTime($date . $fin, new DateTimeZone("Europe/Paris"));
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

  private function checkdispoevent($date)
  {
    $date = htmlspecialchars(trim($date));
    $pdo = new PDO("mysql:host=localhost;dbname=reservationsalles", "root", "");
    $requete = "SELECT * FROM reservations WHERE :date BETWEEN debut AND fin";
    $query = $pdo->prepare($requete);
    $query->execute([
      ":date" => $date
    ]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    if (empty($result)) {
      return true;
    } else {
      return $this->errorMessage = "Ce créneau n'est pas disponible, merci d'en choisir une autre heure de début ou de fin.";
    }
  }

  private function checkdate($date)
  {
    $datetime = new DateTime($date, new DateTimeZone("Europe/Paris"));
    $datetime_actuel = new DateTime('now', new DateTimeZone("Europe/Paris"));
    $diff = ($datetime->getTimestamp()) - ($datetime_actuel->getTimestamp());
    if ($diff > 0) {
      return true;
    } else {
      $this->setErrorMessage('Merci de choisir une date ultérieure à la date du jour.');
      return false;
    }
  }

  private function checkAntePost()
  {
    $datetime_debut = new DateTime($this->getDebut(), new DateTimeZone("Europe/Paris"));
    $datetime_fin = new DateTime($this->getFin(), new DateTimeZone("Europe/Paris"));
    if ($datetime_debut->getTimestamp() >= $datetime_fin->getTimestamp()) {
      $this->setErrorMessage("Merci de choisir une heure de fin ultérieur à celle de début.");
      return false;
    } else {
      return true;
    }
  }

  public function checkConditionDate()
  {
    $this->checkdate($this->debut);
    $this->checkdate($this->fin);
    $this->checkdispoevent($this->debut);
    $this->checkdispoevent($this->fin);
    $this->checkAntePost();
  }

  public function uploadEvent()
  {
    $pdo = new PDO("mysql:host=localhost;dbname=reservationsalles", "root", "");
    $requete = "INSERT INTO reservations (titre, description, debut, fin, id_utilisateur) VALUES (:titre, :description, :debut, :fin, :id_utilisateur)";
    $query = $pdo->prepare($requete);
    $result = $query->execute([
      ":titre" => $this->title,
      ":description" => $this->desc,
      ":debut" => $this->debut,
      ":fin" => $this->fin,
      ":id_utilisateur" => $this->id_utilisateur,
    ]);
    header('Location:planning.php');
    return true;
  }

  public function recupEvent($id_event)
  {
    $pdo = new PDO("mysql:host=localhost;dbname=reservationsalles", "root", "");
    $requete = "SELECT reservations.id, titre, description, debut, fin, id_utilisateur, utilisateurs.login FROM reservations INNER JOIN utilisateurs ON utilisateurs.id = reservations.id_utilisateur WHERE reservations.id = :id";
    $query = $pdo->prepare($requete);
    $query->execute([
      ':id' => $id_event
    ]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $this->setId($result['id']);
    $this->setTitle($result['titre']);
    $this->setDesc($result['description']);
    $this->setDebut($result['debut'], null);
    $this->setFin($result['fin'], null);
    $this->setId_Utilisateur($result['id_utilisateur']);
    $this->setLogin_Utilisateur($result['login']);
    $this->setErrorMessage(null);
    if ($result !== null) {
      return $this;
    } else {
      return false;
    }
  }
}
