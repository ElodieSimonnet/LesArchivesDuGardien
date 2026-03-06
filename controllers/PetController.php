<?php

class PetController
{
    private PetModel $model;

private array $familyIcons = [
        'Élémentaire' => 'elem',
        'Aquatique'   => 'aquatic',
        'Humanoïde'   => 'humanoid',
        'Magique'     => 'magic',
        'Machine'     => 'mechanical',
        'Mort-vivant' => 'undead',
        'Bête'        => 'beast',
        'Aérien'      => 'flying',
        'Bestiole'    => 'critter',
        'Draconien'   => 'dragonkin',
    ];

    public function __construct()
    {
        $this->model = new PetModel();
    }

    public function list(): void
    {
        $userId    = $_SESSION['user_id'] ?? 0;
        $pets      = $this->model->getAll($userId);
        $families  = $this->model->getFamilies();
        $expansions = $this->model->getExpansions();
        $factions  = $this->model->getFactions();
        $sources   = $this->model->getSources();

        require __DIR__ . '/../views/pet_list.php';
    }

    public function detail(): void
    {
        $id     = (int) ($_GET['id'] ?? 0);
        $userId = $_SESSION['user_id'] ?? 0;
        $pet    = $this->model->getById($id, $userId);

        if (!$pet) {
            header('Location: pet_list.php');
            exit;
        }

        $petFamilyIcon = 'assets/images/pets/' . ($this->familyIcons[$pet['family']] ?? 'critter') . '.webp';
        $petSpells     = $this->model->getSpellsForPet($pet);
        $isOwnedPet      = (bool) ($pet['is_owned'] ?? false);
        $isWishlistedPet = (bool) ($pet['is_wishlisted'] ?? false);

        require __DIR__ . '/../views/pet_detail.php';
    }

    public function adminList(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        $filters  = $_GET;
        $all_pets = $this->model->getAllForAdmin($filters);

$all_families      = $this->model->getFamilies();
        $all_pet_sources   = $this->model->getSources();
        $all_pet_expansions = $this->model->getExpansions();
        $all_pet_factions  = $this->model->getFactions();

        require __DIR__ . '/../views/admin/pet_management.php';
    }

    public function showAddForm(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        $all_families  = $this->model->getFamilies();
        $all_sources   = $this->model->getSources();
        $all_expansions = $this->model->getExpansions();
        $all_factions  = $this->model->getFactions();
        $all_zones     = $this->model->getZones();
        $all_currencies = $this->model->getCurrencies();
        $all_spells    = $this->model->getSpells();
        $all_targets   = $this->model->getTargets();

        require __DIR__ . '/../views/admin/add_pet.php';
    }

    public function showEditForm(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        $pet_id = (int) ($_GET['id'] ?? 0);
        if (!$pet_id) {
            header('Location: pet_management.php');
            exit;
        }

        $pet = $this->model->getRawById($pet_id);
        if (!$pet) {
            header('Location: pet_management.php');
            exit;
        }

        $all_families  = $this->model->getFamilies();
        $all_sources   = $this->model->getSources();
        $all_expansions = $this->model->getExpansions();
        $all_factions  = $this->model->getFactions();
        $all_zones     = $this->model->getZones();
        $all_currencies = $this->model->getCurrencies();
        $all_spells    = $this->model->getSpells();
        $all_targets   = $this->model->getTargets();

        require __DIR__ . '/../views/admin/edit_pet.php';
    }

    public function adminView(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        $pet_id = (int) ($_GET['id'] ?? 0);
        if (!$pet_id) {
            header('Location: pet_management.php');
            exit;
        }

        $pet = $this->model->getById($pet_id);
        if (!$pet) {
            header('Location: pet_management.php');
            exit;
        }

        $petSpells = $this->model->getSpellsForPet($pet);

        require __DIR__ . '/../views/admin/view_pet.php';
    }

    public function create(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: add_pet.php');
            exit;
        }

        $name        = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $image       = trim($_POST['image'] ?? '');
        $id_family   = (int) ($_POST['id_family'] ?? 0);
        $id_source   = (int) ($_POST['id_source'] ?? 0);
        $id_expansion = (int) ($_POST['id_expansion'] ?? 0);
        $id_faction  = (int) ($_POST['id_faction'] ?? 0);
        $droprate    = (isset($_POST['droprate']) && $_POST['droprate'] !== '') ? (float) $_POST['droprate'] : null;
        $cost        = (isset($_POST['cost']) && $_POST['cost'] !== '') ? (int) $_POST['cost'] : null;
        $id_zone     = !empty($_POST['id_zone'])     ? (int) $_POST['id_zone']     : null;
        $id_currency = !empty($_POST['id_currency']) ? (int) $_POST['id_currency'] : null;
        $id_target   = !empty($_POST['id_target'])   ? (int) $_POST['id_target']   : null;
        $spells = [];
        for ($i = 1; $i <= 6; $i++) {
            $spells[$i] = !empty($_POST['spell_' . $i]) ? (int) $_POST['spell_' . $i] : null;
        }

        if (empty($name)) {
            set_flash('error', 'Le nom de la mascotte est obligatoire.');
            header('Location: add_pet.php');
            exit;
        }

