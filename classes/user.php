<?php

class user
{
  // Propriétés

  private $id;
  private $login;
  private $password;
  private $errorMessage;

  //Méthodes

  public function __construct($login = null, $password = null)
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
    $this->password = htmlspecialchars(trim($password));
  }

  public function getLogin()
  {
    return $this->login;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getErrorMessage()
  {
    return $this->errorMessage;
  }

  private function verifUser($login)
  {
    // Permet de vérifier si l'utilisateur existe déjà
    $pdo = new PDO("mysql:host=localhost;dbname=test", "root", "");
    $requete = "SELECT * FROM utilisateurs WHERE login = :login";
    $query = $pdo->prepare($requete);
    $query->execute([
      ":login" => $login
    ]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    if (empty($result)) {
      // Si aucun utilisateur ne correspond, alors la fonction renvoie true
      return true;
    } else {
      return false;
    }
  }

  public function register()
  {
    $pdo = new PDO("mysql:host=localhost;dbname=test", "root", "");
    $requete = "INSERT INTO utilisateurs (login, password) VALUES (:login, :password)";
    $query = $pdo->prepare($requete);
    $result = $query->execute([
      ":login" => $this->login,
      ":password" => password_hash($this->password, PASSWORD_BCRYPT)
    ]);
    return $result;
  }

  public function connect()
  {
    $pdo = new PDO("mysql:host=localhost;dbname=test", "root", "");
    $requete = "SELECT * FROM utilisateurs WHERE login = :login";
    $query = $pdo->prepare($requete);
    $query->execute([
      ":login" => $this->login
    ]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if ($result !== false && password_verify($this->password, $result['password'])) {
      $this->id = $result['id'];
      $this->login = $result['login'];
      $this->password = $result['password'];
      return $this;
    } else {
      "entre else";
      $this->errorMessage = "Le nom d'utilisateur ou le mot de passe est incorrect.";
      return false;
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

  public function update($login, $password)
  {
    $login = htmlspecialchars(trim($login));
    $password = htmlspecialchars(trim(password_verify($password, PASSWORD_BCRYPT)));
    $checkuser = $this->verifUser($login);
    if ($checkuser === true) {
      $pdo = new PDO("mysql:host=localhost;dbname=test", "root", "");
      if (!empty($login)) {
        $this->login = htmlspecialchars(trim($login));
      }
      if (!empty($password)) {
        $this->password = htmlspecialchars(trim(password_hash($password, PASSWORD_BCRYPT)));
      }
      $requete = "UPDATE `utilisateurs` SET login = :login , password = :password WHERE id = :id";
      $query = $pdo->prepare($requete);
      $result = $query->execute([
        ':id' => $this->id,
        ':login' => $this->login,
        ':password' => $this->password
      ]);
      $this->errorMessage = null;
      return $result;
    } else {
      $this->errorMessage = "Ce nom d'utilisateur existe déjà";
      return false;
    }
  }
}
