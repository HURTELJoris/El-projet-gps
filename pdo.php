<?php
    try {
        $ipserver = "192.168.65.9";
        $nomBase = "Lawrence";
        $loginPrivilege = "root";
        $passPrivilege = "root";
        
        $GLOBALS["pdo"] = new PDO('mysql:host='.$ipserver.';dbname='.$nomBase.";charset=utf8mb4",$loginPrivilege,$passPrivilege);
    } 
    catch (Exception $error) 
    {
        $error->getMessage();
        echo "Erreur BDD : " .$error;
    }
?>