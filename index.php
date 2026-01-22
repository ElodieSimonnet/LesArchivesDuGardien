<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="assets/js/modal.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Les Archives Du Gardien</title>
</head>
<body class="min-h-screen flex flex-col">
    
    <?php include 'components/header.php'; ?>

    <main class="bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center pt-16 flex-grow px-16
                 lg:bg-[url(../images/lava_cave.jpg)]">
        <div class="mx-auto max-w-xl  
                    md:bg-primary-brown md:rounded-lg md:border-2 md:border-primary-orange md:p-6 md:max-w-4xl
                    lg:max-w-5xl">
            <header class="text-center">
                <h1 class="text-primary-orange text-3xl p-5 
                           md:text-4xl">Les Archives Du Gardien</h1>
                <h2 class="text-primary-white text-xl p-5 
                           md:text-2xl">"Un lieu sûr pour suivre et conserver vos trésors d'Azeroth"</h2>
            </header>
        </div>
        <section class="md:mt-16 md:mb-16">
            <ul class="grid grid-cols-1 gap-8 py-4 mx-auto
                      md:grid-cols-2 md:max-w-4xl
                      lg:grid-cols-3 lg:gap-x-14 lg:max-w-5xl lg:mx-auto">
                <li class="mx-auto max-w-[16rem] 
                          md:mx-auto md:max-w-none
                          lg:mx-auto lg:max-w-sm">
                    <a href="mount_list.php" class="block bg-primary-brown rounded-xl shadow-md p-4 border-2 border-primary-orange">
                        <figure class="flex flex-col items-center">
                            <img src="assets/images/home_icons/dragon_icon.png" alt="icône de dragon doré représentant la catégorie monture">
                            <figcaption class="text-center font-bold text-lg text-primary-orange">MONTURES</figcaption>
                        </figure>
                        
                    </a>
                </li>
                <li class="mx-auto max-w-[16rem] 
                          md:mx-auto md:max-w-none
                          lg:mx-auto lg:max-w-md">
                    <a href="pet_list.php" class="block bg-primary-brown rounded-xl p-4 border-2 border-primary-orange">
                        <figure class="flex flex-col items-center">
                            <img src="assets/images/home_icons/cat_icon.png" alt="icône de chat doré représentant la catégorie mascottes">
                            <figcaption class="text-center font-bold text-lg text-primary-orange">MASCOTTES</figcaption>
                        </figure>
                        
                    </a>
                </li>
                <li class="mx-auto max-w-[16rem] 
                          md:col-span-2 md:w-full md:max-w-[calc(50%-1rem)] md:mt-8
                          lg:col-span-1 lg:mx-auto lg:max-w-none lg:mt-0">
                    <a href="transmo.html" class="block bg-primary-brown rounded-xl p-4 border-2 border-primary-orange">
                        <figure class="flex flex-col items-center">
                            <img src="assets/images/home_icons/transmo_icon.png" alt="icône de casque doré représentant la catégorie apparences">
                            <figcaption class="text-center font-bold text-lg text-primary-orange">APPARENCES</figcaption>
                        </figure>
                        
                    </a>
                </li>
            </ul>
        </section>
    </main>
    
    <?php include 'components/footer.php'; ?>
    <?php include 'components/modals.php'; ?>

</body>
</html>