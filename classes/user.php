<?php

class user
{
  // Propriétés

  private $id;
  private $login;
  private $password;

  //Méthodes

  public function __construct($login, $password)
  {
    $this->setLogin($login);
    $this->setPassword($password);
  }

  public function setLogin($login)
  {
    $this->login = htmlspecialchars(trim($login));
  }

  public function setPassword($password)
  {
    $this->password = htmlspecialchars(trim(password_hash($password, PASSWORD_BCRYPT)));
  }

  public function getLogin()
  {
    return $this->login;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function register()
  {
    $pdo = new PDO("mysql:host=localhost;dbname=test", "root", "");
    $requete = "SELECT * FROM utilisateurs WHERE login = :login";
    $query = $pdo->prepare($requete);
    $query->execute([
      ":login" => $this->login
    ]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    if (empty($result)) {
      $requete = "INSERT INTO utilisateurs (login, password) VALUES (:login, :password)";
      $query = $pdo->prepare($requete);
      $result = $query->execute([
        ":login" => $this->login,
        ":password" => $this->password
      ]);
      return $result;
    }
  }

  public function connect()
  {
    $pdo = new PDO("mysql:host=localhost;dbname=test", "root", "");
    $requete = "SELECT * FROM utilisateurs WHERE login = :login";
    $query = $pdo->prepare($requete);
    $query->execute([
      ":login" => $this->login
    ]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($result) && $result['password'] === $this->password) {
      foreach ($this as $propriete => $valeur) {
        $this->$propriete = $result[$propriete];
      }
      return $result;
    }
  }

  public function disconnect()
  {
    foreach ($this as $propriete => $valeur) {
      $this->$propriete = null;
    }
  }

  public function delete()
  {
    $pdo = new PDO("mysql:host=localhost;dbname=test", "root", "");
    $requete = "DELETE FROM `utilisateurs` WHERE login = :login";
    $del = $pdo->prepare($requete);
    $del->execute([
      ':login' => $this->login
    ]);
    foreach ($this as $propriete => $valeur) {
      $this->$propriete = null;
    }
  }

  public function update(
    $login,
    $password
  ) {
    $pdo = new PDO("mysql:host=localhost;dbname=classes", "root", "");
    if (!empty($login)) {
      $this->login = htmlspecialchars(trim($login));
    }
    if (!empty($password)) {
      $this->password = htmlspecialchars(trim(password_hash($password, PASSWORD_BCRYPT)));
    }
    $requete = "UPDATE `utilisateurs` SET login = :login , password = :password , email = :email ,firstname = :firstname , lastname = :lastname WHERE id = :id";
    $query = $pdo->prepare($requete);
    $query->execute([
      ':id' => $this->id,
      ':login' => $this->login,
      ':password' => $this->password
    ]);
  }
}
