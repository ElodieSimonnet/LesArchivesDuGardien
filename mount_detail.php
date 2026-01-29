<?php include 'retrieveMount.php';?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="assets/js/modal.js" defer></script>
    <script src="assets/js/burger-menu.js" defer></script>
    <script src="assets/js/wishlist-heart.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Détails des montures</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main class="bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center pt-16 pb-36
                 lg:bg-[url(../images/lava_cave.jpg)]">
        <div class="lg:max-w-5xl lg:mx-auto px-4 lg:px-12">
            <section class="bg-primary-brown rounded-xl border-2 border-primary-orange w-4/5 mx-auto
                            lg:w-full mb-8">
                <h1 class="text-xl font-semibold text-center uppercase text-primary-orange pt-4
                       md:text-3xl"><?=$mount['name'];?>
                </h1>
                <p class="text-lg font-semibold text-justify text-primary-white p-4
                      lg:text-xl"><?=$mount['description']?>
                </p>
            </section>
        
            <div class="lg:grid lg:grid-cols-2 lg:gap-12">
                <article class="bg-primary-brown rounded-xl border-2 border-primary-orange w-4/5 mx-auto mt-4 
                                lg:w-full lg:mx-0 flex flex-col">
            
                    <header class="flex px-4 py-2">
                        <img src="<?= $mountTypeLink ?>" alt="icône <?= $mount['type'] ?>" class="w-20 h-auto pt-1">
                        <i class="ph-bold ph-heart text-7xl text-red-500 pr-2 pt-2 ml-auto"></i>
                        <i class="ph-fill ph-heart-straight absolute hidden"></i> 
                    </header>

                    <div class="flex flex-col justify-center items-center flex-grow">
                        <img src="<?= $mount['image'] ?>" alt="Image de <?=$mount['name']?>" class="w-3/5 h-auto">
                        <h2 class="text-base text-primary-white text-center pb-4 uppercase mt-0 mb-0
                                   md:text-2xl">
                        <?= $mount['name'] ?>
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
                        <span class="text-center text-xl <?= $color ?> font-bold uppercase w-3/5 h-auto"><?= $mount['difficulty'] ?></span>
                        <span class="text-left <?= $color ?> text-3xl w-1/5 h-auto">★</span>
                    </footer>
                </article>
                <aside class="bg-primary-brown rounded-xl pt-2 border-2 border-primary-orange w-4/5 mx-auto mt-4
                              lg:w-full lg:mx-0">
                    <h3 class="text-2xl font-semibold text-center text-primary-orange pt-2
                               lg:text-3xl">Informations</h3>
                    <hr class="my-6 bg-primary-orange h-0.5 border-none w-full mx-auto">
                 
                    <dl class="space-y-4
                               lg:px-12 flex-grow lg:space-y-8">
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-2xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Source :</dt>
                            <dd class="text-xl text-primary-white text-center"><?= $mount['source'] ?></dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-2/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-2xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Chance :</dt>
                            <dd class="text-xl text-primary-white text-center"><?= $mount['droprate']."%"?></dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-4/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-2xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Extension :</dt>
                            <dd class="text-xl text-primary-white text-center"><?= $mount['expansion'] ?></dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-2/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-2xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Zone :</dt>
                            <dd class="text-xl text-primary-white text-center"><?= $mount['zone'] ?></dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-4/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start mb-4">
                            <dt class="font-semibold text-2xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Cible :</dt>
                            <dd class="text-xl text-primary-white text-center"><?= $mount['target'] ?></dd>
                        </div>
                    </dl>
            
                <hr class="bg-primary-orange h-0.5 border-none w-full mx-auto">
                <footer class="flex justify-center items-center h-16
                               lg:h-20">
                    <i class="ph ph-user text-primary-orange text-5xl"></i>
                </footer>
            </aside>
        </div>
    </main>

    <?php include 'components/footer.php'; ?>
    <?php include 'components/modals.php'; ?>

</body>
</html>