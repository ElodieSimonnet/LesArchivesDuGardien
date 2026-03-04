<?php

/**
 * ============================================================
 * MODÈLE : FaqModel
 * ============================================================
 * Rôle : Toutes les requêtes SQL liées à la FAQ.
 * ============================================================
 */

class FaqModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // ========================================================
    // LECTURE - Pages publiques
    // ========================================================

    /**
     * Récupère toutes les questions groupées par catégorie.
     * Utilisé par la page FAQ publique.
     */
    public function getAllGroupedByCategory(): array
    {
        $sql = "SELECT adg_faq.id, adg_faq.question, adg_faq.answer, adg_faq.display_order, adg_faq_categories.name AS category_name
                FROM adg_faq
                LEFT JOIN adg_faq_categories ON adg_faq.id_category = adg_faq_categories.id
                ORDER BY adg_faq_categories.id ASC, adg_faq.display_order ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $all_faq = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $faq_by_category = [];
        foreach ($all_faq as $faq) {
            $cat = $faq['category_name'] ?? 'Autre';
            $faq_by_category[$cat][] = $faq;
        }
        return $faq_by_category;
    }

    // ========================================================
    // LECTURE - Admin
    // ========================================================

    /**
     * Récupère toutes les questions pour l'interface admin.
     */
    public function getAll(): array
    {
        $sql = "SELECT adg_faq.id, adg_faq.question, adg_faq.answer, adg_faq.display_order, adg_faq.created_at, adg_faq_categories.name AS category_name
                FROM adg_faq
                LEFT JOIN adg_faq_categories ON adg_faq.id_category = adg_faq_categories.id
                ORDER BY adg_faq_categories.id ASC, adg_faq.display_order ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une question par son ID (avec catégorie).
     */
    public function getById(int $id): ?array
    {
        $sql = "SELECT adg_faq.*, adg_faq_categories.name AS category_name
                FROM adg_faq
                LEFT JOIN adg_faq_categories ON adg_faq.id_category = adg_faq_categories.id
                WHERE adg_faq.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Récupère une question brute par ID (pour le formulaire d'édition).
     */
    public function getRawById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM adg_faq WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Récupère les catégories FAQ pour le select.
     */
    public function getCategories(): array
    {
        $stmt = $this->db->query("SELECT id, name FROM adg_faq_categories ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ========================================================
    // ÉCRITURE - Créer / Modifier / Supprimer
    // ========================================================

    public function create(array $data): bool
    {
        $sql = "INSERT INTO adg_faq (question, answer, id_category, display_order)
                VALUES (:question, :answer, :id_category, :display_order)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update(array $data): bool
    {
        $sql = "UPDATE adg_faq SET
                    question      = :question,
                    answer        = :answer,
                    id_category   = :id_category,
                    display_order = :display_order
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM adg_faq WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
