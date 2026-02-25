<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();

$user_id = $_GET['id'] ?? null;

if (!$user_id) {
    header('Location: admin_user_gestion.php');
    exit;
}

$query = "SELECT adg_users.*, adg_roles.role_name, adg_users_status.status
          FROM adg_users
          INNER JOIN adg_roles ON adg_users.id_role = adg_roles.id
          INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id
          WHERE adg_users.id = :id";
$stmt = $db->prepare($query);
$stmt->execute([':id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: admin_user_gestion.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Profil utilisateur | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php include 'components/admin_sidebar.php'; ?>

    <main id="main-content" class="flex-1 min-h-screen overflow-y-auto bg-[url(../images/lava_cave_mob.webp)] bg-cover bg-center bg-fixed md:bg-[url(../images/lava_cave_without_f2_tab.webp)] lg:bg-[url(../images/lava_cave_without_f2.webp)] p-4 xl:p-8 xl:ml-64">

        <div class="mb-8">
            <a href="admin_user_gestion.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs font-bold tracking-widest">
                <i class="ph ph-arrow-left"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-black uppercase tracking-widest border-b-2 border-primary-orange pb-4 inline-block">
                    Profil utilisateur
                </h1>
                <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="px-6 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs rounded hover:bg-primary-orange hover:text-primary-black transition-all flex items-center gap-2">
                    <i class="ph ph-pencil-simple text-lg"></i> Modifier
                </a>
            </div>

            <div class="bg-[#1a0f0a] border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2 md:col-span-2 flex items-center">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Avatar</span>
                        <img src="<?php echo !empty($user['avatar']) ? htmlspecialchars($user['avatar']) : 'assets/images/avatar-profile.webp'; ?>"
                             alt="Avatar de <?php echo htmlspecialchars($user['username']); ?>"
                             class="w-24 h-24 rounded-full object-cover border-2 border-primary-orange mt-2">
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">ID</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white font-mono">
                            #<?php echo (int) $user['id']; ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Nom d'utilisateur</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php echo htmlspecialchars($user['username']); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Email</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white font-mono">
                            <?php echo htmlspecialchars($user['email']); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Rôle</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white uppercase">
                            <?php echo htmlspecialchars($user['role_name']); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Statut</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 uppercase
                            <?php
                                echo match($user['status']) {
                                    'Actif'    => 'text-green-400 font-bold',
                                    'Suspendu' => 'text-yellow-400 font-bold',
                                    'Banni'    => 'text-red-500 font-bold',
                                    default    => 'text-primary-white'
                                };
                            ?>">
                            <?php echo htmlspecialchars($user['status']); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Date d'inscription</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php echo date('d/m/Y à H:i', strtotime($user['registration_date'])); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Tentatives de connexion échouées</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 <?php echo $user['failed_attempts'] >= 3 ? 'text-red-500 font-bold' : 'text-primary-white'; ?>">
                            <?php echo (int) $user['failed_attempts']; ?> / 3
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </main>

</body>
</html>
