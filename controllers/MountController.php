<?php

class MountController
{
    private MountModel $model;

    public function __construct()
    {
        $this->model = new MountModel();
    }

public function list(): void
    {
        $userId     = $_SESSION['user_id'] ?? 0;
        $mounts     = $this->model->getAll($userId);
        $expansions = $this->model->getExpansions();
        $factions   = $this->model->getFactions();
        $sources    = $this->model->getSources();
        $types      = $this->model->getTypes();

        require __DIR__ . '/../views/mount_list.php';
    }

public function detail(): void
    {
        $id    = (int) ($_GET['id'] ?? 0);
        $userId = $_SESSION['user_id'] ?? 0;
        $mount = $this->model->getById($id, $userId);

        if (!$mount) {
            header('Location: mount_list.php');
            exit;
        }

$mountTypeLink = 'assets/images/mounts/' . $mount['type'] . '.png';

$isOwnedMount     = (bool) ($mount['is_owned'] ?? false);
        $isWishlistedMount = (bool) ($mount['is_wishlisted'] ?? false);

        require __DIR__ . '/../views/mount_detail.php';
    }

public function adminList(): void
    {
        require_once __DIR__ . '/../components/utils/is_admin.php';
        restrictToAdmin();

        $filters    = $_GET;
        $all_mounts = $this->model->getAllForAdmin($filters);

$all_types       = $this->model->getTypes();
        $all_sources     = $this->model->getSources();
        $all_expansions  = $this->model->getExpansions();
        $all_factions    = $this->model->getFactions();
        $all_difficulties = $this->model->getDifficulties();

        require __DIR__ . '/../views/admin/mount_management.php';
    }

public function showAddForm(): void
    {
        require_once __DIR__ . '/../components/utils/is_admin.php';
        restrictToAdmin();

        $all_types       = $this->model->getTypes();
        $all_sources     = $this->model->getSources();
        $all_expansions  = $this->model->getExpansions();
        $all_factions    = $this->model->getFactions();
        $all_difficulties = $this->model->getDifficulties();
        $all_zones       = $this->model->getZones();
        $all_targets     = $this->model->getTargets();
        $all_currencies  = $this->model->getCurrencies();

        require __DIR__ . '/../views/admin/add_mount.php';
    }

public function showEditForm(): void
    {
        require_once __DIR__ . '/../components/utils/is_admin.php';
        restrictToAdmin();

        $mount_id = (int) ($_GET['id'] ?? 0);
        if (!$mount_id) {
            header('Location: mount_management.php');
            exit;
        }

        $mount = $this->model->getRawById($mount_id);
        if (!$mount) {
            header('Location: mount_management.php');
            exit;
        }

        $all_types       = $this->model->getTypes();
        $all_sources     = $this->model->getSources();
        $all_expansions  = $this->model->getExpansions();
        $all_factions    = $this->model->getFactions();
        $all_difficulties = $this->model->getDifficulties();
        $all_zones       = $this->model->getZones();
        $all_targets     = $this->model->getTargets();
        $all_currencies  = $this->model->getCurrencies();

        require __DIR__ . '/../views/admin/edit_mount.php';
    }

public function adminView(): void
    {
        require_once __DIR__ . '/../components/utils/is_admin.php';
        restrictToAdmin();

        $mount_id = (int) ($_GET['id'] ?? 0);
        if (!$mount_id) {
            header('Location: mount_management.php');
            exit;
        }

        $mount = $this->model->getById($mount_id);
        if (!$mount) {
            header('Location: mount_management.php');
            exit;
        }

        $difficultyColor = match(strtolower($mount['difficulty'])) {
            'facile'      => 'text-green-500',
            'moyen'       => 'text-orange-500',
            'difficile'   => 'text-red-500',
            'argent réel' => 'text-cyan-400',
            default       => 'text-a11y-gray',
        };

        require __DIR__ . '/../views/admin/view_mount.php';
    }

public function create(): void
    {
        require_once __DIR__ . '/../components/utils/is_admin.php';
        restrictToAdmin();

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: add_mount.php');
            exit;
        }

$name         = trim($_POST['name'] ?? '');
        $description  = trim($_POST['description'] ?? '');
        $image        = trim($_POST['image'] ?? '');
        $id_type      = (int) ($_POST['id_type'] ?? 0);
        $id_source    = (int) ($_POST['id_source'] ?? 0);
        $id_expansion = (int) ($_POST['id_expansion'] ?? 0);
        $id_faction   = (int) ($_POST['id_faction'] ?? 0);
        $id_difficulty = (int) ($_POST['id_difficulty'] ?? 0);
        $droprate     = (isset($_POST['droprate']) && $_POST['droprate'] !== '') ? (float) $_POST['droprate'] : null;
        $cost         = (isset($_POST['cost']) && $_POST['cost'] !== '') ? (int) $_POST['cost'] : null;
        $id_currency  = !empty($_POST['id_currency']) ? (int) $_POST['id_currency'] : null;
        $id_zone      = !empty($_POST['id_zone']) ? (int) $_POST['id_zone'] : null;
        $id_target    = !empty($_POST['id_target']) ? (int) $_POST['id_target'] : null;

if (empty($name)) {
            set_flash('error', 'Le nom de la monture est obligatoire.');
            header('Location: add_mount.php');
            exit;
        }

if (!$this->model->idExistsInTable('adg_mount_types', $id_type)) {
            set_flash('error', 'Le type sélectionné est invalide.');
            header('Location: add_mount.php');
            exit;
        }
        if (!$this->model->idExistsInTable('adg_sources', $id_source)) {
            set_flash('error', 'La source sélectionnée est invalide.');
            header('Location: add_mount.php');
            exit;
        }
        if (!$this->model->idExistsInTable('adg_expansions', $id_expansion)) {
            set_flash('error', "L'extension sélectionnée est invalide.");
            header('Location: add_mount.php');
            exit;
        }
        if (!$this->model->idExistsInTable('adg_factions', $id_faction)) {
            set_flash('error', 'La faction sélectionnée est invalide.');
            header('Location: add_mount.php');
            exit;
        }
        if (!$this->model->idExistsInTable('adg_difficulties', $id_difficulty)) {
            set_flash('error', 'La difficulté sélectionnée est invalide.');
            header('Location: add_mount.php');
            exit;
        }

if ($this->model->nameExists($name)) {
            set_flash('error', 'Une monture avec ce nom existe déjà.');
            header('Location: add_mount.php');
            exit;
        }

try {
            $this->model->create([
                ':name'         => $name,
                ':description'  => $description,
                ':image'        => $image,
                ':id_type'      => $id_type,
                ':id_source'    => $id_source,
                ':id_expansion' => $id_expansion,
                ':id_faction'   => $id_faction,
                ':id_difficulty' => $id_difficulty,
                ':droprate'     => $droprate,
                ':cost'         => $cost,
                ':id_currency'  => $id_currency,
                ':id_zone'      => $id_zone,
                ':id_target'    => $id_target,
            ]);
            set_flash('success', 'Monture créée avec succès !');
            header('Location: mount_management.php');
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'Une erreur est survenue lors de la création.');
            header('Location: add_mount.php');
            exit;
        }
    }

