<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();

$faq_id = $_GET['id'] ?? null;

if ($faq_id === null) {
    header('Location: admin_faq_gestion.php');
    exit;
}

$query = "SELECT * FROM adg_faq WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->execute([':id' => (int)$faq_id]);
$faq = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$faq) {
    header('Location: admin_faq_gestion.php');
    exit;
}

$stmt_cats = $db->query("SELECT id, name FROM adg_faq_categories ORDER BY id ASC");
$categories = $stmt_cats->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="assets/js/admin-messages.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Modifier une question | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php include 'components/admin_sidebar.php'; ?>

    <main class="flex-1 min-h-screen bg-row-dark p-4 xl:p-8 xl:ml-64">

        <div class="mb-8">
            <a href="admin_faq_gestion.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs font-bold tracking-widest">
                <i class="ph ph-arrow-left"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-black uppercase tracking-widest mb-8 border-b-2 border-primary-orange pb-4 inline-block">
                Modifier la question
            </h2>

            <?php if (isset($_GET['error'])): ?>
                <div id="error-message" class="mb-6 p-4 bg-red-500/10 border border-red-500 text-red-500 rounded-lg flex items-center gap-3">
                    <i class="ph ph-warning-circle text-2xl"></i>
                    <span class="text-sm font-bold uppercase">
                        <?php
                            $errorMessages = [
                                'csrf' => 'Erreur de sécurité : requête non autorisée.',
                                'fields' => 'La question et la réponse sont obligatoires.',
                                'sql' => 'Une erreur est survenue lors de la modification.',
                            ];
                            $code = $_GET['error'];
                            echo htmlspecialchars($errorMessages[$code] ?? 'Une erreur est survenue.');
                        ?>
                    </span>
                </div>
            <?php endif; ?>

            <form action="components/process_edit_faq.php" method="POST" class="bg-[#1a0f0a] border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">
                <input type="hidden" name="faq_id" value="<?php echo $faq['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Question</label>
                        <input type="text" name="question" required
                               value="<?php echo htmlspecialchars($faq['question']); ?>"
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">R&eacute;ponse</label>
                        <textarea name="answer" rows="6" required
                                  class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all resize-vertical"><?php echo htmlspecialchars($faq['answer']); ?></textarea>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Cat&eacute;gorie</label>
                        <select name="id_category" required
                                class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                            <option value="">-- Sélectionner une catégorie --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= (int)$cat['id'] ?>" <?= $faq['id_category'] == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Ordre d'affichage</label>
                        <input type="number" name="display_order" value="<?php echo (int)$faq['display_order']; ?>" min="0"
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                </div>

                <div class="mt-12 flex justify-center gap-4">
                    <a href="admin_faq_gestion.php" class="px-6 py-3 border border-primary-orange text-primary-orange font-bold uppercase text-xs rounded hover:bg-primary-orange hover:text-primary-black transition-all">
                        Annuler
                    </a>
                    <button type="submit" class="px-10 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs rounded shadow-lg hover:bg-primary-orange hover:text-primary-black transition-all">
                        Modifier la question
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
