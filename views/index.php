<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil | Les Archives du Gardien</title>
    <meta name="description" content="Suivez et gérez votre collection de montures et mascottes World of Warcraft. Consultez les dernières nouveautés et gardez une trace de vos trésors d'Azeroth.">
    <link href="assets/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="assets/js/burger-menu.js" defer></script>
</head>
<body class="min-h-screen flex flex-col">

    <?php require __DIR__ . '/layout/header.php'; ?>

    <?php $flash = get_flash(); if ($flash): ?>
        <div id="flash-message" role="alert" class="fixed top-20 left-1/2 -translate-x-1/2 z-50 px-6 py-3 rounded-lg border text-sm font-bold uppercase text-center shadow-lg
            <?= $flash['type'] === 'success' ? 'bg-green-500/20 border-green-500 text-green-400' : 'bg-red-500/20 border-red-500 text-red-400' ?>">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
    <?php endif; ?>

    <main id="main-content" class="bg-[url(../images/lava_cave_mob.webp)] bg-cover bg-center pt-16 flex-grow px-16 md:bg-[url(../images/lava_cave_tab.webp)] lg:bg-[url(../images/lava_cave.webp)]">

    <header class="mx-auto max-w-[16rem] md:max-w-[42rem] bg-primary-brown rounded-lg border-2 border-primary-orange p-2 text-center">
        <h1 class="text-primary-orange text-3xl p-5 md:text-3xl">Les Archives Du Gardien</h1>
        <p class="text-primary-white text-xl p-5 md:text-xl">Un lieu sûr pour suivre et conserver vos trésors d'Azeroth</p>
    </header>

    <section class="mt-8 mb-8">
        <h2 class="sr-only">Catégories</h2>
        <ul class="grid grid-cols-1 gap-8 py-4 mx-auto max-w-[16rem] md:grid-cols-2 md:max-w-[42rem]">

            <li>
                <a href="mount_list.php" class="flex flex-col items-center justify-center gap-2 aspect-square bg-primary-brown rounded-xl shadow-md p-4 border-2 border-primary-orange transition-transform hover:scale-105">
                    <img src="assets/images/home_icons/dragon_icon.webp" alt="" aria-hidden="true" class="max-w-[6rem] md:max-w-[12rem]">
                    <span class="text-center font-bold text-xl text-primary-orange uppercase">Montures</span>
                </a>
            </li>

            <li>
                <a href="pet_list.php" class="flex flex-col items-center justify-center gap-2 aspect-square bg-primary-brown rounded-xl p-4 border-2 border-primary-orange transition-transform hover:scale-105">
                    <img src="assets/images/home_icons/cat_icon.webp" alt="" aria-hidden="true" class="max-w-[6rem] md:max-w-[12rem]">
                    <span class="text-center font-bold text-xl text-primary-orange uppercase">Mascottes</span>
                </a>
            </li>

        </ul>
    </section>
</main>

    <?php require __DIR__ . '/layout/footer.php'; ?>
    <?php require __DIR__ . '/layout/modals.php'; ?>
    <script src="assets/js/modal.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const msg = document.getElementById('flash-message');
            if (msg) {
                setTimeout(() => {
                    msg.style.transition = 'opacity 0.5s';
                    msg.style.opacity = '0';
                    setTimeout(() => msg.remove(), 500);
                }, 3000);
            }
        });
    </script>
</body>
</html>
