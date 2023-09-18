<?php
    include("pdo.php"); // Base de donnée

    class User // Utilisateur(s) du site
    {
        // Attribut(s)
        public $Tabtest=[];
        private $nameUser; // (Pas encore utilisé  mais pour l'affichage du pseudo cela peut être utile)
        private $emailUser;
        private $creationSucceeded;

        // Constructeur
        public function __construct($name, $email, $passwd)
        {
            $insert = null; // Par défaut, il n'y à  pas d'insertion
            $this->creationSucceeded = -1; // par défaut, la création échoue
    
            if ($email != null) // Si un des champs n'est pas nul
            {
                if ($GLOBALS["pdo"]) // Si la connexion à la bdd est réussi
                {
                    $count = 0;
    
                    $account = "SELECT * FROM user";
                    $selectAccount = $GLOBALS["pdo"]->query($account);
        
                    if($selectAccount != false) // Si la requête est réussie
                    {
                        $row_count = $selectAccount->rowCount();
                        if($row_count > 0) // Si il y a + de 0 utilisateur dans la table user
                        {
                            $tabAccount = $selectAccount->fetchAll();
                            foreach($tabAccount as $accountX) // On va parcourir le tableau d'utilisateur
                            {
                                if($email != $accountX['email'] && $name != $accountX['nom']) // Si on trouve pas d'utilisateur
                                {
                                    $count = 1;
                                }
                                else if ($email == $accountX['email'] || $name == $accountX['nom']) // Si on trouve déjà un utilisateur
                                {
                                    $this->creationSucceeded = 2;
                                    $insert = 2;
                                    break;
                                }
                            }
        
                            if ($count == 1) // Si toujours personne n'a était trouver
                            {
                                $insert = "INSERT INTO user (nom, email, passwd) VALUES ('$name', '$email', '$passwd');";
                            }
                        }
                        else if($row_count == 0) // Si il  n'y à pas encore d'utilisateur
                        {
                            $insert = "INSERT INTO user (nom, email, passwd) VALUES ('$name', '$email', '$passwd');";     
                        }
                    }

    
                    if ($insert != null && $insert != 2) // Si la requête est réussie et que aucun compte correspondant n'a était trouvé
                    {
                        $insertResult = $GLOBALS["pdo"] -> query($insert);
        
                        if ($insertResult != false) // Si la requête est réussie
                        {
                            $this->nameUser = $name;
                            $this->emailUser = $email;
                            $this->creationSucceeded = 1;

                            // On va ainsi prendre le pseudo pour la session
                            $_SESSION["Login"] = $this->nameUser; // Tableau de session Login = login de l'utilsateur

                            // On va créer un idUser par à son email et on va le stocker dans la session
                            $UserId = $this->getIdUser($this->emailUser);
                            $_SESSION["idUser"] = $UserId;
                        }
                        else
                        {
                            $this->creationSucceeded = 0;
                        }
                    }
                    else if ($insert == null) // Si la requête n'est pas réussie
                    {
                        $this->creationSucceeded = 0;
                    }
                }
                else // Si la connexion à la bdd n'est pas réussie
                {
                    $this->creationSucceeded = 0;
                }
            }
        } 

        // Méthode de connexion via la bdd (pdo)
        public function Connexion($login, $password)
        {
            if ($GLOBALS["pdo"]) // Si la connexion à la bdd est réussi
            {
                $select = "SELECT nom, email, passwd FROM user where email='$login'";
                $selectResult = $GLOBALS["pdo"] -> query($select);
    
                if ($selectResult != false) // Si la requête est réussie
                {
                    $row_count = $selectResult->rowCount();
                    if($row_count > 0)
                    {
                        $tabUser = $selectResult -> fetchALL();
                        foreach($tabUser as $user) // On va parcourir le tableau d'utilisateur
                        {
                            if($login == $user['email'] &&  $password == $user['passwd']) // Si un user avec le même mdp à était trouvé alors on le connecte
                            {
                                // On va ainsi prendre le pseudo pour la session
                                $_SESSION["Login"] = $user['nom']; // Tableau de session Login = login de l'utilsateur

                                // On va créer un idUser par à son email et on va le stocker dans la session
                                $UserId = $this->getIdUser($login);
                                $_SESSION["idUser"] = $UserId;
                                
                                return 1;
                            }
                            else if ($password != $user['passwd']) // Si le mot de passe est  différent
                            {
                                $this->test($password, $user['passwd']);
                                return 3;
                            }
                        }
                    }
                    else if ($row_count == 0) // Si aucun utilisateur ne correspond
                    {
                        return 2;
                    }
                }
                else // Si la requête n'est pas réussie
                {
                    return 0;
                }
            }
            else // Si la connexion à la bdd n'est pas réussie
            {
                return 0;
            }
        }

        // Méthode pour récupérer l'id d'un
        public function getIdUser($login)
        {
            $idUser = null; // On définit l'id à null

            $selectID = "SELECT idUser FROM user where email='$login'";
            $selectIdResult = $GLOBALS["pdo"] -> query($selectID);

            if ($selectIdResult != false) // Si la requête est réussie
            {
                $row_countId = $selectIdResult->rowCount();
                if($row_countId > 0) // Si le nombre de résultat est supérieur à 0
                {
                    $idUser = $selectIdResult->fetch(); // On va récup l'id user
                }
            }

            return $idUser; // Et on va le retourner
        }

        // Méthode pour la création de compte
        public function creationSucceeded() 
        {
            return $this->creationSucceeded; 
        }

        public function test($test1, $test2)
        {
            $this->Tabtest[0] = $test1;
            $this->Tabtest[1] = $test2;
        }

        public function returnTest()
        {
            return $this->Tabtest;
        }
    }
?>