<?php
// Total des utilisateurs
$stmtTotal = $db->prepare("SELECT COUNT(*) FROM adg_users");
$stmtTotal->execute();
$totalUsers = $stmtTotal->fetchColumn();

// Utilisateurs Actifs 
$stmtActive = $db->prepare("
    SELECT COUNT(*) 
    FROM adg_users 
    INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id 
    WHERE adg_users_status.status = :status
");
$stmtActive->execute(['status' => 'Actif']);
$activeUsers = $stmtActive->fetchColumn();

// Utilisateurs Suspendus
$stmtSuspended = $db->prepare("
    SELECT COUNT(*) 
    FROM adg_users 
    INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id 
    WHERE adg_users_status.status = :status
");
$stmtSuspended->execute(['status' => 'Suspendu']);
$suspendedUsers = $stmtSuspended->fetchColumn();

// Utilisateurs Bannis 
$stmtBanned = $db->prepare("
    SELECT COUNT(*) 
    FROM adg_users 
    INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id 
    WHERE adg_users_status.status = :status
");
$stmtBanned->execute(['status' => 'Banni']);
$bannedUsers = $stmtBanned->fetchColumn();

// Les 5 dernières entrées
$stmtLast = $db->prepare("SELECT username, email FROM adg_users ORDER BY id DESC LIMIT 5");
$stmtLast->execute();
$lastUsers = $stmtLast->fetchAll(PDO::FETCH_ASSOC);
?>