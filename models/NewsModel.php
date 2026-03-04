<?php

/**
 * ============================================================
 * MODÈLE : NewsModel
 * ============================================================
 * Rôle : Toutes les requêtes SQL liées aux actualités.
 * ============================================================
 */

class NewsModel
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
     * Récupère les 3 dernières news pour le carousel.
     */
    public function getCarouselNews(): array
    {
        $sql = "SELECT adg_news.id, adg_news.title, adg_news.content, adg_news.image_url, adg_news.source_news, adg_news.created_at, adg_users.username AS author
                FROM adg_news
                LEFT JOIN adg_users ON adg_news.id_user = adg_users.id
                ORDER BY adg_news.created_at DESC
                LIMIT 3";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les news plus anciennes pour la section archives.
     */
    public function getListNews(): array
    {
        $sql = "SELECT adg_news.id, adg_news.title, adg_news.content, adg_news.image_url, adg_news.source_news, adg_news.created_at, adg_users.username AS author
                FROM adg_news
                LEFT JOIN adg_users ON adg_news.id_user = adg_users.id
                ORDER BY adg_news.created_at DESC
                LIMIT 3 OFFSET 3";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ========================================================
    // LECTURE - Admin
    // ========================================================

    /**
     * Récupère tous les articles pour l'interface admin.
     */
    public function getAll(): array
    {
        $sql = "SELECT adg_news.*, adg_users.username AS author
                FROM adg_news
                LEFT JOIN adg_users ON adg_news.id_user = adg_users.id
                ORDER BY adg_news.id ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un article par son ID (avec auteur).
     */
    public function getById(int $id): ?array
    {
        $sql = "SELECT adg_news.*, adg_users.username AS author
                FROM adg_news
                LEFT JOIN adg_users ON adg_news.id_user = adg_users.id
                WHERE adg_news.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Récupère un article brut par ID (pour le formulaire d'édition).
     */
    public function getRawById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM adg_news WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Récupère la liste des utilisateurs admin pour le select auteur.
     */
    public function getAdminUsers(): array
    {
        $stmt = $this->db->query("SELECT id, username FROM adg_users WHERE id_role = 2 ORDER BY username ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ========================================================
    // ÉCRITURE - Créer / Modifier / Supprimer
    // ========================================================

    public function create(array $data): bool
    {
        $sql = "INSERT INTO adg_news (title, content, image_url, source_news, id_user)
                VALUES (:title, :content, :image_url, :source_news, :id_user)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update(array $data): bool
    {
        $sql = "UPDATE adg_news SET
                    title       = :title,
                    content     = :content,
                    image_url   = :image_url,
                    source_news = :source_news,
                    id_user     = :id_user
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM adg_news WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // ========================================================
    // VALIDATION
    // ========================================================

    public function titleExists(string $title, int $excludeId = 0): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM adg_news WHERE title = :title AND id != :id");
        $stmt->execute([':title' => $title, ':id' => $excludeId]);
        return $stmt->fetchColumn() > 0;
    }

    public function userExists(int $id): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM adg_users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchColumn() > 0;
    }
}
