<?php
$base_sql = "SELECT n.id, n.title, n.content, n.image_url, n.source_news, n.created_at, u.username AS author
             FROM adg_news n
             LEFT JOIN adg_users u ON n.id_user = u.id
             ORDER BY n.created_at DESC";

// 3 dernières news pour le carousel
$stmt_carousel = $db->prepare($base_sql . " LIMIT 3");
$stmt_carousel->execute();
$carousel_news = $stmt_carousel->fetchAll(PDO::FETCH_ASSOC);

// News plus anciennes pour la section archives
$stmt_list = $db->prepare($base_sql . " LIMIT 3 OFFSET 3");
$stmt_list->execute();
$list_news = $stmt_list->fetchAll(PDO::FETCH_ASSOC);
?>
