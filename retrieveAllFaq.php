<?php
$sql = "SELECT f.id, f.question, f.answer, f.display_order, c.name AS category_name
        FROM adg_faq f
        LEFT JOIN adg_faq_categories c ON f.id_category = c.id
        ORDER BY c.id ASC, f.display_order ASC";

$stmt = $db->prepare($sql);
$stmt->execute();
$all_faq = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Grouper par catégorie
$faq_by_category = [];
foreach ($all_faq as $faq) {
    $cat = $faq['category_name'] ?? 'Autre';
    $faq_by_category[$cat][] = $faq;
}
?>
