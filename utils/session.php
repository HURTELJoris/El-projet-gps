<?php
  include("user.php"); // Classe
  include("pdo.php"); // BDD

  $current_url = $_SERVER['REQUEST_URI']; // Récupérer le nom du fichier
  $theUser = new User(NULL, NULL, NULL); // Définition de l'utilsateur à NULL

  if (strpos($current_url, '/inscription.php') !== false) // Si page inscription
  {
      $isSignUp = -1; // Définition de l'inscriptioon

      if (isset($_POST["btnSubmit"])) // Si il appuis le bouton inscrire
      {
        if (!(isset($_SESSION["IsConnecting"]))) // Si il est pas connecter
        {
          $theUser = new User($_POST["inputNom"], $_POST["inputEmail"], $_POST["inputPassword"]);
        }
      }
      
      if ($theUser->creationSucceeded() == 1) // Création réussi
      {
        echo "<script>window.location.href = 'accueil.php';</script>";
      }
      else if ($theUser->creationSucceeded() == 2) // Compte existe déjà
      {
          $isSignUp = 2;
      }
      else // Erreur
      {
        $isSignUp = 0;
      }
      
  }
  else if (strpos($current_url, '/index.php') !== false) // Si page connexion
  {
      $statusConnect = -1; // Définition de la connexion

      if (isset($_POST["btnSubmit"])) // Si il appuis le bouton connexion
      {
        if (!(isset($_SESSION["IsConnecting"]))) // Si il est pas connecter
        {
          $statusConnect = $theUser->Connexion($_POST["inputEmail"], $_POST["inputPassword"]);
  
          if ($statusConnect == 1) // Connexion et dans les cas contraire on envoie un message d'erreur (dans index.php)
          {
            echo "<script>window.location.href = 'accueil.php';</script>";
          }
        }
      }
  }
  else if (strpos($current_url, '/compte.php') !== false) // Si page d'accueil
  {
    $resultForm = -1; // Définition du retour des fonctions lors d'un clic sur un formulaire ci-dessous

    if ((isset($_SESSION["IsConnecting"]))) // Si il est connecter
    {
      if (isset($_POST["btnSubmitUsername"])) // Si il appuis le bouton pour changer l'username
      {
        $resultForm = $theUser->setUsername($_SESSION["EmailUsername"], $_POST["inputUsername"]);

        if ($resultForm == 1) // On va changer son username
        {
          $_SESSION["Login"] = $_POST["inputUsername"];
        }
      }
      else if (isset($_POST["btnSubmitEmail"])) // Si il appuis le bouton pour changer l'email
      {
        $resultForm = $theUser->setEmail($_SESSION["EmailUsername"], $_POST["inputEmail"]);

        if ($resultForm == 1) // On va changer son email
        {
          $_SESSION["EmailUsername"] = $_POST["inputEmail"];
        }
      }
      else if (isset($_POST["btnSubmitPaswword"])) // Si il appuis le bouton pour changer le password
      {
        $resultForm = $theUser->setPassword($_SESSION["EmailUsername"], $_POST["inputPassword"]);
      }
      else if (isset($_POST["btnSubmitDeleteAccount"])) // Si il appuis le bouton pour supprimer son compte
      {
        $resultForm = $theUser->deleteAccount($_SESSION["EmailUsername"]);

        if ($resultForm == 1) // On le deconnecte
        {
          session_unset(); // On supprime tout les tableaux de la session
          session_destroy(); // On détruit la session
          header("Location: index.php");
        }
      }
    }
  }
  else if (strpos($current_url, '/admin.php') !== false) // Si page d'accueil
  {
    $resultForm = -1;
    $tabUsers = $theUser->getAllUser(); // On récupére le tableau des users

    if (isset($_POST['modifier']))  // Si on change les infos pour un user
    {
      $idUser = $_POST['idUser'];
      $nouveauNom = $_POST['nom'];
      $nouvelEmail = $_POST['email'];
  
      // on utilise PDO pour mettre à jour les données dans la base de données
      $requete = "UPDATE user SET nom=:nom, email=:email WHERE idUser=:idUser";
      $stmt = $GLOBALS["pdo"]->prepare($requete);
      $stmt->bindParam(':nom', $nouveauNom);
      $stmt->bindParam(':email', $nouvelEmail);
      $stmt->bindParam(':idUser', $idUser);
      $stmt->execute();

      // Rafraîchir la page pour afficher les modifications mises à jour
      header("Location: admin.php");
    }
  }
?>