<?php require_once 'components/utils/db_connection.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    
    <script src="assets/js/burger-menu.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Accueil | Les Archives du Gardien</title>
    <meta name="description" content="Suivez et gérez votre collection de montures et mascottes World of Warcraft. Consultez les dernières nouveautés et gardez une trace de vos trésors d'Azeroth.">
</head>
<body class="min-h-screen flex flex-col">
    
    <?php include 'components/header.php'; ?>

    <?php $flash = get_flash(); if ($flash): ?>
        <div id="flash-message" role="alert" aria-live="polite" class="fixed top-20 left-1/2 -translate-x-1/2 z-50 px-6 py-3 rounded-lg border text-sm font-bold uppercase text-center shadow-lg
            <?= $flash['type'] === 'success' ? 'bg-green-500/20 border-green-500 text-green-400' : 'bg-red-500/20 border-red-500 text-red-400' ?>">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
    <?php endif; ?>

    <main id="main-content" class="bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center pt-16 flex-grow px-16 lg:bg-[url(../images/lava_cave.jpg)]">
    
    <div class="mx-auto max-w-xl md:bg-primary-brown md:rounded-lg md:border-2 md:border-primary-orange md:p-6 md:max-w-4xl lg:max-w-5xl">
        <header class="text-center">
            <h1 class="text-primary-orange text-3xl p-5 md:text-4xl">Les Archives Du Gardien</h1>
            <p class="text-primary-white text-xl p-5 md:text-2xl">Un lieu sûr pour suivre et conserver vos trésors d'Azeroth</p>
        </header>
    </div>

    <section class="md:mt-16 md:mb-16">
        <h2 class="sr-only">Catégories</h2>
        <ul class="grid grid-cols-1 gap-8 py-4 mx-auto md:grid-cols-2 md:max-w-4xl lg:max-w-5xl">
            
            <li class="mx-auto w-full max-w-[16rem] md:max-w-none">
                <a href="mount_list.php" class="block bg-primary-brown rounded-xl shadow-md p-4 border-2 border-primary-orange transition-transform hover:scale-105">
                    <figure class="flex flex-col items-center">
                        <img src="assets/images/home_icons/dragon_icon.png" alt="icône de dragon doré représentant la catégorie monture">
                        <figcaption class="text-center font-bold text-lg text-primary-orange uppercase">Montures</figcaption>
                    </figure>
                </a>
            </li>

            <li class="mx-auto w-full max-w-[16rem] md:max-w-none">
                <a href="pet_list.php" class="block bg-primary-brown rounded-xl p-4 border-2 border-primary-orange transition-transform hover:scale-105">
                    <figure class="flex flex-col items-center">
                        <img src="assets/images/home_icons/cat_icon.png" alt="icône de chat doré représentant la catégorie mascottes">
                        <figcaption class="text-center font-bold text-lg text-primary-orange uppercase">Mascottes</figcaption>
                    </figure>
                </a>
            </li>

        </ul>
    </section>
</main>
    
    <?php include 'components/footer.php'; ?>
    <?php include 'components/modals.php'; ?>
    <script src="assets/js/modal.js"></script>
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