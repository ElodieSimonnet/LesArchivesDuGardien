<?php
$base_sql = "SELECT adg_news.id, adg_news.title, adg_news.content, adg_news.image_url, adg_news.source_news, adg_news.created_at, adg_users.username AS author
             FROM adg_news
             LEFT JOIN adg_users ON adg_news.id_user = adg_users.id
             ORDER BY adg_news.created_at DESC";

// 3 dernières news pour le carousel
$stmt_carousel = $db->prepare($base_sql . " LIMIT 3");
$stmt_carousel->execute();
$carousel_news = $stmt_carousel->fetchAll(PDO::FETCH_ASSOC);

// News plus anciennes pour la section archives
$stmt_list = $db->prepare($base_sql . " LIMIT 3 OFFSET 3");
$stmt_list->execute();
$list_news = $stmt_list->fetchAll(PDO::FETCH_ASSOC);
?>
