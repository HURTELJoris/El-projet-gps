<?php
  session_start();
  include("utils/session.php");

  if (!isset($_SESSION["IsConnecting"]) && $_SESSION["isAdmin"] != 1) // Si il est admin
  {
    header("Location: accueil.php");
  }
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
        <link href="css/website.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
                        <li><a class="dropdown-item" href="compte.php">Mon compte</a></li>
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
            
            <!-- NAVBAR pour les pages -->
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
                        <?=$_SESSION["Login"]?> (Admin)
                    </div>
                </nav>
            </div>

            <div id="layoutSidenav_content">
                <main>

                    <!-- Modif pour les comptes -->
                    <div class="container mt-4">
                    <input type="text" id="search" class="form-control mb-2" placeholder="Rechercher par nom ou e-mail">
                    
                    <h1>Liste des Utilisateurs</h1>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($tabUsers != 0)  // Si le tableau des utilisateurs et valide
                            {
                                foreach ($tabUsers as $user)  // On va parcourir chacun d'eux
                                {
                                    echo "<tr>";
                                    echo "<td>{$user['idUser']}</td>";
                                    echo "<td>{$user['nom']}</td>";
                                    echo "<td>{$user['email']}</td>";
                                    echo "<td>";
                                    echo "<form method='post'>";
                                    echo "<input type='hidden' name='idUser' value='{$user['idUser']}'>";
                                    echo "<div class='form-group'>";
                                    echo "<label for='nom'>Nom:</label>";
                                    echo "<input type='text' class='form-control' name='nom' value='{$user['nom']}'>";
                                    echo "</div>";
                                    echo "<div class='form-group'>";
                                    echo "<label for='email'>Email:</label>";
                                    echo "<input type='text' class='form-control' name='email' value='{$user['email']}'>";
                                    echo "</div>";
                                    echo "<button type='submit' name='modifier' class='btn btn-primary'>Modifier</button>";
                                    echo "</form>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } 
                            else 
                            {
                                echo "ERREUR";
                            }
                            ?>
                        </tbody>
                    </table>
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

        <script>
            // MODULE POUR modifier les infos d'un user en tant que admin
            $("#search").on("keyup", function() 
            {
                var value = $(this).val().toLowerCase();
                $("tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/website.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    </body>
</html>