<?php
session_start();
include("utils/session.php"); // Inclusion de fichier  avec les classes
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>GPS - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/website.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="accueil.php">GPS</a>
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
                    if (isset($_SESSION["IsConnecting"]) && $_SESSION["IsConnecting"] == true) {
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
                    } else // Si il n'est pas connecter
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
                    <div class="nav"> <!--  Navbar de test -->
                        <div class="sb-sidenav-menu-heading">Pages</div>
                        <a class="nav-link" href="accueil.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Accueil
                        </a>
                        <a class="nav-link" href="valeursBateaux.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Accès aux données
                        </a>
                        <a class="nav-link" href="positionBateaux.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Position des bateaux
                        </a>
                        <?php
                        if (isset($_SESSION["IsConnecting"]) && $_SESSION["isAdmin"] == 1) // Si il est admin
                        {
                        ?>
                            <a class="nav-link" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Accès administrateur
                            </a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Connecté en tant que :</div>
                    <?= $_SESSION["Login"] ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <h1>Position des Bateaux</h1>
            <div id="map"></div>

            <script>
                var map = L.map('map').setView([50.65, 2], 9);
                var markers = L.layerGroup(); // Créez un groupe de couches pour les marqueurs
                var polyline; // Variable pour stocker la polyline

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                function fetchDonnees() {
                    fetch('valuesGPS.php')
                        .then(response => {
                            if (response.ok) {
                                return response.json();
                            } else {
                                throw new Error('Erreur lors de la récupération des données');
                            }
                        })
                        .then(data => {
                            // Effacez tous les marqueurs existants et la polyline
                            markers.clearLayers();
                            if (polyline) {
                                map.removeLayer(polyline);
                            }

                            if (data.length > 0) {
                                // Traitez les données récupérées ici
                                var coordinates = []; // Tableau pour stocker les coordonnées des marqueurs

                                data.forEach(entry => {
                                    const latitude = convertirCoordonnee(entry.Latitude);
                                    const longitude = convertirCoordonnee(entry.Longitude);

                                    // Ajoutez un nouveau marqueur au groupe de couches
                                    L.marker([latitude, longitude])
                                        .bindPopup(
                                            'BateauID: ' + entry.BateauID + '<br>' +
                                            'Date: ' + entry.Date + '<br>' +
                                            'Heure: ' + entry.Heure + '<br>' +
                                            'Latitude: ' + latitude + '<br>' +
                                            'Longitude: ' + longitude + '<br>' //+
                                            //'Vitesse: ' + entry.Vitesse + ' km/h<br>' +
                                            //'Vitesse Moyenne: ' + entry.VitesseMoyenne + ' km/h'
                                        )
                                        .addTo(markers);

                                    // Ajoutez les coordonnées au tableau
                                    coordinates.push([latitude, longitude]);

                                    console.log("Latitude convertie : " + latitude);
                                    console.log("Longitude convertie : " + longitude);
                                });

                                // Ajoutez le groupe de couches à la carte
                                markers.addTo(map);

                                // Créez une polyline avec les coordonnées
                                polyline = L.polyline(coordinates, {
                                    color: 'blue'
                                }).addTo(map);
                            } else {
                                console.log('Aucune donnée n\'a été renvoyée.');
                            }
                        })
                        .catch(error => {
                            console.error('Erreur lors de la récupération des données :', error);
                        });
                }

                function convertirCoordonnee(coordonnee) {
                    // Supprimez le dernier caractère ('N') et divisez la chaîne
                    const valeur = parseFloat(coordonnee.slice(0, -1));

                    // Calculez les degrés et minutes décimales
                    const degres = Math.floor(valeur / 100);
                    const minutesDecimales = (valeur % 100) / 60;

                    // Calculez la coordonnée convertie
                    const coordonneeConvertie = degres + minutesDecimales;

                    // Retournez la coordonnée convertie
                    return coordonneeConvertie;
                }

                // Appeler fetchDonnees() immédiatement au démarrage
                fetchDonnees();

                // Ensuite, définir un intervalle de 3 secondes pour appeler fetchDonnees() de manière répétée
                setInterval(fetchDonnees, 3000); // 3000 millisecondes équivalent à 3 secondes
            </script>

            <footer class="py-4 bg-light mt-auto"> <!-- FOOTER -->
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
</body>

</html>