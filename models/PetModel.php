<?php

class PetModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

public function getAll(int $userId = 0): array
    {
        $sql = "SELECT
                    adg_pets.*,
                    adg_pet_families.family,
                    adg_expansions.expansion,
                    adg_factions.faction,
                    adg_sources.source,
                    CASE WHEN up.id IS NOT NULL THEN 1 ELSE 0 END AS is_owned,
                    CASE WHEN wp.id IS NOT NULL THEN 1 ELSE 0 END AS is_wishlisted
                FROM adg_pets
                INNER JOIN adg_pet_families ON adg_pets.id_family    = adg_pet_families.id
                INNER JOIN adg_expansions   ON adg_pets.id_expansion = adg_expansions.id
                INNER JOIN adg_factions     ON adg_pets.id_faction   = adg_factions.id
                INNER JOIN adg_sources      ON adg_pets.id_source    = adg_sources.id
                LEFT JOIN adg_user_pets up ON adg_pets.id = up.id_pet AND up.id_user = :user_id
                LEFT JOIN adg_wishlist_pets wp ON adg_pets.id = wp.id_pet AND wp.id_user = :user_id2
                ORDER BY adg_pets.name ASC";

        $query = $this->db->prepare($sql);
        $query->execute([':user_id' => $userId, ':user_id2' => $userId]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

public function getById(int $id, int $userId = 0): ?array
    {
        $sql = "SELECT
                    adg_pets.*,
                    adg_pet_families.family,
                    adg_expansions.expansion,
                    adg_factions.faction,
                    adg_sources.source,
                    adg_zones.zone,
                    adg_currencies.name AS currency_name,
                    adg_targets.target,
                    CASE WHEN up.id IS NOT NULL THEN 1 ELSE 0 END AS is_owned,
                    CASE WHEN wp.id IS NOT NULL THEN 1 ELSE 0 END AS is_wishlisted
                FROM adg_pets
                INNER JOIN adg_pet_families ON adg_pets.id_family    = adg_pet_families.id
                INNER JOIN adg_expansions   ON adg_pets.id_expansion = adg_expansions.id
                INNER JOIN adg_factions     ON adg_pets.id_faction   = adg_factions.id
                INNER JOIN adg_sources      ON adg_pets.id_source    = adg_sources.id
                LEFT JOIN adg_zones         ON adg_pets.id_zone      = adg_zones.id_zone
                LEFT JOIN adg_currencies    ON adg_pets.id_currency  = adg_currencies.id
                LEFT JOIN adg_targets       ON adg_pets.id_target    = adg_targets.id
                LEFT JOIN adg_user_pets up ON adg_pets.id = up.id_pet AND up.id_user = :user_id
                LEFT JOIN adg_wishlist_pets wp ON adg_pets.id = wp.id_pet AND wp.id_user = :user_id2
                WHERE adg_pets.id = :id";

        $query = $this->db->prepare($sql);
        $query->execute([':id' => $id, ':user_id' => $userId, ':user_id2' => $userId]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

public function getSpellsForPet(array $pet): array
    {
        $petSpells = [];
        for ($i = 1; $i <= 6; $i++) {
            $spellId = $pet['spell_' . $i] ?? null;
            if (!empty($spellId)) {
                $stmt = $this->db->prepare("SELECT * FROM adg_pet_spells WHERE id = :id");
                $stmt->execute([':id' => $spellId]);
                $petSpells[$i] = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
            } else {
                $petSpells[$i] = null;
            }
        }
        return $petSpells;
    }

public function getFamilies(): array
    {
        return $this->db->query("SELECT * FROM adg_pet_families ORDER BY family ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

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

    public function getZones(): array
    {
        return $this->db->query("SELECT * FROM adg_zones ORDER BY zone ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCurrencies(): array
    {
        return $this->db->query("SELECT * FROM adg_currencies ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSpells(): array
    {
        return $this->db->query("SELECT * FROM adg_pet_spells ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTargets(): array
    {
        return $this->db->query("SELECT * FROM adg_targets ORDER BY target ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

public function getAllForAdmin(array $filters = []): array
    {
        $sql = "SELECT
                    adg_pets.*,
                    adg_pet_families.family,
                    adg_expansions.expansion,
                    adg_factions.faction,
                    adg_sources.source
                FROM adg_pets
                INNER JOIN adg_pet_families ON adg_pets.id_family    = adg_pet_families.id
                INNER JOIN adg_expansions   ON adg_pets.id_expansion = adg_expansions.id
                INNER JOIN adg_factions     ON adg_pets.id_faction   = adg_factions.id
                INNER JOIN adg_sources      ON adg_pets.id_source    = adg_sources.id";

        $conditions = [];
        $params = [];
        $paramIndex = 0;

        $this->addMultiFilter('adg_pet_families.family', 'family', $filters, $conditions, $params, $paramIndex);
        $this->addMultiFilter('adg_sources.source', 'source', $filters, $conditions, $params, $paramIndex);
        $this->addMultiFilter('adg_expansions.expansion', 'expansion', $filters, $conditions, $params, $paramIndex);
        $this->addMultiFilter('adg_factions.faction', 'faction', $filters, $conditions, $params, $paramIndex);

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY adg_pets.id ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function getRawById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM adg_pets WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

public function create(array $data): bool
    {
        $sql = "INSERT INTO adg_pets
                    (name, description, image, id_family, id_source, id_expansion, id_faction,
                     droprate, cost, id_zone, id_currency, id_target,
                     spell_1, spell_2, spell_3, spell_4, spell_5, spell_6)
                VALUES
                    (:name, :description, :image, :id_family, :id_source, :id_expansion, :id_faction,
                     :droprate, :cost, :id_zone, :id_currency, :id_target,
                     :spell_1, :spell_2, :spell_3, :spell_4, :spell_5, :spell_6)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update(array $data): bool
    {
        $sql = "UPDATE adg_pets SET
                    name         = :name,
                    description  = :description,
                    image        = :image,
                    id_family    = :id_family,
                    id_source    = :id_source,
                    id_expansion = :id_expansion,
                    id_faction   = :id_faction,
                    droprate     = :droprate,
                    cost         = :cost,
                    id_zone      = :id_zone,
                    id_currency  = :id_currency,
                    id_target    = :id_target,
                    spell_1      = :spell_1,
                    spell_2      = :spell_2,
                    spell_3      = :spell_3,
                    spell_4      = :spell_4,
                    spell_5      = :spell_5,
                    spell_6      = :spell_6
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM adg_pets WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

public function nameExists(string $name, int $excludeId = 0): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM adg_pets WHERE name = :name AND id != :id");
        $stmt->execute([':name' => $name, ':id' => $excludeId]);
        return $stmt->fetchColumn() > 0;
    }

    public function idExistsInTable(string $table, int $id): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM $table WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchColumn() > 0;
    }

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
