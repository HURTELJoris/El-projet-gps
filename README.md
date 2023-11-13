# El-projet-gps
Notre super projet avec Mathias, Jean et Quentin

INFO : IL Y AUSSI  UN AUTRE REPOSITORY QUI CONTIENT LE SERVEUR C++ POUR LA MISE EN BASE DE DONNEE DES COORDONNEES GPS, IL Y A AUSSI DANS CELUI-CI LE CODE POUR GENERER LES TRAMES GPS SUR ARDUINO
VOICI LE LIEN DU REPOSITORY : https://github.com/QuentinPOL/SerieQTGPS

## 1) L'IP des machines virtuelles utilisées pour le projet :
    - __192.168.64.84__, l'IP pour accéder au site.  
    - __192.168.64.213__, l'IP pour accéder à la base de données.

-----------------


## 2) LA BASE DE DONNÉES

il est possible d'accéder à la base de données en utilisant le couple identifiant/mot de passe : root/root.
Voici la composition de la base de données :


Lawrence     	
      
      └── user  
        ├── idUser : int (clé primaire)  
        ├── nom : varchar(30)  
        ├── email : varchar(300)  
        └── passwd : varchar (30)  
        └── isAdmin : tinyint (1) 

        
      └── GPS  
        ├── BateauID : int (clé primaire)  
        ├── Date : date 
        ├── Heure : time
        ├── Latitude : varchar (100) 
        ├── Longitude : varchar (100) 
        └── Vitesse : int
        └── VitesseMoyenne : float

-----------------


## 3° ORGANISATION DU CODE

* __./addons__
    *readme.md* -> ce même fichier que vous êtes en train de lire pour vous aider à comprendre le code 
    *lawrence.sql* -> un export clean de la base de données afin de pouvoir l'importer dans PhpMyAdmin   

* __./boostrap__
    *contient les fichiers boostraps*

* __./css__  
    *bootstrap.css* -> css utilisé pour les templates bootstraps
    *foot-awesome.min.css* -> gère les polices d'écriture du site
    *login.css* -> gère le css de la page de connexion
    *responsive.css* -> gère le responsive du site
    *style.css* -> gère le css général
    *style.css.map* -> gère le css pour l'affichage de la carte
    *style.scss* ->
    *website.css* ->  
* __./images__    
    *bg.jpg* -> image de background pour les pages de connexion et d'inscription

* __./js__  
    *boostrap.js* -> gère le javascript de la template boostraps
    *jquery.min.js* -> bibliothèque javascript
    *main.js* -> gère le javascript général du site
    *website.js* -> gère la navbar sur toutes les pages et la fermeture de la pop-up de modification
      
* __./utils__  
    *pdo.php* -> se connecte à la base de données

    *session.php* -> gère la session avec l'utilisateur

    *user.php* -> code de la classe user


*accueil.php* -> page d'accueil du site

*compte.php* -> page pour gérer les informations du compte

*positionBateaux.php* -> page pour voir les 10 points des positions des coordonnées sur la carte mise à jour toutes les 3 secondes

*valeursBateaux.php* -> page pour voir les 10 dernières positions récupérer toutes les 3 secondes

*valuesGPS.php* -> API PHP pour récupérer les positions GPS en base

*index.php* -> page de connexion

*inscription.php* -> page d'inscription

*readme.md* -> ce même fichier que vous êtes en train de lire pour vous aider à comprendre le code 
