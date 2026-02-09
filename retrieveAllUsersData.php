<?php
$sql = "SELECT 
            adg_users.*, 
            adg_roles.role_name, 
            adg_users_status.status 
        FROM adg_users
        INNER JOIN adg_roles ON adg_users.id_role = adg_roles.id
        INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id
        ORDER BY adg_users.id ASC"; // ASC = Croissant;

$stmt = $db->prepare($sql);
$stmt->execute();

// On récupère tout dans le tableau
$all_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>