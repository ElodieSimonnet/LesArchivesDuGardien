<?php require_once 'components/utils/db_connection.php'; ?>
<?php include 'retrievePet.php';?>
<?php
$isOwnedPet = false;
$isWishlistedPet = false;
if (isset($_SESSION['user_id'])) {
    $checkOwned = $db->prepare("SELECT id FROM adg_user_pets WHERE id_user = ? AND id_pet = ?");
    $checkOwned->execute([$_SESSION['user_id'], $pet['id']]);
    $isOwnedPet = (bool)$checkOwned->fetch();

    $checkWish = $db->prepare("SELECT id FROM adg_wishlist_pets WHERE id_user = ? AND id_pet = ?");
    $checkWish->execute([$_SESSION['user_id'], $pet['id']]);
    $isWishlistedPet = (bool)$checkWish->fetch();
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
    <title>Détail mascotte | Les Archives du Gardien</title>
    <meta name="description" content="Consultez les détails de cette mascotte World of Warcraft : famille, source d'obtention, extension et sorts.">
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main id="main-content" class="bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center pt-16 pb-36
                 lg:bg-[url(../images/lava_cave.jpg)]">
        <div class="lg:max-w-5xl lg:mx-auto px-4 lg:px-12">
            <section class="bg-primary-brown rounded-xl border-2 border-primary-orange w-4/5 mx-auto
                            lg:w-full mb-8">
                <h1 class="text-xl font-semibold text-center uppercase text-primary-orange pt-4
                       md:text-3xl"><?= htmlspecialchars($pet['name'], ENT_QUOTES, 'UTF-8') ?>
                </h1>
                <p class="text-lg font-semibold text-justify text-primary-white p-4
                      lg:text-xl"><?= htmlspecialchars($pet['description'], ENT_QUOTES, 'UTF-8') ?>
                </p>
            </section>

            <div class="lg:grid lg:grid-cols-2 lg:gap-12">
              <div class="relative flex flex-col">
                <button class="wishlist-btn group absolute top-6 right-[12%] lg:right-2 z-10 pr-2 pt-2 cursor-pointer <?= $isWishlistedPet ? 'is-favorite' : '' ?>"
                    <?php if (isset($_SESSION['user_id'])): ?>data-type="pet" data-id="<?= (int)$pet['id'] ?>" data-csrf="<?= $_SESSION['csrf_token'] ?>"<?php endif; ?>>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 transition-all duration-300
                    text-red-600 stroke-current fill-transparent group-[.is-favorite]:text-red-600 group-[.is-favorite]:fill-current" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </button>
                <article class="bg-primary-brown rounded-xl border-2 border-primary-orange w-4/5 mx-auto mt-4
                                lg:w-full lg:mx-0 flex flex-col flex-grow transition-all duration-300 <?= $isOwnedPet ? '' : 'sepia' ?>">

                    <header class="flex px-4 py-2">
                        <img src="<?= htmlspecialchars($petFamilyIcon, ENT_QUOTES, 'UTF-8') ?>" alt="icône <?= htmlspecialchars($pet['family'], ENT_QUOTES, 'UTF-8') ?>" class="w-20 h-auto pt-1">
                    </header>

                    <div class="flex flex-col justify-center items-center flex-grow">
                        <img src="<?= htmlspecialchars($pet['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Image de <?= htmlspecialchars($pet['name'], ENT_QUOTES, 'UTF-8') ?>" class="w-3/5 h-auto">
                        <h2 class="text-base font-black uppercase text-center mt-4 mb-6 tracking-widest text-white"><?= htmlspecialchars($pet['name'], ENT_QUOTES, 'UTF-8') ?></h2>
                    </div>

                    <div class="bg-black border-t border-primary-orange py-5 flex items-center justify-center gap-2 rounded-b-xl">
                        <span class="text-primary-orange text-base font-bold uppercase tracking-[0.2em]"><?= htmlspecialchars($pet['family'], ENT_QUOTES, 'UTF-8') ?></span>
                    </div>

                </article>

                <?php if (isset($_SESSION['user_id'])): ?>
                <button class="collection-toggle-btn w-4/5 mx-auto lg:w-full mt-4 py-3 flex items-center justify-center gap-3 rounded-xl border-2 font-bold uppercase text-sm tracking-widest transition-all duration-300 cursor-pointer bg-primary-brown <?= $isOwnedPet ? 'is-owned border-primary-orange bg-primary-orange text-primary-black' : 'border-primary-orange text-primary-orange hover:bg-primary-orange hover:text-primary-black' ?>"
                        data-type="pet" data-id="<?= (int)$pet['id'] ?>" data-csrf="<?= $_SESSION['csrf_token'] ?>">
                    <svg class="w-5 h-5 collection-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <?php if ($isOwnedPet): ?>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        <?php else: ?>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        <?php endif; ?>
                    </svg>
                    <span class="collection-label"><?= $isOwnedPet ? 'Obtenue' : 'Ajouter à ma collection' ?></span>
                </button>
                <?php endif; ?>
              </div>
                <aside class="bg-primary-brown rounded-xl pt-2 border-2 border-primary-orange w-4/5 mx-auto mt-4
                              lg:w-full lg:mx-0">
                    <h3 class="text-2xl font-semibold text-center text-primary-orange pt-2
                               lg:text-3xl">Informations</h3>
                    <hr class="my-6 bg-primary-orange h-0.5 border-none w-full mx-auto">

                    <dl class="space-y-4
                               lg:px-12 flex-grow lg:space-y-10">
                        <div class="flex flex-col lg:flex-row items-center lg:items-start mt-8">
                            <dt class="font-semibold text-xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Source :</dt>
                            <dd class="text-xl text-primary-white text-center"><?= htmlspecialchars($pet['source'], ENT_QUOTES, 'UTF-8') ?></dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-2/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Famille :</dt>
                            <dd class="text-xl text-primary-white text-center"><?= htmlspecialchars($pet['family'], ENT_QUOTES, 'UTF-8') ?></dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-4/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Faction :</dt>
                            <dd class="text-xl text-primary-white text-center"><?= htmlspecialchars($pet['faction'], ENT_QUOTES, 'UTF-8') ?></dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-2/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Prix :</dt>
                            <dd class="text-xl text-primary-white text-center">
                                <?php if (!empty($pet['cost']) && !empty($pet['currency_name'])): ?>
                                    <?= htmlspecialchars($pet['cost'], ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($pet['currency_name'], ENT_QUOTES, 'UTF-8') ?>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-2/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Chance :</dt>
                            <dd class="text-xl text-primary-white text-center"><?= $pet['droprate'] !== null ? htmlspecialchars($pet['droprate'], ENT_QUOTES, 'UTF-8') . '%' : 'N/A' ?></dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-4/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Extension :</dt>
                            <dd class="text-xl text-primary-white text-center"><?= htmlspecialchars($pet['expansion'], ENT_QUOTES, 'UTF-8') ?></dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-2/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start mb-8">
                            <dt class="font-semibold text-xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Zone :</dt>
                            <dd class="text-xl text-primary-white text-center"><?= !empty($pet['zone']) ? htmlspecialchars($pet['zone'], ENT_QUOTES, 'UTF-8') : 'N/A' ?></dd>
                        </div>
                    </dl>
                </aside>
            </div>

            <section class="mt-8 bg-primary-brown rounded-xl border-2 border-primary-orange w-4/5 mx-auto lg:w-full p-4 lg:p-6 shadow-xl" aria-label="Capacités de la mascotte">
                <h3 class="sr-only">Liste des sorts</h3>
                <ul class="flex flex-wrap justify-around gap-3 md:gap-4 lg:gap-6">
                    <?php for ($i = 1; $i <= 6; $i++):
                        $spell = $petSpells[$i] ?? null;
                        $spellImg = $spell ? htmlspecialchars($spell['icon'], ENT_QUOTES, 'UTF-8') : 'assets/images/pets/placeholder.png';
                        $spellName = $spell ? htmlspecialchars($spell['name'], ENT_QUOTES, 'UTF-8') : '';
                        $spellDesc = $spell ? htmlspecialchars($spell['description'], ENT_QUOTES, 'UTF-8') : '';
                    ?>
                    <li class="relative group spell-item">
                        <div class="spell-icon w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 bg-black border-2 border-primary-orange rounded-lg
                        flex items-center justify-center cursor-pointer hover:scale-110 transition-all duration-300
                        shadow-inner overflow-hidden">
                            <img src="<?= $spellImg ?>" alt="<?= $spellName ?: 'Sort ' . $i ?>" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                            <div class="absolute inset-0 bg-primary-orange/10 opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity"></div>
                        </div>
                        <?php if ($spell): ?>
                        <div class="spell-tooltip absolute top-full left-1/2 -translate-x-1/2 mt-2 w-48 bg-primary-black border border-primary-orange rounded-lg p-3 shadow-2xl
                                    opacity-0 md:group-hover:opacity-100 pointer-events-none transition-opacity duration-300 z-10">
                            <p class="text-primary-orange font-bold text-sm uppercase text-center tracking-wider"><?= $spellName ?></p>
                        </div>
                        <?php endif; ?>
                    </li>
                    <?php endfor; ?>
                </ul>
            </section>
    </main>

    <?php include 'components/footer.php'; ?>
    <?php include 'components/modals.php'; ?>

    <script>
    document.querySelectorAll('.spell-item').forEach(item => {
        item.addEventListener('click', (e) => {
            const tooltip = item.querySelector('.spell-tooltip');
            if (!tooltip) return;

            // Fermer tous les autres tooltips
            document.querySelectorAll('.spell-tooltip.active').forEach(t => {
                if (t !== tooltip) {
                    t.classList.remove('active', 'opacity-100');
                    t.classList.add('opacity-0', 'pointer-events-none');
                }
            });

            // Toggle le tooltip cliqué
            const isActive = tooltip.classList.contains('active');
            if (isActive) {
                tooltip.classList.remove('active', 'opacity-100');
                tooltip.classList.add('opacity-0', 'pointer-events-none');
            } else {
                tooltip.classList.add('active', 'opacity-100');
                tooltip.classList.remove('opacity-0', 'pointer-events-none');
            }
        });
    });

    // Fermer les tooltips en cliquant ailleurs
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.spell-item')) {
            document.querySelectorAll('.spell-tooltip.active').forEach(t => {
                t.classList.remove('active', 'opacity-100');
                t.classList.add('opacity-0', 'pointer-events-none');
            });
        }
    });
    </script>

</body>
</html>
