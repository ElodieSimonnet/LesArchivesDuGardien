<?php
$sql = "SELECT adg_faq.id, adg_faq.question, adg_faq.answer, adg_faq.display_order, adg_faq_categories.name AS category_name
        FROM adg_faq
        LEFT JOIN adg_faq_categories ON adg_faq.id_category = adg_faq_categories.id
        ORDER BY adg_faq_categories.id ASC, adg_faq.display_order ASC";

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
