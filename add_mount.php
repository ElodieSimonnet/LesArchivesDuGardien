<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();

// Récupération des listes pour les menus déroulants
$all_types = $db->query("SELECT * FROM adg_mount_types ORDER BY type ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_sources = $db->query("SELECT * FROM adg_sources ORDER BY source ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_expansions = $db->query("SELECT * FROM adg_expansions ORDER BY expansion ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_factions = $db->query("SELECT * FROM adg_factions ORDER BY faction ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_difficulties = $db->query("SELECT * FROM adg_difficulties ORDER BY difficulty ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_zones = $db->query("SELECT * FROM adg_zones ORDER BY zone ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_targets = $db->query("SELECT * FROM adg_targets ORDER BY target ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="assets/js/admin-messages.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Ajouter une monture | Les Archives</title>
</head>
<body class="bg-black text-primary-white">
    <?php include 'components/admin_sidebar.php'; ?>

    <main class="flex-1 min-h-screen bg-row-dark p-4 xl:p-8 xl:ml-64">

        <div class="mb-8">
            <a href="admin_mount_gestion.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs font-bold tracking-widest">
                <i class="ph ph-arrow-left"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-black uppercase tracking-widest mb-8 border-b-2 border-primary-orange pb-4 inline-block">
                Nouvelle monture
            </h2>

            <?php if (isset($_GET['error'])): ?>
                <div id="error-message" class="mb-6 p-4 bg-red-500/10 border border-red-500 text-red-500 rounded-lg flex items-center gap-3">
                    <i class="ph ph-warning-circle text-2xl"></i>
                    <span class="text-sm font-bold uppercase">
                        <?php
                            $errorMessages = [
                                'csrf' => 'Erreur de sécurité : requête non autorisée.',
                                'fields' => 'Le nom de la monture est obligatoire.',
                                'invalid_type' => 'Le type sélectionné est invalide.',
                                'invalid_source' => 'La source sélectionnée est invalide.',
                                'invalid_expansion' => 'L\'extension sélectionnée est invalide.',
                                'invalid_faction' => 'La faction sélectionnée est invalide.',
                                'invalid_difficulty' => 'La difficulté sélectionnée est invalide.',
                                'duplicate' => 'Une monture avec ce nom existe déjà.',
                                'sql' => 'Une erreur est survenue lors de la création.',
                            ];
                            $code = $_GET['error'];
                            echo htmlspecialchars($errorMessages[$code] ?? 'Une erreur est survenue.');
                        ?>
                    </span>
                </div>
            <?php endif; ?>

            <form action="components/process_add_mount.php" method="POST" class="bg-[#1a0f0a] border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Nom</label>
                        <input type="text" name="name" required
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Description</label>
                        <textarea name="description" rows="3"
                                  class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all resize-vertical"></textarea>
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">URL de l'image</label>
                        <input type="text" name="image"
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Type</label>
                        <select name="id_type" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_types as $type) : ?>
                                <option value="<?php echo $type['id']; ?>">
                                    <?php echo htmlspecialchars($type['type']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Source</label>
                        <select name="id_source" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_sources as $source) : ?>
                                <option value="<?php echo $source['id']; ?>">
                                    <?php echo htmlspecialchars($source['source']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Extension</label>
                        <select name="id_expansion" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_expansions as $expansion) : ?>
                                <option value="<?php echo $expansion['id']; ?>">
                                    <?php echo htmlspecialchars($expansion['expansion']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Faction</label>
                        <select name="id_faction" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_factions as $faction) : ?>
                                <option value="<?php echo $faction['id']; ?>">
                                    <?php echo htmlspecialchars($faction['faction']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Difficulté</label>
                        <select name="id_difficulty" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_difficulties as $difficulty) : ?>
                                <option value="<?php echo $difficulty['id']; ?>">
                                    <?php echo htmlspecialchars($difficulty['difficulty']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Taux de drop (%)</label>
                        <input type="number" name="droprate" step="0.01" min="0" max="100"
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Zone</label>
                        <select name="id_zone" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <option value="">Aucune</option>
                            <?php foreach ($all_zones as $zone) : ?>
                                <option value="<?php echo $zone['id_zone']; ?>">
                                    <?php echo htmlspecialchars($zone['zone']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Cible</label>
                        <select name="id_target" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <option value="">Aucune</option>
                            <?php foreach ($all_targets as $target) : ?>
                                <option value="<?php echo $target['id']; ?>">
                                    <?php echo htmlspecialchars($target['target']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <div class="mt-12 flex justify-center gap-4">
                    <a href="admin_mount_gestion.php" class="px-6 py-3 border border-primary-orange text-primary-orange font-bold uppercase text-xs rounded hover:bg-primary-orange hover:text-primary-black transition-all">
                        Annuler
                    </a>
                    <button type="submit" class="px-10 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs rounded shadow-lg hover:bg-primary-orange hover:text-primary-black transition-all">
                        Créer la monture
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
