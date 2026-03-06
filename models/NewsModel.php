<?php

class NewsModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getCarouselNews(): array
    {
        $sql = "SELECT adg_news.id, adg_news.title, adg_news.content, adg_news.image_url, adg_news.source_news, adg_news.created_at, adg_users.username AS author
                FROM adg_news
                LEFT JOIN adg_users ON adg_news.id_user = adg_users.id
                ORDER BY adg_news.created_at DESC
                LIMIT 3";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListNews(): array
    {
        $sql = "SELECT adg_news.id, adg_news.title, adg_news.content, adg_news.image_url, adg_news.source_news, adg_news.created_at, adg_users.username AS author
                FROM adg_news
                LEFT JOIN adg_users ON adg_news.id_user = adg_users.id
                ORDER BY adg_news.created_at DESC
                LIMIT 1000 OFFSET 3";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll(): array
    {
        $sql = "SELECT adg_news.*, adg_users.username AS author
                FROM adg_news
                LEFT JOIN adg_users ON adg_news.id_user = adg_users.id
                ORDER BY adg_news.id ASC";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $sql = "SELECT adg_news.*, adg_users.username AS author
                FROM adg_news
                LEFT JOIN adg_users ON adg_news.id_user = adg_users.id
                WHERE adg_news.id = :id";

        $query = $this->db->prepare($sql);
        $query->execute([':id' => $id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getRawById(int $id): ?array
    {
        $query = $this->db->prepare("SELECT * FROM adg_news WHERE id = :id");
        $query->execute([':id' => $id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getAdminUsers(): array
    {
        $query = $this->db->query("SELECT id, username FROM adg_users WHERE id_role = 2 ORDER BY username ASC");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO adg_news (title, content, image_url, source_news, id_user)
                VALUES (:title, :content, :image_url, :source_news, :id_user)";

        $query = $this->db->prepare($sql);
        return $query->execute($data);
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

        $query = $this->db->prepare($sql);
        return $query->execute($data);
    }

    public function delete(int $id): bool
    {
        $query = $this->db->prepare("DELETE FROM adg_news WHERE id = :id");
        return $query->execute([':id' => $id]);
    }

    public function titleExists(string $title, int $excludeId = 0): bool
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM adg_news WHERE title = :title AND id != :id");
        $query->execute([':title' => $title, ':id' => $excludeId]);
        return $query->fetchColumn() > 0;
    }

    public function userExists(int $id): bool
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM adg_users WHERE id = :id");
        $query->execute([':id' => $id]);
        return $query->fetchColumn() > 0;
    }
}
