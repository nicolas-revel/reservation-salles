<?php

class event
{
  // Propriétés

  private $id;
  private $title;
  private $desc;
  private $debut;
  private $fin;

  //Méthodes

  public function __construct($title, $desc, $debut, $fin)
  {
    $this->setTitle($title);
    $this->setDesc($desc);
    $this->setDebut($date_debut, $heure_debut);
    $this->setFin($fin);
  }

  public function setTitle($title)
  {
    $this->title = htmlspecialchars(trim($title));
  }

  public function setDesc($desc)
  {
    $this->desc = htmlspecialchars(trim($desc));
  }

  public function setDebut($date_debut, $heure_debut)
  {
    $datetime_debut = new DateTime();
    // $this->debut = ;
  }

  public function setFin($fin)
  {
    $this->fin = htmlspecialchars(trim($fin));
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
}
