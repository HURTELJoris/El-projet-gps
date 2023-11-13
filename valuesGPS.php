<?php
// Inclure le fichier pdo.php pour établir la connexion à la base de données
include("utils/pdo.php");

try {
    // Requête SQL pour sélectionner les 10 dernières entrées de la table GPS
    $sql = "SELECT *
    FROM GPS
    ORDER BY BateauID DESC
    LIMIT 10";

    // Préparer la requête SQL
    $requete = $GLOBALS["pdo"]->prepare($sql);

    // Exécuter la requête
    $requete->execute();

    // Récupérer les résultats sous forme de tableau associatif
    $donnees = $requete->fetchAll(PDO::FETCH_ASSOC);

    // Convertir le tableau de données en format JSON et le renvoyer
    echo json_encode($donnees);
} catch (Exception $error) {
    echo "Erreur : " . $error->getMessage();
}
