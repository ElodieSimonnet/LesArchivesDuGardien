<?php

class FaqModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAllGroupedByCategory(): array
    {
        $sql = "SELECT adg_faq.id, adg_faq.question, adg_faq.answer, adg_faq.display_order, adg_faq_categories.name AS category_name
                FROM adg_faq
                LEFT JOIN adg_faq_categories ON adg_faq.id_category = adg_faq_categories.id
                ORDER BY adg_faq_categories.id ASC, adg_faq.display_order ASC";

        $query = $this->db->prepare($sql);
        $query->execute();
        $all_faq = $query->fetchAll(PDO::FETCH_ASSOC);

        $faq_by_category = [];
        foreach ($all_faq as $faq) {
            $cat = $faq['category_name'] ?? 'Autre';
            $faq_by_category[$cat][] = $faq;
        }
        return $faq_by_category;
    }

    public function getAll(): array
    {
        $sql = "SELECT adg_faq.id, adg_faq.question, adg_faq.answer, adg_faq.display_order, adg_faq.created_at, adg_faq_categories.name AS category_name
                FROM adg_faq
                LEFT JOIN adg_faq_categories ON adg_faq.id_category = adg_faq_categories.id
                ORDER BY adg_faq_categories.id ASC, adg_faq.display_order ASC";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $sql = "SELECT adg_faq.*, adg_faq_categories.name AS category_name
                FROM adg_faq
                LEFT JOIN adg_faq_categories ON adg_faq.id_category = adg_faq_categories.id
                WHERE adg_faq.id = :id";

        $query = $this->db->prepare($sql);
        $query->execute([':id' => $id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getRawById(int $id): ?array
    {
        $query = $this->db->prepare("SELECT * FROM adg_faq WHERE id = :id");
        $query->execute([':id' => $id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getCategories(): array
    {
        $query = $this->db->query("SELECT id, name FROM adg_faq_categories ORDER BY id ASC");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO adg_faq (question, answer, id_category, display_order)
                VALUES (:question, :answer, :id_category, :display_order)";

        $query = $this->db->prepare($sql);
        return $query->execute($data);
    }

    public function update(array $data): bool
    {
        $sql = "UPDATE adg_faq SET
                    question      = :question,
                    answer        = :answer,
                    id_category   = :id_category,
                    display_order = :display_order
                WHERE id = :id";

        $query = $this->db->prepare($sql);
        return $query->execute($data);
    }

    public function delete(int $id): bool
    {
        $query = $this->db->prepare("DELETE FROM adg_faq WHERE id = :id");
        return $query->execute([':id' => $id]);
    }
}
