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

  public function setTitle($title)
  {
    $this->title = htmlspecialchars(trim($title));
  }

  public function setDesc($desc)
  {
    $this->desc = htmlspecialchars(trim($desc));
  }

  public function setDebut($debut)
  {
    $this->debut = htmlspecialchars(trim($debut));
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
