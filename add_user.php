<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();

// Récupération des listes pour les menus déroulants
$all_roles = $db->query("SELECT * FROM adg_roles")->fetchAll(PDO::FETCH_ASSOC);
$all_statuses = $db->query("SELECT * FROM adg_users_status")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="assets/js/admin-messages.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Ajouter un utilisateur | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php include 'components/admin_sidebar.php'; ?>

    <main class="flex-1 min-h-screen bg-row-dark p-4 xl:p-8 xl:ml-64">

        <div class="mb-8">
            <a href="admin_user_gestion.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs font-bold tracking-widest">
                <i class="ph ph-arrow-left"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-black uppercase tracking-widest mb-8 border-b-2 border-primary-orange pb-4 inline-block">
                Nouvel utilisateur
            </h2>

            <?php if (isset($_GET['error'])): ?>
                <div id="error-message" class="mb-6 p-4 bg-red-500/10 border border-red-500 text-red-500 rounded-lg flex items-center gap-3">
                    <i class="ph ph-warning-circle text-2xl"></i>
                    <span class="text-sm font-bold uppercase">
                        <?php
                            $errorMessages = [
                                'csrf' => 'Erreur de sécurité : requête non autorisée.',
                                'fields' => 'Tous les champs sont obligatoires.',
                                'invalid_role' => 'Le rôle sélectionné est invalide.',
                                'invalid_status' => 'Le statut sélectionné est invalide.',
                                'duplicate' => 'Ce nom d\'utilisateur ou cet email existe déjà.',
                                'weak_password' => 'Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.',
                                'sql' => 'Une erreur est survenue lors de la création.',
                            ];
                            $code = $_GET['error'];
                            echo htmlspecialchars($errorMessages[$code] ?? 'Une erreur est survenue.');
                        ?>
                    </span>
                </div>
            <?php endif; ?>

            <form action="components/process_add_user.php" method="POST" class="bg-[#1a0f0a] border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Nom d'utilisateur</label>
                        <input type="text" name="username" required
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Email</label>
                        <input type="email" name="email" required
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Mot de passe</label>
                        <input type="password" name="password" required
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Rôle</label>
                        <select name="id_role" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_roles as $role) : ?>
                                <option value="<?php echo $role['id']; ?>">
                                    <?php echo strtoupper(htmlspecialchars($role['role_name'])); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Statut du compte</label>
                        <select name="id_status" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_statuses as $status) : ?>
                                <option value="<?php echo $status['id']; ?>">
                                    <?php echo strtoupper(htmlspecialchars($status['status'])); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <div class="mt-12 flex justify-center gap-4">
                    <a href="admin_user_gestion.php" class="px-6 py-3 border border-primary-orange text-primary-orange font-bold uppercase text-xs rounded hover:bg-primary-orange hover:text-primary-black transition-all">
                        Annuler
                    </a>
                    <button type="submit" class="px-10 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs rounded shadow-lg hover:bg-primary-orange hover:text-primary-black transition-all">
                        Créer l'utilisateur
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
