<?php require_once 'components/utils/db_connection.php'; ?>
<?php include 'retrieveMount.php';?>
<?php
$isOwnedMount = false;
$isWishlistedMount = false;
if (isset($_SESSION['user_id'])) {
    $checkOwned = $db->prepare("SELECT id FROM adg_user_mounts WHERE id_user = ? AND id_mount = ?");
    $checkOwned->execute([$_SESSION['user_id'], $mount['id']]);
    $isOwnedMount = (bool)$checkOwned->fetch();

    $checkWish = $db->prepare("SELECT id FROM adg_wishlist_mounts WHERE id_user = ? AND id_mount = ?");
    $checkWish->execute([$_SESSION['user_id'], $mount['id']]);
    $isWishlistedMount = (bool)$checkWish->fetch();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="assets/js/modal.js" defer></script>
    <script src="assets/js/burger-menu.js" defer></script>
    <script src="assets/js/wishlist-heart.js" defer></script>
    <script src="assets/js/toggle-collection.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Détail monture | Les Archives du Gardien</title>
    <meta name="description" content="Consultez les détails de cette monture World of Warcraft : source d'obtention, extension, faction et difficulté.">
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main id="main-content" class="bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center pt-16 pb-36
                 lg:bg-[url(../images/lava_cave.jpg)]">
        <div class="lg:max-w-5xl lg:mx-auto px-4 lg:px-12">
            <section class="bg-primary-brown rounded-xl border-2 border-primary-orange w-4/5 mx-auto
                            lg:w-full mb-8">
                <h1 class="text-xl font-semibold text-center uppercase text-primary-orange pt-4
                       md:text-3xl"><?=htmlspecialchars($mount['name'], ENT_QUOTES, 'UTF-8');?>
                </h1>
                <p class="text-lg font-semibold text-justify text-primary-white p-4
                      lg:text-xl"><?=htmlspecialchars($mount['description'], ENT_QUOTES, 'UTF-8')?>
                </p>
            </section>
        
            <div class="lg:grid lg:grid-cols-2 lg:gap-12">
              <div class="relative flex flex-col">
                <?php if (isset($_SESSION['user_id'])): ?>
                <button class="wishlist-btn group absolute top-6 right-[12%] lg:right-2 z-10 pr-2 pt-2 <?= $isWishlistedMount ? 'is-favorite' : '' ?>"
                    data-type="mount" data-id="<?= (int)$mount['id'] ?>" data-csrf="<?= $_SESSION['csrf_token'] ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 transition-all duration-300 text-red-600 stroke-current fill-transparent group-[.is-favorite]:text-red-600 group-[.is-favorite]:fill-current" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </button>
                <?php endif; ?>
                <article class="bg-primary-brown rounded-xl border-2 border-primary-orange w-4/5 mx-auto mt-4
                                lg:w-full lg:mx-0 flex flex-col flex-grow transition-all duration-300 <?= (isset($_SESSION['user_id']) && !$isOwnedMount) ? 'sepia' : '' ?>">

                    <header class="flex px-4 py-2">
                        <img src="<?= htmlspecialchars($mountTypeLink, ENT_QUOTES, 'UTF-8') ?>" alt="icône <?= htmlspecialchars($mount['type'], ENT_QUOTES, 'UTF-8') ?>" class="w-20 h-auto pt-1">
                    </header>

                    <div class="flex flex-col justify-center items-center flex-grow">
                        <img src="<?= htmlspecialchars($mount['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Image de <?=htmlspecialchars($mount['name'], ENT_QUOTES, 'UTF-8')?>" class="w-3/5 h-auto">
                        <h2 class="text-base text-primary-white text-center pb-4 uppercase mt-0 mb-0
                                   md:text-2xl">
                        <?= htmlspecialchars($mount['name'], ENT_QUOTES, 'UTF-8') ?>
                        </h2>
                    </div>

                    

                    <hr class="bg-primary-orange h-0.5 border-none w-full mx-auto">


                    <?php 
                        $color = "text-green-500";
                        if (strtolower($mount['difficulty']) == 'difficile') $color = "text-red-500";
                        if (strtolower($mount['difficulty']) == 'moyen') $color = "text-orange-500";
                    ?>
                    <footer class="flex justify-center items-center h-16
                                   lg:h-20">
                        <span class="<?= $color ?> text-right text-3xl w-1/5 h-auto leading-none">★</span>
                        <span class="text-center text-xl <?= $color ?> font-bold uppercase w-3/5 h-auto"><?= htmlspecialchars($mount['difficulty'], ENT_QUOTES, 'UTF-8') ?></span>
                        <span class="text-left <?= $color ?> text-3xl w-1/5 h-auto">★</span>
                    </footer>

                </article>

                <?php if (isset($_SESSION['user_id'])): ?>
                <button class="collection-toggle-btn w-4/5 mx-auto lg:w-full mt-4 py-3 flex items-center justify-center gap-3 rounded-xl border-2 font-bold uppercase text-sm tracking-widest transition-all duration-300 cursor-pointer bg-primary-brown <?= $isOwnedMount ? 'is-owned border-primary-orange bg-primary-orange text-primary-black' : 'border-primary-orange text-primary-orange hover:bg-primary-orange hover:text-primary-black' ?>"
                        data-type="mount" data-id="<?= (int)$mount['id'] ?>" data-csrf="<?= $_SESSION['csrf_token'] ?>">
                    <svg class="w-5 h-5 collection-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <?php if ($isOwnedMount): ?>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        <?php else: ?>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        <?php endif; ?>
                    </svg>
                    <span class="collection-label"><?= $isOwnedMount ? 'Obtenue' : 'Ajouter à ma collection' ?></span>
                </button>
                <?php endif; ?>
              </div>
                <aside class="bg-primary-brown rounded-xl py-6 border-2 border-primary-orange w-4/5 mx-auto mt-4
                              lg:w-full lg:mx-0 flex flex-col">
                    <h3 class="text-2xl font-semibold text-center text-primary-orange
                               lg:text-3xl">Informations</h3>
                    <hr class="mt-6 mb-10 bg-primary-orange h-0.5 border-none w-full mx-auto">
                 
                    <dl class="space-y-6
                               lg:px-12 lg:space-y-10">
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-2xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Source :</dt>
                            <dd class="text-xl text-primary-white text-center"><?= htmlspecialchars($mount['source'], ENT_QUOTES, 'UTF-8') ?></dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-2/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-2xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Prix :</dt>
                            <dd class="text-xl text-primary-white text-center">
                                <?php if (!empty($mount['cost']) && !empty($mount['currency_name'])): ?>
                                    <?= htmlspecialchars($mount['cost'], ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($mount['currency_name'], ENT_QUOTES, 'UTF-8') ?>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-2/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-2xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Chance :</dt>
                            <dd class="text-xl text-primary-white text-center"><?= $mount['droprate'] !== null ? htmlspecialchars($mount['droprate'], ENT_QUOTES, 'UTF-8') . '%' : 'N/A' ?></dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-4/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-2xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Extension :</dt>
                            <dd class="text-xl text-primary-white text-center"><?= htmlspecialchars($mount['expansion'], ENT_QUOTES, 'UTF-8') ?></dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-2/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-2xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Zone :</dt>
                            <dd class="text-xl text-primary-white text-center"><?= $mount['zone'] ? htmlspecialchars($mount['zone'], ENT_QUOTES, 'UTF-8') : 'N/A' ?></dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-4/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-2xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Cible :</dt>
                            <dd class="text-xl text-primary-white text-center"><?= $mount['target'] ? htmlspecialchars($mount['target'], ENT_QUOTES, 'UTF-8') : 'N/A' ?></dd>
                        </div>
                    </dl>
            
            </aside>
        </div>
    </main>

    <?php include 'components/footer.php'; ?>
    <?php include 'components/modals.php'; ?>

</body>
</html>