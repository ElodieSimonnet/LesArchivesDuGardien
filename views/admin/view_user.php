<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons" defer></script>
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Profil utilisateur | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php require __DIR__ . '/sidebar.php'; ?>

    <main id="main-content" class="flex-1 overflow-y-auto bg-[url(../images/lava_cave_mob.webp)] bg-cover bg-center bg-fixed md:bg-[url(../images/lava_cave_without_f2_tab.webp)] lg:bg-[url(../images/lava_cave_without_f2.webp)] p-4 xl:p-8 xl:ml-64">

        <div class="mb-8">
            <a href="user_management.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs font-bold tracking-widest">
                <i class="ph ph-arrow-left" aria-hidden="true"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-black uppercase tracking-widest border-b-2 border-primary-orange pb-4 inline-block">
                    Profil utilisateur
                </h1>
                <a href="edit_user.php?id=<?= $user['id'] ?>" class="px-6 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs rounded btn-orange-hover flex items-center gap-2">
                    <i class="ph ph-pencil-simple text-lg" aria-hidden="true"></i> Modifier
                </a>
            </div>

            <div class="bg-admin-dark border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col items-center gap-2 md:col-span-2">
                        <span class="label-orange">Avatar</span>
                        <img src="<?= !empty($user['avatar']) ? '../' . htmlspecialchars($user['avatar']) : '../assets/images/avatar-profile.webp' ?>"
                             alt="Avatar de <?= htmlspecialchars($user['username']) ?>"
                             class="w-24 h-24 rounded-full object-cover border-2 border-primary-orange mt-2">
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">ID</span>
                        <span class="form-field font-mono">
                            #<?= (int) $user['id'] ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">Nom d'utilisateur</span>
                        <span class="form-field">
                            <?= htmlspecialchars($user['username']) ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">Email</span>
                        <span class="form-field font-mono">
                            <?= htmlspecialchars($user['email']) ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">Rôle</span>
                        <span class="form-field uppercase">
                            <?= htmlspecialchars($user['role_name']) ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">Statut</span>
                        <span class="bg-black/60 border border-primary-orange rounded p-3 uppercase
                            <?= match($user['status']) {
                                'Actif'    => 'text-green-400 font-bold',
                                'Suspendu' => 'text-yellow-400 font-bold',
                                'Banni'    => 'text-red-500 font-bold',
                                default    => 'text-primary-white'
                            } ?>">
                            <?= htmlspecialchars($user['status']) ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">Date d'inscription</span>
                        <span class="form-field">
                            <time datetime="<?= date('Y-m-d\TH:i', strtotime($user['registration_date'])) ?>"><?= date('d/m/Y à H:i', strtotime($user['registration_date'])) ?></time>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">Tentatives de connexion échouées</span>
                        <span class="bg-black/60 border border-primary-orange rounded p-3 <?= $user['failed_attempts'] >= 3 ? 'text-red-500 font-bold' : 'text-primary-white' ?>">
                            <?= (int) $user['failed_attempts'] ?> / 3
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </main>

</body>
</html>
