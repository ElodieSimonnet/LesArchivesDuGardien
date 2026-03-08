<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons" defer></script>
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Ajouter un utilisateur | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php require __DIR__ . '/sidebar.php'; ?>

    <main id="main-content" class="flex-1 overflow-y-auto bg-[url(../images/backgrounds/lava-cave-mob.webp)] bg-cover bg-center bg-fixed md:bg-[url(../images/backgrounds/lava-cave-without-f2-tab.webp)] lg:bg-[url(../images/backgrounds/lava-cave-without-f2.webp)] p-4 xl:p-8 lg:ml-64">

        <div class="mb-8">
            <a href="user_management.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs font-bold tracking-widest">
                <i class="ph ph-arrow-left" aria-hidden="true"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-black uppercase tracking-widest mb-8 border-b-2 border-primary-orange pb-4 inline-block">
                Nouvel utilisateur
            </h1>

            <?php $flash = get_flash(); if ($flash): ?>
                <div id="flash-message" role="alert" class="mb-6 p-4 bg-red-500/10 border border-red-500 text-red-500 rounded-lg flex items-center gap-3">
                    <i class="ph ph-warning-circle text-2xl" aria-hidden="true"></i>
                    <span class="text-sm font-bold uppercase"><?= htmlspecialchars($flash['message']) ?></span>
                </div>
            <?php endif; ?>

            <form action="add_user.php" method="POST" class="bg-admin-dark border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">
                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2">
                        <label for="username" class="label-orange">Nom d'utilisateur</label>
                        <input type="text" id="username" name="username" required autocomplete="off"
                               class="form-input">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="email" class="label-orange">Email</label>
                        <input type="email" id="email" name="email" required autocomplete="off"
                               class="form-input">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="password" class="label-orange">Mot de passe</label>
                        <input type="password" id="password" name="password" required autocomplete="new-password"
                               class="form-input">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_role" class="label-orange">Rôle</label>
                        <select id="id_role" name="id_role" class="form-select">
                            <?php foreach ($all_roles as $role) : ?>
                                <option value="<?= $role['id'] ?>">
                                    <?= strtoupper(htmlspecialchars($role['role_name'])) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_status" class="label-orange">Statut du compte</label>
                        <select id="id_status" name="id_status" class="form-select">
                            <?php foreach ($all_statuses as $status) : ?>
                                <option value="<?= $status['id'] ?>">
                                    <?= strtoupper(htmlspecialchars($status['status'])) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <div class="mt-12 flex justify-center gap-4">
                    <a href="user_management.php" class="px-6 py-3 border border-primary-orange text-primary-orange font-bold uppercase text-xs rounded btn-orange-hover">
                        Annuler
                    </a>
                    <button type="submit" class="px-10 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs rounded shadow-lg btn-orange-hover">
                        Créer l'utilisateur
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
