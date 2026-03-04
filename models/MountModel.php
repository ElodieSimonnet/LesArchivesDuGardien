<?php

/**
 * ============================================================
 * MODÈLE : MountModel
 * ============================================================
 * Rôle : Toutes les requêtes SQL liées aux montures.
 *
 * Ce fichier ne contient QUE des interactions avec la BDD.
 * Aucun HTML, aucune logique de validation ici.
 * ============================================================
 */

class MountModel
{
    private PDO $db;

    public function __construct()
    {
        // On récupère la connexion PDO depuis la classe Database
        $this->db = Database::getConnection();
    }

    // ========================================================
    // LECTURE - Pages publiques
    // ========================================================

    /**
     * Récupère toutes les montures avec le statut "possédée"
     * et "en wishlist" pour l'utilisateur connecté.
     * Utilisé par la page mount_list.php.
     */
    public function getAll(int $userId = 0): array
    {
        $sql = "SELECT
                    adg_mounts.*,
                    adg_expansions.expansion,
                    adg_factions.faction,
                    adg_sources.source,
                    adg_difficulties.difficulty,
                    adg_mount_types.type,
                    CASE WHEN um.id IS NOT NULL THEN 1 ELSE 0 END AS is_owned,
                    CASE WHEN wm.id IS NOT NULL THEN 1 ELSE 0 END AS is_wishlisted
                FROM adg_mounts
                INNER JOIN adg_expansions   ON adg_mounts.id_expansion  = adg_expansions.id
                INNER JOIN adg_factions     ON adg_mounts.id_faction    = adg_factions.id
                INNER JOIN adg_sources      ON adg_mounts.id_source     = adg_sources.id
                INNER JOIN adg_difficulties ON adg_mounts.id_difficulty = adg_difficulties.id
                INNER JOIN adg_mount_types  ON adg_mounts.id_type       = adg_mount_types.id
                LEFT JOIN adg_user_mounts um ON adg_mounts.id = um.id_mount AND um.id_user = :user_id
                LEFT JOIN adg_wishlist_mounts wm ON adg_mounts.id = wm.id_mount AND wm.id_user = :user_id2
                ORDER BY adg_mounts.name ASC";

        $query = $this->db->prepare($sql);
        $query->execute([':user_id' => $userId, ':user_id2' => $userId]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une seule monture par son ID, avec toutes ses informations.
     * Utilisé par la page mount_detail.php.
     */
    public function getById(int $id, int $userId = 0): ?array
    {
        $sql = "SELECT
                    adg_mounts.*,
                    adg_expansions.expansion,
                    adg_factions.faction,
                    adg_sources.source,
                    adg_difficulties.difficulty,
                    adg_mount_types.type,
                    adg_targets.target,
                    adg_zones.zone,
                    adg_currencies.name AS currency_name,
                    CASE WHEN um.id IS NOT NULL THEN 1 ELSE 0 END AS is_owned,
                    CASE WHEN wm.id IS NOT NULL THEN 1 ELSE 0 END AS is_wishlisted
                FROM adg_mounts
                INNER JOIN adg_expansions   ON adg_mounts.id_expansion  = adg_expansions.id
                INNER JOIN adg_factions     ON adg_mounts.id_faction    = adg_factions.id
                INNER JOIN adg_sources      ON adg_mounts.id_source     = adg_sources.id
                INNER JOIN adg_difficulties ON adg_mounts.id_difficulty = adg_difficulties.id
                INNER JOIN adg_mount_types  ON adg_mounts.id_type       = adg_mount_types.id
                LEFT JOIN adg_zones         ON adg_mounts.id_zone       = adg_zones.id_zone
                LEFT JOIN adg_targets       ON adg_mounts.id_target     = adg_targets.id
                LEFT JOIN adg_currencies    ON adg_mounts.id_currency   = adg_currencies.id
                LEFT JOIN adg_user_mounts um ON adg_mounts.id = um.id_mount AND um.id_user = :user_id
                LEFT JOIN adg_wishlist_mounts wm ON adg_mounts.id = wm.id_mount AND wm.id_user = :user_id2
                WHERE adg_mounts.id = :id";

        $query = $this->db->prepare($sql);
        $query->execute([':id' => $id, ':user_id' => $userId, ':user_id2' => $userId]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    // ========================================================
    // LECTURE - Listes pour les filtres et menus déroulants
    // ========================================================

    public function getExpansions(): array
    {
        return $this->db->query("SELECT * FROM adg_expansions ORDER BY expansion ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFactions(): array
    {
        return $this->db->query("SELECT * FROM adg_factions ORDER BY faction ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSources(): array
    {
        return $this->db->query("SELECT * FROM adg_sources ORDER BY source ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTypes(): array
    {
        return $this->db->query("SELECT * FROM adg_mount_types ORDER BY type ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDifficulties(): array
    {
        return $this->db->query("SELECT * FROM adg_difficulties ORDER BY difficulty ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getZones(): array
    {
        return $this->db->query("SELECT * FROM adg_zones ORDER BY zone ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTargets(): array
    {
        return $this->db->query("SELECT * FROM adg_targets ORDER BY target ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCurrencies(): array
    {
        return $this->db->query("SELECT * FROM adg_currencies ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    // ========================================================
    // LECTURE - Admin
    // ========================================================

    /**
     * Récupère toutes les montures pour l'interface admin,
     * avec support des filtres GET optionnels.
     */
    public function getAllForAdmin(array $filters = []): array
    {
        $sql = "SELECT
                    adg_mounts.*,
                    adg_expansions.expansion,
                    adg_factions.faction,
                    adg_sources.source,
                    adg_difficulties.difficulty,
                    adg_mount_types.type
                FROM adg_mounts
                INNER JOIN adg_expansions   ON adg_mounts.id_expansion  = adg_expansions.id
                INNER JOIN adg_factions     ON adg_mounts.id_faction    = adg_factions.id
                INNER JOIN adg_sources      ON adg_mounts.id_source     = adg_sources.id
                INNER JOIN adg_difficulties ON adg_mounts.id_difficulty = adg_difficulties.id
                INNER JOIN adg_mount_types  ON adg_mounts.id_type       = adg_mount_types.id";

        $conditions = [];
        $params = [];
        $paramIndex = 0;

        $this->addMultiFilter('adg_mount_types.type', 'type', $filters, $conditions, $params, $paramIndex);
        $this->addMultiFilter('adg_sources.source', 'source', $filters, $conditions, $params, $paramIndex);
        $this->addMultiFilter('adg_expansions.expansion', 'expansion', $filters, $conditions, $params, $paramIndex);
        $this->addMultiFilter('adg_factions.faction', 'faction', $filters, $conditions, $params, $paramIndex);
        $this->addMultiFilter('adg_difficulties.difficulty', 'difficulty', $filters, $conditions, $params, $paramIndex);

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY adg_mounts.id ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une monture brute par ID (pour le formulaire d'édition admin).
     */
    public function getRawById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM adg_mounts WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    // ========================================================
    // ÉCRITURE - Créer / Modifier / Supprimer
    // ========================================================

    /**
     * Crée une nouvelle monture en base de données.
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO adg_mounts
                    (name, description, image, id_type, id_source, id_expansion, id_faction, id_difficulty, droprate, cost, id_currency, id_zone, id_target)
                VALUES
                    (:name, :description, :image, :id_type, :id_source, :id_expansion, :id_faction, :id_difficulty, :droprate, :cost, :id_currency, :id_zone, :id_target)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Modifie une monture existante.
     */
    public function update(array $data): bool
    {
        $sql = "UPDATE adg_mounts SET
                    name         = :name,
                    description  = :description,
                    image        = :image,
                    id_type      = :id_type,
                    id_source    = :id_source,
                    id_expansion = :id_expansion,
                    id_faction   = :id_faction,
                    id_difficulty = :id_difficulty,
                    droprate     = :droprate,
                    cost         = :cost,
                    id_currency  = :id_currency,
                    id_zone      = :id_zone,
                    id_target    = :id_target
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Supprime une monture par son ID.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM adg_mounts WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // ========================================================
    // VALIDATION
    // ========================================================

    /**
     * Vérifie si un nom de monture existe déjà (pour éviter les doublons).
     * Si $excludeId est fourni, on ignore cette monture (utile pour l'édition).
     */
    public function nameExists(string $name, int $excludeId = 0): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM adg_mounts WHERE name = :name AND id != :id");
        $stmt->execute([':name' => $name, ':id' => $excludeId]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Vérifie si un ID existe dans une table donnée.
     * Utilisé pour valider les clés étrangères (type, source, etc.).
     */
    public function idExistsInTable(string $table, int $id): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM $table WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchColumn() > 0;
    }

    // ========================================================
    // MÉTHODE PRIVÉE - Aide pour les filtres admin
    // ========================================================

    /**
     * Ajoute une condition de filtre multi-valeurs à la requête SQL.
     */
    private function addMultiFilter(string $column, string $key, array $filters, array &$conditions, array &$params, int &$paramIndex): void
    {
        $values = isset($filters[$key]) ? (array) $filters[$key] : [];
        $values = array_filter($values, fn($v) => $v !== '' && $v !== 'all');

        if (!empty($values)) {
            $placeholders = [];
            foreach ($values as $value) {
                $paramKey = ":{$key}_{$paramIndex}";
                $placeholders[] = "LOWER({$column}) = LOWER({$paramKey})";
                $params[$paramKey] = $value;
                $paramIndex++;
            }
            $conditions[] = '(' . implode(' OR ', $placeholders) . ')';
        }
    }
}
