<?php
$sql = "SELECT n.*, u.username AS author FROM adg_news n LEFT JOIN adg_users u ON n.id_user = u.id ORDER BY n.id ASC";

$stmt = $db->prepare($sql);
$stmt->execute();

$all_news = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
