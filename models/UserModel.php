<?php

class UserModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT adg_users.*, adg_users_status.status
             FROM adg_users
             INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id
             WHERE adg_users.id = ?"
        );
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

public function getCollectionCounts(int $userId): array
    {
        $stmtOwnedMounts = $this->db->prepare("SELECT COUNT(*) FROM adg_user_mounts WHERE id_user = ?");
        $stmtOwnedMounts->execute([$userId]);

        $stmtTotalMounts = $this->db->query("SELECT COUNT(*) FROM adg_mounts");

        $stmtOwnedPets = $this->db->prepare("SELECT COUNT(*) FROM adg_user_pets WHERE id_user = ?");
        $stmtOwnedPets->execute([$userId]);

        $stmtTotalPets = $this->db->query("SELECT COUNT(*) FROM adg_pets");

        return [
            'countOwnedMounts' => $stmtOwnedMounts->fetchColumn(),
            'countTotalMounts' => $stmtTotalMounts->fetchColumn(),
            'countOwnedPets'   => $stmtOwnedPets->fetchColumn(),
            'countTotalPets'   => $stmtTotalPets->fetchColumn(),
        ];
    }

public function getAll(array $filters = []): array
    {
        $sql = "SELECT adg_users.*, adg_roles.role_name, adg_users_status.status
                FROM adg_users
                INNER JOIN adg_roles ON adg_users.id_role = adg_roles.id
                INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id";

        $conditions = [];
        $params = [];

        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $conditions[] = "LOWER(adg_users_status.status) = LOWER(:status)";
            $params[':status'] = $filters['status'];
        }

        if (!empty($filters['role']) && $filters['role'] !== 'all') {
            $conditions[] = "LOWER(adg_roles.role_name) = LOWER(:role)";
            $params[':role'] = $filters['role'];
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY adg_users.id ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function getByIdWithDetails(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT adg_users.*, adg_roles.role_name, adg_users_status.status
             FROM adg_users
             INNER JOIN adg_roles ON adg_users.id_role = adg_roles.id
             INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id
             WHERE adg_users.id = :id"
        );
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

public function getRawById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM adg_users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

public function getDashboardStats(): array
    {
        $stmtTotal = $this->db->query("SELECT COUNT(*) FROM adg_users");
        $totalUsers = $stmtTotal->fetchColumn();

        $stmtActive = $this->db->prepare(
            "SELECT COUNT(*) FROM adg_users
             INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id
             WHERE adg_users_status.status = :status"
        );
        $stmtActive->execute([':status' => 'Actif']);
        $activeUsers = $stmtActive->fetchColumn();

        $stmtSuspended = $this->db->prepare(
            "SELECT COUNT(*) FROM adg_users
             INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id
             WHERE adg_users_status.status = :status"
        );
        $stmtSuspended->execute([':status' => 'Suspendu']);
        $suspendedUsers = $stmtSuspended->fetchColumn();

        $stmtBanned = $this->db->prepare(
            "SELECT COUNT(*) FROM adg_users
             INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id
             WHERE adg_users_status.status = :status"
        );
        $stmtBanned->execute([':status' => 'Banni']);
        $bannedUsers = $stmtBanned->fetchColumn();

        $stmtLast = $this->db->prepare(
            "SELECT username, email FROM adg_users ORDER BY id DESC LIMIT 5"
        );
        $stmtLast->execute();
        $lastUsers = $stmtLast->fetchAll(PDO::FETCH_ASSOC);

        return compact('totalUsers', 'activeUsers', 'suspendedUsers', 'bannedUsers', 'lastUsers');
    }

public function getAllRoles(): array
    {
        return $this->db->query("SELECT * FROM adg_roles")->fetchAll(PDO::FETCH_ASSOC);
    }

public function getAllStatuses(): array
    {
        return $this->db->query("SELECT * FROM adg_users_status")->fetchAll(PDO::FETCH_ASSOC);
    }

public function create(array $data): bool
    {
        $sql = "INSERT INTO adg_users (username, email, password, id_role, id_status)
                VALUES (:username, :email, :password, :id_role, :id_status)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update(array $data): bool
    {
        $sql = "UPDATE adg_users SET
                    username  = :username,
                    email     = :email,
                    id_role   = :id_role,
                    id_status = :id_status
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $this->db->prepare("DELETE FROM adg_user_mounts WHERE id_user = ?")->execute([$id]);
        $this->db->prepare("DELETE FROM adg_user_pets WHERE id_user = ?")->execute([$id]);
        $this->db->prepare("DELETE FROM adg_wishlist_mounts WHERE id_user = ?")->execute([$id]);
        $this->db->prepare("DELETE FROM adg_wishlist_pets WHERE id_user = ?")->execute([$id]);
        $this->db->prepare("UPDATE adg_news SET id_user = NULL WHERE id_user = ?")->execute([$id]);

        $stmt = $this->db->prepare("DELETE FROM adg_users WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

public function usernameExists(string $username, int $excludeId = 0): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM adg_users WHERE username = :username AND id != :id");
        $stmt->execute([':username' => $username, ':id' => $excludeId]);
        return $stmt->fetchColumn() > 0;
    }

    public function emailExists(string $email, int $excludeId = 0): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM adg_users WHERE email = :email AND id != :id");
        $stmt->execute([':email' => $email, ':id' => $excludeId]);
        return $stmt->fetchColumn() > 0;
    }

    public function roleExists(int $id): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM adg_roles WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchColumn() > 0;
    }

    public function statusExists(int $id): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM adg_users_status WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchColumn() > 0;
    }
}
