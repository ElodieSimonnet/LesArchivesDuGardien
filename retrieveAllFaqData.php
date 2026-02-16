<?php
$sql = "SELECT f.id, f.question, f.answer, f.display_order, f.created_at, c.name AS category_name
        FROM adg_faq f
        LEFT JOIN adg_faq_categories c ON f.id_category = c.id
        ORDER BY f.id ASC";

$stmt = $db->prepare($sql);
$stmt->execute();

$all_faq = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
