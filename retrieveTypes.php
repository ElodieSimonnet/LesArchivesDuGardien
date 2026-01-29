<?php
// Se connecter à la BDD
include "components/utils/db_connection.php";

// Faire la requête SQL pour avoir les types de montures

$sql = "SELECT * FROM adg_mount_types";

// préparation de la requête
$query = $db->prepare($sql);

// execution de la requête
$query->execute();

// Récupérer un tableau qui contient les données des types de montures

$types = $query->fetchAll();

// Formater les données pour l'affichage


//var_dump($types);

foreach ($types as $type) {
    //echo $type['type'];
}