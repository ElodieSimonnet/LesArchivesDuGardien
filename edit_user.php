<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();

// On récupère l'ID via l'URL
$user_id = $_GET['id'] ?? null;

if (!$user_id) {
    header('Location: admin_user_gestion.php');
    exit;
}

// Récupération de l'utilisateur avec ses IDs de rôle et statut
$query = "SELECT * FROM adg_users WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->execute([':id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: admin_user_gestion.php');
    exit;
}

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
    <title>Modifier l'utilisateur | Les Archives</title>
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
                Modifier le profil
            </h2>

            <?php if (isset($_GET['success']) && $_GET['success'] === 'avatar_deleted'): ?>
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500 text-green-500 rounded-lg flex items-center gap-3 animate-pulse">
                    <i class="ph ph-check-circle text-2xl"></i>
                    <span class="text-sm font-bold uppercase">Avatar supprimé avec succès !</span>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500 text-red-500 rounded-lg flex items-center gap-3">
                    <i class="ph ph-warning-circle text-2xl"></i>
                    <span class="text-sm font-bold uppercase">Une erreur est survenue.</span>
                </div>
            <?php endif; ?>

            <form action="components/process_edit_user.php" method="POST" class="bg-[#1a0f0a] border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">
                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="flex flex-col gap-2 md:col-span-2 md:max-w-md md:mx-auto md:w-full">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Nom d'utilisateur</label>
                        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" 
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Rôle</label>
                        <select name="id_role" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_roles as $role) : ?>
                                <option value="<?php echo $role['id']; ?>" <?php echo ($role['id'] == $user['id_role']) ? 'selected' : ''; ?>>
                                    <?php echo strtoupper($role['role_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Statut du compte</label>
                        <select name="id_status" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_statuses as $status) : ?>
                                <option value="<?php echo $status['id']; ?>" <?php echo ($status['id'] == $user['id_status']) ? 'selected' : ''; ?>>
                                    <?php echo strtoupper($status['status']); ?>
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
                        Confirmer les modifications
                    </button>
                </div>
            </form>

            <!-- Section Avatar -->
            <div class="mt-6 bg-[#1a0f0a] border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">
                <label class="text-sm font-black uppercase text-primary-orange tracking-widest mb-4 block">Avatar actuel</label>
                <div class="flex items-center justify-between">
                    <img src="<?php echo !empty($user['avatar']) ? htmlspecialchars($user['avatar']) : 'assets/images/avatar-profile.png'; ?>"
                         alt="Avatar de <?php echo htmlspecialchars($user['username']); ?>"
                         class="w-28 h-28 rounded-full object-cover border-2 border-primary-orange">

                    <?php if (!empty($user['avatar'])) : ?>
                        <form action="components/process_delete_avatar.php" method="POST" onsubmit="return confirm('Supprimer l\'avatar de cet utilisateur ?')">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="px-10 py-3 border border-red-500 text-red-500 font-black uppercase text-xs rounded hover:bg-red-500 hover:text-black transition-all flex items-center gap-2 cursor-pointer">
                                <i class="ph ph-trash text-lg"></i> Supprimer l'avatar
                            </button>
                        </form>
                    <?php else : ?>
                        <span class="text-amber-700 text-xs uppercase italic">Avatar par défaut</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

</body>
</html>