        if (!$this->model->idExistsInTable('adg_pet_families', $id_family)) {
            set_flash('error', 'La famille sélectionnée est invalide.');
            header('Location: add_pet.php');
            exit;
        }
        if (!$this->model->idExistsInTable('adg_sources', $id_source)) {
            set_flash('error', 'La source sélectionnée est invalide.');
            header('Location: add_pet.php');
            exit;
        }
        if (!$this->model->idExistsInTable('adg_expansions', $id_expansion)) {
            set_flash('error', "L'extension sélectionnée est invalide.");
            header('Location: add_pet.php');
            exit;
        }
        if (!$this->model->idExistsInTable('adg_factions', $id_faction)) {
            set_flash('error', 'La faction sélectionnée est invalide.');
            header('Location: add_pet.php');
            exit;
        }

        if ($this->model->nameExists($name)) {
            set_flash('error', 'Une mascotte avec ce nom existe déjà.');
            header('Location: add_pet.php');
            exit;
        }

        try {
            $this->model->create([
                ':name'        => $name,
                ':description' => $description,
                ':image'       => $image,
                ':id_family'   => $id_family,
                ':id_source'   => $id_source,
                ':id_expansion' => $id_expansion,
                ':id_faction'  => $id_faction,
                ':droprate'    => $droprate,
                ':cost'        => $cost,
                ':id_zone'     => $id_zone,
                ':id_currency' => $id_currency,
                ':id_target'   => $id_target,
                ':spell_1'     => $spells[1],
                ':spell_2'     => $spells[2],
                ':spell_3'     => $spells[3],
                ':spell_4'     => $spells[4],
                ':spell_5'     => $spells[5],
                ':spell_6'     => $spells[6],
            ]);
            set_flash('success', 'Mascotte créée avec succès !');
            header('Location: pet_management.php');
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'Une erreur est survenue lors de la création.');
            header('Location: add_pet.php');
            exit;
        }
    }

    public function update(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: pet_management.php');
            exit;
        }

        $pet_id      = (int) ($_POST['pet_id'] ?? 0);
        $name        = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $image       = trim($_POST['image'] ?? '');
        $id_family   = (int) ($_POST['id_family'] ?? 0);
        $id_source   = (int) ($_POST['id_source'] ?? 0);
        $id_expansion = (int) ($_POST['id_expansion'] ?? 0);
        $id_faction  = (int) ($_POST['id_faction'] ?? 0);
        $droprate    = (isset($_POST['droprate']) && $_POST['droprate'] !== '') ? (float) $_POST['droprate'] : null;
        $cost        = (isset($_POST['cost']) && $_POST['cost'] !== '') ? (int) $_POST['cost'] : null;
        $id_zone     = !empty($_POST['id_zone'])     ? (int) $_POST['id_zone']     : null;
        $id_currency = !empty($_POST['id_currency']) ? (int) $_POST['id_currency'] : null;
        $id_target   = !empty($_POST['id_target'])   ? (int) $_POST['id_target']   : null;
        $spells = [];
        for ($i = 1; $i <= 6; $i++) {
            $spells[$i] = !empty($_POST['spell_' . $i]) ? (int) $_POST['spell_' . $i] : null;
        }

        if (empty($name)) {
            set_flash('error', 'Le nom de la mascotte est obligatoire.');
            header("Location: edit_pet.php?id={$pet_id}");
            exit;
        }

        if (!$this->model->idExistsInTable('adg_pet_families', $id_family)) {
            set_flash('error', 'La famille sélectionnée est invalide.');
            header("Location: edit_pet.php?id={$pet_id}");
            exit;
        }
        if (!$this->model->idExistsInTable('adg_sources', $id_source)) {
            set_flash('error', 'La source sélectionnée est invalide.');
            header("Location: edit_pet.php?id={$pet_id}");
            exit;
        }
        if (!$this->model->idExistsInTable('adg_expansions', $id_expansion)) {
            set_flash('error', "L'extension sélectionnée est invalide.");
            header("Location: edit_pet.php?id={$pet_id}");
            exit;
        }
        if (!$this->model->idExistsInTable('adg_factions', $id_faction)) {
            set_flash('error', 'La faction sélectionnée est invalide.');
            header("Location: edit_pet.php?id={$pet_id}");
            exit;
        }

        try {
            $this->model->update([
                ':id'          => $pet_id,
                ':name'        => $name,
                ':description' => $description,
                ':image'       => $image,
                ':id_family'   => $id_family,
                ':id_source'   => $id_source,
                ':id_expansion' => $id_expansion,
                ':id_faction'  => $id_faction,
                ':droprate'    => $droprate,
                ':cost'        => $cost,
                ':id_zone'     => $id_zone,
                ':id_currency' => $id_currency,
                ':id_target'   => $id_target,
                ':spell_1'     => $spells[1],
                ':spell_2'     => $spells[2],
                ':spell_3'     => $spells[3],
                ':spell_4'     => $spells[4],
                ':spell_5'     => $spells[5],
                ':spell_6'     => $spells[6],
            ]);
            set_flash('success', 'Mascotte mise à jour avec succès !');
            header('Location: pet_management.php');
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'Une erreur est survenue lors de la modification.');
            header("Location: edit_pet.php?id={$pet_id}");
            exit;
        }
    }

    public function delete(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: pet_management.php');
            exit;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: pet_management.php');
            exit;
        }

        $pet_id = (int) ($_POST['pet_id'] ?? -1);
        if ($pet_id < 0) {
            set_flash('error', 'Identifiant invalide.');
            header('Location: pet_management.php');
            exit;
        }

        try {
            $this->model->delete($pet_id);
            set_flash('success', 'Mascotte supprimée avec succès !');
            header('Location: pet_management.php');
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'Une erreur est survenue lors de la suppression.');
            header('Location: pet_management.php');
            exit;
        }
    }
}
