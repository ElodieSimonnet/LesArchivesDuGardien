<?php
// Se connecter à la BDD.
include "components/utils/db_connection.php";

// Ecrire la requete qui permet de récupérer toutes les informations d'une monture.

// Permet de choisir quelle monture on affiche dans la page 
$mountId = 2;

$sql = "SELECT * FROM adg_mounts WHERE ID = $mountId";

// préparation de la requête
$query = $db->prepare( $sql );

// execution de la requête
$query->execute();

// récupération des résultats
$mount = $query->fetch();

// affichage des résultats : CONTIENT LES INFORMATION DE LA MONTURE
//var_dump($mount);

// Afficher l'image'
switch ($mount['id_type']) {
    case 3:
        $mountTypeLink="assets/images/mounts/horsehoe.png";
        break;
    case 1:
        $mountTypeLink="assets/images/mounts/wings.png";
        break;
    case 2:
        $mountTypeLink="assets/images/mounts/wave.png";
        break;
}

// Récupérer le nom de l'extension à partir de l'id.

$sql2 = "SELECT expansion FROM adg_expansions WHERE id = " . $mount['id_expansion'];
$query2 = $db->prepare( $sql2 );
$query2->execute();
$mountExpansion = $query2->fetch();

?>