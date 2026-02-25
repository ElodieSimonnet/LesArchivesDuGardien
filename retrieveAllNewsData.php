<?php
$sql = "SELECT adg_news.*, adg_users.username AS author FROM adg_news LEFT JOIN adg_users ON adg_news.id_user = adg_users.id ORDER BY adg_news.id ASC";

$stmt = $db->prepare($sql);
$stmt->execute();

$all_news = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