public function update(): void
    {
        require_once __DIR__ . '/../components/utils/is_admin.php';
        restrictToAdmin();

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: mount_management.php');
            exit;
        }

$mount_id     = (int) ($_POST['mount_id'] ?? 0);
        $name         = trim($_POST['name'] ?? '');
        $description  = trim($_POST['description'] ?? '');
        $image        = trim($_POST['image'] ?? '');
        $id_type      = (int) ($_POST['id_type'] ?? 0);
        $id_source    = (int) ($_POST['id_source'] ?? 0);
        $id_expansion = (int) ($_POST['id_expansion'] ?? 0);
        $id_faction   = (int) ($_POST['id_faction'] ?? 0);
        $id_difficulty = (int) ($_POST['id_difficulty'] ?? 0);
        $droprate     = (isset($_POST['droprate']) && $_POST['droprate'] !== '') ? (float) $_POST['droprate'] : null;
        $cost         = (isset($_POST['cost']) && $_POST['cost'] !== '') ? (int) $_POST['cost'] : null;
        $id_currency  = !empty($_POST['id_currency']) ? (int) $_POST['id_currency'] : null;
        $id_zone      = !empty($_POST['id_zone']) ? (int) $_POST['id_zone'] : null;
        $id_target    = !empty($_POST['id_target']) ? (int) $_POST['id_target'] : null;

if (empty($name)) {
            set_flash('error', 'Le nom de la monture est obligatoire.');
            header("Location: edit_mount.php?id={$mount_id}");
            exit;
        }

if (!$this->model->idExistsInTable('adg_mount_types', $id_type)) {
            set_flash('error', 'Le type sélectionné est invalide.');
            header("Location: edit_mount.php?id={$mount_id}");
            exit;
        }
        if (!$this->model->idExistsInTable('adg_sources', $id_source)) {
            set_flash('error', 'La source sélectionnée est invalide.');
            header("Location: edit_mount.php?id={$mount_id}");
            exit;
        }
        if (!$this->model->idExistsInTable('adg_expansions', $id_expansion)) {
            set_flash('error', "L'extension sélectionnée est invalide.");
            header("Location: edit_mount.php?id={$mount_id}");
            exit;
        }
        if (!$this->model->idExistsInTable('adg_factions', $id_faction)) {
            set_flash('error', 'La faction sélectionnée est invalide.');
            header("Location: edit_mount.php?id={$mount_id}");
            exit;
        }
        if (!$this->model->idExistsInTable('adg_difficulties', $id_difficulty)) {
            set_flash('error', 'La difficulté sélectionnée est invalide.');
            header("Location: edit_mount.php?id={$mount_id}");
            exit;
        }

try {
            $this->model->update([
                ':id'           => $mount_id,
                ':name'         => $name,
                ':description'  => $description,
                ':image'        => $image,
                ':id_type'      => $id_type,
                ':id_source'    => $id_source,
                ':id_expansion' => $id_expansion,
                ':id_faction'   => $id_faction,
                ':id_difficulty' => $id_difficulty,
                ':droprate'     => $droprate,
                ':cost'         => $cost,
                ':id_currency'  => $id_currency,
                ':id_zone'      => $id_zone,
                ':id_target'    => $id_target,
            ]);
            set_flash('success', 'Monture modifiée avec succès !');
            header('Location: mount_management.php');
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'Une erreur est survenue lors de la modification.');
            header("Location: edit_mount.php?id={$mount_id}");
            exit;
        }
    }

public function delete(): void
    {
        require_once __DIR__ . '/../components/utils/is_admin.php';
        restrictToAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: mount_management.php');
            exit;
        }

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: mount_management.php');
            exit;
        }

        $mount_id = (int) ($_POST['mount_id'] ?? -1);
        if ($mount_id < 0) {
            set_flash('error', 'Identifiant invalide.');
            header('Location: mount_management.php');
            exit;
        }

        try {
            $this->model->delete($mount_id);
            set_flash('success', 'Monture supprimée avec succès !');
            header('Location: mount_management.php');
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'Une erreur est survenue lors de la suppression.');
            header('Location: mount_management.php');
            exit;
        }
    }
}
