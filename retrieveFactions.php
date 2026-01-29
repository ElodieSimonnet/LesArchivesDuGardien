<?php
// Se connecter à la BDD
include "components/utils/db_connection.php";

// Faire la requête SQL pour avoir les extensions

$sql = "SELECT * FROM adg_factions";

// préparation de la requête
$query = $db->prepare($sql);

// execution de la requête
$query->execute();

// Récupérer un tableau qui contient les données des extensions

$factions = $query->fetchAll();

// Formater les données pour l'affichage


//var_dump($factions);

foreach ($factions as $faction) {
    //echo $faction['faction'];
}