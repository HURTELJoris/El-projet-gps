<?php
  session_start();
  include("session.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>GPS - Compte</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link href="css/website.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>

    <style>
        .custom-input {
            max-width: 500px; /* longeur des champs input dans les différents fomurlaires */
        }
    </style>

    <body class="sb-nav-fixed">

        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">GPS</a>

            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

            <!-- Navbar-->
            <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Mon compte</a></li>
                        <?php
                            // Si l'utilisateur est connecté
                            if (isset($_SESSION["IsConnecting"]) && $_SESSION["IsConnecting"] == true)
                            {
                                ?>
                                    <form action="" method="post">
                                        <button type='submit' class="dropdown-item" name='Deconnexion'>Se déconnecter</button>
                                    </form>
                                <?php

                                if (isset($_POST["Deconnexion"])) // Sinon si l'utilisateur appuis sur le bouton de déconnexion
                                {
                                    session_unset(); // On supprime tout les tableaux de la session
                                    session_destroy(); // On détruit la session
                                    header("Location: index.php");
                                } 
                            }
                            else // Si il n'est pas connecter
                            {
                                header("Location: index.php");
                            }
                        ?>
                    </ul>
                </li>
            </ul>
        </nav>

        <div id="layoutSidenav">
            
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Pages</div>
                            <a class="nav-link" href="accueil.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Accueil
                            </a>
                            <a class="nav-link" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Accès aux données
                            </a>
                            <a class="nav-link" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Position des bateaux
                            </a>
                            <a class="nav-link" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Accès administrateur
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Connecté en tant que :</div>
                        <?=$_SESSION["Login"]?>
                    </div>
                </nav>
            </div>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Paramètre(s) de votre compte :
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                            <p><strong>Nom d'utilisateur : <?=$_SESSION["Login"]?></strong></p>
                                    </div>

                                    <div class="col-md-4">
                                            <p><strong>E-mail : <?=$_SESSION["EmailUsername"]?></strong></p>
                                    </div>

                                    <div class="col-md-4">
                                            <p><strong>Compte : Actif</strong></p>
                                    </div>

                                    <div class="col-md-6">
                                        <form action="" method="POST">
                                            <p>Nom d'utilisateur :</p>

                                            <div class="input-group">
                                                <input type="text" class="form-control custom-input" name="inputUsername" id="username" placeholder="Nouveau nom d'utilisateur" required>
                                                <button style="margin-left: 10px;" class="btn btn-primary" id="changeUsername" name="btnSubmitUsername">Modifier</button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <form action="" method="POST">
                                            <p>E-mail :</p>

                                            <div class="input-group">
                                                <input type="email" class="form-control custom-input" name="inputEmail" id="email" placeholder="Nouvelle adresse-mail" required>
                                                <button style="margin-left: 10px;" class="btn btn-primary" id="changeEmail" name="btnSubmitEmail">Modifier</button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-md-6">
                                        <form action="" method="POST">
                                            <p>Mot de passe :</p>

                                            <div class="input-group">
                                                <input type="password" class="form-control custom-input" name="inputPassword" id="password" placeholder="Nouveau mot de passe" required>
                                                <button style="margin-left: 10px;" class="btn btn-primary" id="changePassword" name="btnSubmitPaswword">Modifier</button>
                                            </div>
                                        </form>
                                    </div>

                                    <div style="margin-top: 40px;" class="col-md-6">
                                        <form action="" method="POST">
                                            <div class="input-group">
                                                <button class="btn btn-danger" id="deleteAccount" name="btnSubmitDeleteAccount">Supprimer définitivement votre compte</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="demo-preview">
                    <?php
                        if ($resultForm == 1) // Si un des formulaires est valider
                        {
                            ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close-button"><span aria-hidden="true">×</span></button>
                                    <strong>Changement effectuer avec succés !</strong> (regarder votre pseudo en bas à droite)
                                </div>
                            <?php
                        }
                        else if ($resultForm == 0)// Sinon message d'erreur
                        {
                            ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close-button"><span aria-hidden="true">×</span></button>
                                    <strong>ERREUR !</strong> Un problème est servenu lors du changement
                                </div>
                            <?php
                        }
                    ?>
                    </div>
                </main>

                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; La Providence 2023</div>
                        </div>
                    </div>
                </footer>

            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/website.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
