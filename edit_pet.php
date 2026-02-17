<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();

$pet_id = $_GET['id'] ?? null;

if ($pet_id === null) {
    header('Location: admin_pet_gestion.php');
    exit;
}

$query = "SELECT * FROM adg_pets WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->execute([':id' => $pet_id]);
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pet) {
    header('Location: admin_pet_gestion.php');
    exit;
}

// Récupération des listes pour les menus déroulants
$all_families = $db->query("SELECT * FROM adg_pet_families ORDER BY family ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_sources = $db->query("SELECT * FROM adg_sources ORDER BY source ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_expansions = $db->query("SELECT * FROM adg_expansions ORDER BY expansion ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_factions = $db->query("SELECT * FROM adg_factions ORDER BY faction ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_zones = $db->query("SELECT * FROM adg_zones ORDER BY zone ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_currencies = $db->query("SELECT * FROM adg_currencies ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_spells = $db->query("SELECT * FROM adg_pet_spells ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="assets/js/admin-messages.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Modifier la mascotte | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php include 'components/admin_sidebar.php'; ?>

    <main class="flex-1 min-h-screen bg-row-dark p-4 xl:p-8 xl:ml-64">

        <div class="mb-8">
            <a href="admin_pet_gestion.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs font-bold tracking-widest">
                <i class="ph ph-arrow-left"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-black uppercase tracking-widest mb-8 border-b-2 border-primary-orange pb-4 inline-block">
                Modifier la mascotte
            </h2>

            <?php if (isset($_GET['error'])): ?>
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500 text-red-500 rounded-lg flex items-center gap-3">
                    <i class="ph ph-warning-circle text-2xl"></i>
                    <span class="text-sm font-bold uppercase">Une erreur est survenue.</span>
                </div>
            <?php endif; ?>

            <form action="components/process_edit_pet.php" method="POST" class="bg-[#1a0f0a] border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">
                <input type="hidden" name="pet_id" value="<?php echo $pet['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Nom</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($pet['name']); ?>"
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Description</label>
                        <textarea name="description" rows="3"
                                  class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all resize-vertical"><?php echo htmlspecialchars($pet['description']); ?></textarea>
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">URL de l'image</label>
                        <input type="text" name="image" value="<?php echo htmlspecialchars($pet['image']); ?>"
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Famille</label>
                        <select name="id_family" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_families as $family) : ?>
                                <option value="<?php echo $family['id']; ?>" <?php echo ($family['id'] == $pet['id_family']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($family['family']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Source</label>
                        <select name="id_source" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_sources as $source) : ?>
                                <option value="<?php echo $source['id']; ?>" <?php echo ($source['id'] == $pet['id_source']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($source['source']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Extension</label>
                        <select name="id_expansion" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_expansions as $expansion) : ?>
                                <option value="<?php echo $expansion['id']; ?>" <?php echo ($expansion['id'] == $pet['id_expansion']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($expansion['expansion']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Faction</label>
                        <select name="id_faction" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_factions as $faction) : ?>
                                <option value="<?php echo $faction['id']; ?>" <?php echo ($faction['id'] == $pet['id_faction']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($faction['faction']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Taux de drop (%)</label>
                        <input type="number" name="droprate" step="0.01" min="0" max="100" value="<?php echo htmlspecialchars($pet['droprate'] ?? ''); ?>"
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Zone</label>
                        <select name="id_zone" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <option value="">Aucune</option>
                            <?php foreach ($all_zones as $zone) : ?>
                                <option value="<?php echo $zone['id_zone']; ?>" <?php echo ($zone['id_zone'] == $pet['id_zone']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($zone['zone']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Monnaie</label>
                        <select name="id_currency" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <option value="">Aucune</option>
                            <?php foreach ($all_currencies as $currency) : ?>
                                <option value="<?php echo $currency['id']; ?>" <?php echo ($currency['id'] == $pet['id_currency']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($currency['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Coût</label>
                        <input type="number" name="cost" step="1" min="0" value="<?php echo htmlspecialchars($pet['cost'] ?? ''); ?>"
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="md:col-span-2 mt-4">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Sorts</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                            <?php for ($i = 1; $i <= 6; $i++): ?>
                            <div class="flex flex-col gap-1">
                                <span class="text-xs text-amber-400/60 uppercase tracking-wider">Sort <?php echo $i; ?></span>
                                <select name="spell_<?php echo $i; ?>" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                                    <option value="">Aucun</option>
                                    <?php foreach ($all_spells as $spell) : ?>
                                        <option value="<?php echo $spell['id']; ?>" <?php echo ($spell['id'] == ($pet['spell_' . $i] ?? null)) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($spell['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php endfor; ?>
                        </div>
                    </div>

                </div>

                <div class="mt-12 flex justify-center gap-4">
                    <a href="admin_pet_gestion.php" class="px-6 py-3 border border-primary-orange text-primary-orange font-bold uppercase text-xs rounded hover:bg-primary-orange hover:text-primary-black transition-all">
                        Annuler
                    </a>
                    <button type="submit" class="px-10 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs rounded shadow-lg hover:bg-primary-orange hover:text-primary-black transition-all">
                        Confirmer les modifications
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
