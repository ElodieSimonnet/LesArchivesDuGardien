<?php
include "components/utils/db_connection.php";

$sql = "SELECT * FROM adg_pet_families";

$query = $db->prepare($sql);
$query->execute();

$families = $query->fetchAll();
