<?php

// On sélectionne toutes les colonnes de adg_users et seulement la colonne title de adg_titles
$query = "
    SELECT adg_users.*, adg_titles.title 
    FROM adg_users 
    LEFT JOIN adg_titles ON adg_users.active_title_id = adg_titles.id 
    WHERE adg_users.id = ?
";

$stmt = $db->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Maintenant, dans le tableau $user, on a une clé ['title']
$displayTitle = $user['title'] ?? "Sans titre";
?>