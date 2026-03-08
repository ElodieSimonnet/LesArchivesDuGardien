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
        $query = $this->db->prepare(
            "SELECT adg_users.*, adg_users_status.status
             FROM adg_users
             INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id
             WHERE adg_users.id = ?"
        );
        $query->execute([$id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getCollectionCounts(int $userId): array
    {
        $queryOwnedMounts = $this->db->prepare("SELECT COUNT(*) FROM adg_user_mounts WHERE id_user = ?");
        $queryOwnedMounts->execute([$userId]);

        $queryTotalMounts = $this->db->query("SELECT COUNT(*) FROM adg_mounts");

        $queryOwnedPets = $this->db->prepare("SELECT COUNT(*) FROM adg_user_pets WHERE id_user = ?");
        $queryOwnedPets->execute([$userId]);

        $queryTotalPets = $this->db->query("SELECT COUNT(*) FROM adg_pets");

        return [
            'countOwnedMounts' => $queryOwnedMounts->fetchColumn(),
            'countTotalMounts' => $queryTotalMounts->fetchColumn(),
            'countOwnedPets'   => $queryOwnedPets->fetchColumn(),
            'countTotalPets'   => $queryTotalPets->fetchColumn(),
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

        $query = $this->db->prepare($sql);
        $query->execute($params);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByIdWithDetails(int $id): ?array
    {
        $query = $this->db->prepare(
            "SELECT adg_users.*, adg_roles.role_name, adg_users_status.status
             FROM adg_users
             INNER JOIN adg_roles ON adg_users.id_role = adg_roles.id
             INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id
             WHERE adg_users.id = :id"
        );
        $query->execute([':id' => $id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getRawById(int $id): ?array
    {
        $query = $this->db->prepare("SELECT * FROM adg_users WHERE id = :id");
        $query->execute([':id' => $id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getDashboardStats(): array
    {
        $queryTotal = $this->db->query("SELECT COUNT(*) FROM adg_users");
        $totalUsers = $queryTotal->fetchColumn();

        $queryActive = $this->db->prepare(
            "SELECT COUNT(*) FROM adg_users
             INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id
             WHERE adg_users_status.status = :status"
        );
        $queryActive->execute([':status' => 'Actif']);
        $activeUsers = $queryActive->fetchColumn();

        $querySuspended = $this->db->prepare(
            "SELECT COUNT(*) FROM adg_users
             INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id
             WHERE adg_users_status.status = :status"
        );
        $querySuspended->execute([':status' => 'Suspendu']);
        $suspendedUsers = $querySuspended->fetchColumn();

        $queryBanned = $this->db->prepare(
            "SELECT COUNT(*) FROM adg_users
             INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id
             WHERE adg_users_status.status = :status"
        );
        $queryBanned->execute([':status' => 'Banni']);
        $bannedUsers = $queryBanned->fetchColumn();

        $queryLast = $this->db->prepare(
            "SELECT username, email FROM adg_users ORDER BY id DESC LIMIT 5"
        );
        $queryLast->execute();
        $lastUsers = $queryLast->fetchAll(PDO::FETCH_ASSOC);

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
        $query = $this->db->prepare($sql);
        return $query->execute($data);
    }

    public function update(array $data): bool
    {
        $sql = "UPDATE adg_users SET
                    username  = :username,
                    email     = :email,
                    id_role   = :id_role,
                    id_status = :id_status
                WHERE id = :id";
        $query = $this->db->prepare($sql);
        return $query->execute($data);
    }

    public function delete(int $id): bool
    {
        $this->db->prepare("DELETE FROM adg_user_mounts WHERE id_user = ?")->execute([$id]);
        $this->db->prepare("DELETE FROM adg_user_pets WHERE id_user = ?")->execute([$id]);
        $this->db->prepare("DELETE FROM adg_wishlist_mounts WHERE id_user = ?")->execute([$id]);
        $this->db->prepare("DELETE FROM adg_wishlist_pets WHERE id_user = ?")->execute([$id]);
        $this->db->prepare("UPDATE adg_news SET id_user = NULL WHERE id_user = ?")->execute([$id]);

        $query = $this->db->prepare("DELETE FROM adg_users WHERE id = :id");
        return $query->execute([':id' => $id]);
    }

    public function usernameExists(string $username, int $excludeId = 0): bool
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM adg_users WHERE username = :username AND id != :id");
        $query->execute([':username' => $username, ':id' => $excludeId]);
        return $query->fetchColumn() > 0;
    }

    public function emailExists(string $email, int $excludeId = 0): bool
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM adg_users WHERE email = :email AND id != :id");
        $query->execute([':email' => $email, ':id' => $excludeId]);
        return $query->fetchColumn() > 0;
    }

    public function roleExists(int $id): bool
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM adg_roles WHERE id = :id");
        $query->execute([':id' => $id]);
        return $query->fetchColumn() > 0;
    }

    public function statusExists(int $id): bool
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM adg_users_status WHERE id = :id");
        $query->execute([':id' => $id]);
        return $query->fetchColumn() > 0;
    }

    public function findByIdentifier(string $identifier): ?array
    {
        $query = $this->db->prepare(
            "SELECT adg_users.*, adg_users_status.status, adg_roles.role_name
             FROM adg_users
             INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id
             INNER JOIN adg_roles ON adg_users.id_role = adg_roles.id
             WHERE adg_users.username = ? OR adg_users.email = ?"
        );
        $query->execute([$identifier, $identifier]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function findAdminByIdentifier(string $identifier): ?array
    {
        $query = $this->db->prepare(
            "SELECT adg_users.*, adg_roles.role_name
             FROM adg_users
             INNER JOIN adg_roles ON adg_users.id_role = adg_roles.id
             WHERE adg_users.username = ? OR adg_users.email = ?"
        );
        $query->execute([$identifier, $identifier]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function resetFailedAttempts(int $id): void
    {
        $this->db->prepare("UPDATE adg_users SET failed_attempts = 0, locked_until = NULL, last_activity = NOW() WHERE id = ?")
            ->execute([$id]);
    }

    public function updateFailedAttempts(int $id, int $attempts, ?string $lockedUntil = null): void
    {
        if ($lockedUntil !== null) {
            $this->db->prepare("UPDATE adg_users SET failed_attempts = ?, locked_until = ? WHERE id = ?")
                ->execute([$attempts, $lockedUntil, $id]);
        } else {
            $this->db->prepare("UPDATE adg_users SET failed_attempts = ? WHERE id = ?")
                ->execute([$attempts, $id]);
        }
    }

    public function register(string $username, string $email, string $hashedPassword): int
    {
        $this->db->prepare("INSERT INTO adg_users (username, email, password) VALUES (?, ?, ?)")
            ->execute([$username, $email, $hashedPassword]);
        return (int) $this->db->lastInsertId();
    }

    public function updateEmail(int $id, string $email): void
    {
        $this->db->prepare("UPDATE adg_users SET email = ? WHERE id = ?")
            ->execute([$email, $id]);
    }

    public function updateUsername(int $id, string $username): void
    {
        $this->db->prepare("UPDATE adg_users SET username = ? WHERE id = ?")
            ->execute([$username, $id]);
    }

    public function updatePassword(int $id, string $hashedPassword): void
    {
        $this->db->prepare("UPDATE adg_users SET password = ? WHERE id = ?")
            ->execute([$hashedPassword, $id]);
    }

    public function updateAvatar(int $id, ?string $path): void
    {
        $this->db->prepare("UPDATE adg_users SET avatar = ? WHERE id = ?")
            ->execute([$path, $id]);
    }

    public function getAvatar(int $id): ?string
    {
        $query = $this->db->prepare("SELECT avatar FROM adg_users WHERE id = ?");
        $query->execute([$id]);
        $result = $query->fetchColumn();
        return $result ?: null;
    }

    public function toggleCollection(int $userId, string $type, int $itemId): string
    {
        $table  = $type === 'mount' ? 'adg_user_mounts' : 'adg_user_pets';
        $column = $type === 'mount' ? 'id_mount' : 'id_pet';

        $check = $this->db->prepare("SELECT id FROM $table WHERE id_user = ? AND $column = ?");
        $check->execute([$userId, $itemId]);

        if ($check->fetch()) {
            $this->db->prepare("DELETE FROM $table WHERE id_user = ? AND $column = ?")->execute([$userId, $itemId]);
            return 'removed';
        }

        $this->db->prepare("INSERT INTO $table (id_user, $column) VALUES (?, ?)")->execute([$userId, $itemId]);
        return 'added';
    }

    public function toggleWishlist(int $userId, string $type, int $itemId): string
    {
        $table  = $type === 'mount' ? 'adg_wishlist_mounts' : 'adg_wishlist_pets';
        $column = $type === 'mount' ? 'id_mount' : 'id_pet';

        $check = $this->db->prepare("SELECT id FROM $table WHERE id_user = ? AND $column = ?");
        $check->execute([$userId, $itemId]);

        if ($check->fetch()) {
            $this->db->prepare("DELETE FROM $table WHERE id_user = ? AND $column = ?")->execute([$userId, $itemId]);
            return 'removed';
        }

        $this->db->prepare("INSERT INTO $table (id_user, $column, added_at) VALUES (?, ?, NOW())")->execute([$userId, $itemId]);
        return 'added';
    }
}
