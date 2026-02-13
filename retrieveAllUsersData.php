<?php
$sql = "SELECT
            adg_users.*,
            adg_roles.role_name,
            adg_users_status.status
        FROM adg_users
        INNER JOIN adg_roles ON adg_users.id_role = adg_roles.id
        INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id";

$conditions = [];
$params = [];

// Filtre par statut
if (!empty($_GET['status']) && $_GET['status'] !== 'all') {
    $conditions[] = "LOWER(adg_users_status.status) = LOWER(:status)";
    $params[':status'] = $_GET['status'];
}

// Filtre par rôle
if (!empty($_GET['role']) && $_GET['role'] !== 'all') {
    $conditions[] = "LOWER(adg_roles.role_name) = LOWER(:role)";
    $params[':role'] = $_GET['role'];
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY adg_users.id ASC";

$stmt = $db->prepare($sql);
$stmt->execute($params);

$all_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>