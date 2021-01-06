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

  // Setters

  public function setLogin($login)
  {
    $this->login = htmlspecialchars(trim($login));
  }

  public function setPassword($password)
  {
    $this->password = htmlspecialchars(trim($password));
  }

  public function setErrorMessage($errorMessage)
  {
    $this->errorMessage = $errorMessage;
  }

  // Getters

  public function getId()
  {
    return $this->id;
  }

  public function getLogin()
  {
    return $this->login;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function getErrorMessage()
  {
    return $this->errorMessage;
  }

  // Other functions

  function checkPassword($password, $c_password)
  {
    if (!empty($password) && !empty($c_password)) {
      if ($password === $c_password) {
        $this->setErrorMessage(null);
        return true;
      } else {
      }
    }
    $this->setErrorMessage("Merci de bien confirmer votre nouveau mot de passe");
    return false;
  }

  public function verifUser($login)
  {
    // Permet de vérifier si l'utilisateur existe déjà
    $pdo = new PDO("mysql:host=localhost;dbname=reservationsalles", "root", "");
    $requete = "SELECT * FROM utilisateurs WHERE login = :login";
    $query = $pdo->prepare($requete);
    $query->execute([
      ":login" => $login
    ]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    if (empty($result)) {
      // Si aucun utilisateur ne correspond, alors la fonction renvoie true
      $this->setErrorMessage(null);
      return true;
    } else {
      $this->setErrorMessage("Ce nom d'utilisateur existe déjà, merci d'en choisir un autre.");
      return false;
    }
  }

  public function verifPassword($password)
  {
    if (password_verify($password, $this->getPassword())) {
      $this->setErrorMessage(null);
      return true;
    } else {
      $this->setErrorMessage("Merci d'indiquer votre mot de passe actuel");
      return false;
    }
  }

  public function register()
  {
    $pdo = new PDO("mysql:host=localhost;dbname=reservationsalles", "root", "");
    $requete = "INSERT INTO utilisateurs (login, password) VALUES (:login, :password)";
    $query = $pdo->prepare($requete);
    $result = $query->execute([
      ":login" => $this->login,
      ":password" => password_hash($this->password, PASSWORD_BCRYPT)
    ]);
    header('Location:connexion.php');
    return $result;
  }

  public function connect()
  {
    $pdo = new PDO("mysql:host=localhost;dbname=reservationsalles", "root", "");
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
      header('Location:../index.php');
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
    header('Location:../index.php');
  }

  public function delete()
  {
    $pdo = new PDO("mysql:host=localhost;dbname=reservationsalles", "root", "");
    $requete = "DELETE FROM `utilisateurs` WHERE login = :login";
    $del = $pdo->prepare($requete);
    $del->execute([
      ':login' => $this->login
    ]);
    foreach ($this as $propriete => $valeur) {
      $this->$propriete = null;
    }
    header('Location:../index.php');
  }

  public function update($login, $password)
  {
    $login = htmlspecialchars(trim($login));
    $password = htmlspecialchars(trim(password_verify($password, PASSWORD_BCRYPT)));
    $pdo = new PDO("mysql:host=localhost;dbname=reservationsalles", "root", "");
    if (!empty($login)) {
      $this->login = htmlspecialchars(trim($login));
    }
    if (!empty($password)) {
      $this->password = htmlspecialchars(trim(password_hash($password, PASSWORD_BCRYPT)));
    }
    $requete = "UPDATE `utilisateurs` SET login = :login , password = :password WHERE id = :id";
    $query = $pdo->prepare($requete);
    $result = $query->execute([
      ':id' => $this->getId(),
      ':login' => $this->getLogin(),
      ':password' => $this->getPassword()
    ]);
    $this->setErrorMessage(null);
    return $result;
  }
}
