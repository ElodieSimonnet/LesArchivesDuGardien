<?php
// Se connecter à la BDD
include "components/utils/db_connection.php";

// Faire la requête SQL pour avoir les sources

$sql = "SELECT * FROM adg_sources";

// préparation de la requête
$query = $db->prepare($sql);

// execution de la requête
$query->execute();

// Récupérer un tableau qui contient les données des sources

$sources = $query->fetchAll();

// Formater les données pour l'affichage


//var_dump($sources);

foreach ($sources as $source) {
    //echo $source['source'];
}