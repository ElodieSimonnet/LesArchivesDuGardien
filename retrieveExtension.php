<?php
// Se connecter à la BDD
try {
    $db = new PDO(
        "mysql:host=127.0.0.1;port=3306;dbname=lesarchivesdugardien;charset=utf8",
        "root",
        ""
    );
    // echo "Database connection successful!";
} catch (PDOException $e) {
    //echo "Connection failed: " . $e->getMessage();
}

// Faire la requête SQL pour avoir les extensions

$sql = "SELECT * FROM adg_expansions";

// préparation de la requête
$query = $db->prepare($sql);

// execution de la requête
$query->execute();

// Récupérer un tableau qui contient les données des extensions

$expansions = $query->fetchAll();

// Formater les données pour l'affichage


//var_dump($expansions);

foreach ($expansions as $expansion) {
    echo $expansion['expansion'];
}
