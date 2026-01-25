<?php
// Se connecter à la BDD
include "components/utils/db_connection.php";

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
    //echo $expansion['expansion'];
}
