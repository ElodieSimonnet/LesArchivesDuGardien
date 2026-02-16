<?php
require_once 'components/utils/db_connection.php';
// Si l'utilisateur n'est pas connecté, on le renvoie à l'accueil
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>
<?php include 'retrieveUserData.php';?>
<?php include 'retrieveUserTitle.php';?>
<?php include 'countUserCollections.php';?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="assets/js/modal.js" defer></script>
    <script src="assets/js/burger-menu.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Mon profil | Les Archives du Gardien</title>
    <meta name="description" content="Gérez votre profil et suivez l'avancement de vos collections de montures et mascottes World of Warcraft.">
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main class="bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center min-h-screen pt-16 pb-16
                 lg:bg-[url(../images/lava_cave.jpg)]">
        <div class="max-w-6xl mx-auto px-4 flex flex-col gap-6">
            <section class="flex flex-col md:flex-row gap-6">
                <article class="flex-1 flex flex-col items-center justify-center bg-primary-brown border-2 border-primary-orange rounded-lg p-6 text-center shadow-2xl">
                    <form action="components/utils/upload_avatar.php" method="POST" enctype="multipart/form-data" id="profileAvatarForm">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <label for="profileAvatarInput" class="relative w-32 h-32 mb-4 flex items-center justify-center group cursor-pointer" title="Cliquez pour changer votre avatar">
                            
                            <div class="absolute inset-0 border-4 border-double border-primary-orange rounded-full transition-colors"></div>
                            
                            <img src="<?php echo !empty($user['avatar']) ? htmlspecialchars($user['avatar']) : 'assets/images/avatar-profile.png'; ?>" 
                            alt="Portrait de <?php echo htmlspecialchars($user['username']); ?>" 
                            class="rounded-full w-[110px] h-[110px] object-cover group-hover:opacity-40 transition-opacity">
                            
                            <div class="hidden md:flex absolute inset-0 flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-all scale-75 group-hover:scale-100">
                                <svg class="w-8 h-8 text-primary-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-[10px] text-primary-orange font-bold uppercase mt-1">Modifier</span>
                            </div>

                            <div class="2xl:hidden absolute bottom-1 right-1 bg-primary-orange p-2 rounded-full border-2 border-primary-brown shadow-lg">
                                <svg class="w-4 h-4 text-primary-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>

                            <input type="file" id="profileAvatarInput" name="avatar" class="hidden" accept="image/*" onchange="document.getElementById('profileAvatarForm').submit()">
                        </label>
                    </form>
                    
                    <h1 class="text-primary-orange text-2xl font-bold uppercase tracking-widest"><?php echo htmlspecialchars($user['username']);?></h1>
                    <p class="text-sm font-medium mt-1 text-primary-white"><?php echo htmlspecialchars($displayTitle); ?></p>
                </article>

                <article class="flex-1 flex flex-col items-center justify-center bg-primary-brown border-2 border-primary-orange rounded-lg p-6 text-center shadow-lg">
                    <div class="w-32 h-32 mb-4 border-2 border-primary-orange rounded-full flex items-center justify-center">
                        <img src="assets/images/home_icons/dragon_icon.png" alt="Icone Monture" class="w-[110px] h-[110px] object-contain">
                    </div>
                    <h2 class="text-primary-orange text-lg font-bold uppercase tracking-tight">Montures obtenues</h2>
                    <p class="text-primary-white text-xl font-bold mt-2 font-mono"><?php echo $countOwnedMounts; ?> / <?php echo $countTotalMounts; ?></p>
                </article>

                <article class="flex-1 flex flex-col items-center justify-center bg-primary-brown border-2 border-primary-orange rounded-lg p-6 text-center shadow-lg">
                    <div class="w-32 h-32 mb-4 border-2 border-primary-orange rounded-full flex items-center justify-center">
                        <img src="assets/images/home_icons/cat_icon.png" alt="Icone Mascotte" class="w-[110px] h-[110px] object-contain">
                    </div>
                    <h2 class="text-primary-orange text-lg font-bold uppercase tracking-tight">Mascottes obtenues</h2>
                    <p class="text-primary-white text-xl font-bold mt-2 font-mono"><?php echo $countOwnedPets; ?> / <?php echo $countTotalPets; ?></p>
                </article>
            </section>

            <section class="flex flex-col lg:flex-row gap-6">
                <article class="flex-[1.6] bg-primary-brown border-2 border-primary-orange rounded-lg overflow-hidden shadow-2xl">
                    <div class="pt-6">
                        <h2 class="text-primary-orange text-2xl font-bold uppercase text-center tracking-[0.2em]">Paramètres</h2>
                        <div class="h-[1px] bg-primary-orange w-full mt-4"></div>
                    </div>
    
                    <div class="p-6 md:p-8 flex flex-col gap-8">
            
                        <div class="flex flex-col md:flex-row md:items-center gap-4">
                            <label for="email" class="text-primary-orange text-sm font-bold w-32 shrink-0">Email :</label>
                            <div class="flex flex-1 gap-3">
                                <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" 
                                class="flex-1 bg-black/40 border border-primary-orange rounded-lg px-4 py-3 text-sm text-gray-300 font-mono focus:outline-none focus:ring-1 focus:ring-primary-orange">
                                <button title="Modifier l'email" class="border border-primary-orange rounded-xl p-3 hover:bg-primary-orange transition-all group">
                                    <svg class="w-6 h-6 text-primary-orange group-hover:text-primary-black transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <label for="name" class="text-primary-orange text-sm font-bold w-32 shrink-0">Nom d'utilisateur :</label>
                        <div class="flex flex-1 gap-3">
                            <input type="text" id="name" value="<?php echo htmlspecialchars($user['username']); ?>" 
                            class="flex-1 bg-black/40 border border-primary-orange rounded-lg px-4 py-3 text-sm text-gray-300 font-mono focus:outline-none focus:ring-1 focus:ring-primary-orange">
                            <button title="Modifier le nom" class="border border-primary-orange rounded-xl p-3 hover:bg-primary-orange transition-all group">
                                <svg class="w-6 h-6 text-primary-orange group-hover:text-primary-black transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <label for="password" class="text-primary-orange text-sm font-bold w-32 shrink-0">Mot de passe :</label>
                        <div class="flex flex-1 gap-3">
                            <input type="password" id="password" value="********" 
                            class="flex-1 bg-black/40 border border-primary-orange rounded-lg px-4 py-3 text-sm text-gray-300 font-mono focus:outline-none focus:ring-1 focus:ring-primary-orange">
                            <button title="Modifier le mot de passe" class="border border-primary-orange rounded-lg p-3 hover:bg-primary-orange transition-all group">
                                <svg class="w-6 h-6 text-primary-orange group-hover:text-primary-black transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                        <form action="delete_account.php" method="POST" onsubmit="return confirm('Êtes-vous certain de vouloir supprimer votre compte ? Toutes vos collections seront perdues.');">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <button type="submit" name="confirm_delete" class="w-full mt-4 bg-primary-orange hover:bg-red-600 text-primary-black hover:text-primary-white font-bold py-3.5 rounded-lg uppercase text-sm tracking-widest transition-all active:scale-[0.98]">
                            Supprimer son compte
                        </button>
                        </form>
                    </div>
                </article>

                <article class="flex-1 bg-primary-brown border-2 border-primary-orange rounded-lg overflow-hidden flex flex-col shadow-2xl">
                    <div class="pt-6">
                        <div class="flex items-center justify-center gap-3">
                            <img src="assets/images/icon-bnet.png" alt="Battle.net" class="w-8 h-8">
                            <h2 class="text-primary-orange text-2xl font-bold uppercase tracking-widest">Battle•net</h2>
                        </div>
                        <div class="h-[1px] bg-primary-orange w-full mt-4"></div>
                    </div>
        
                    <div class="p-6 md:p-8 flex flex-col items-center justify-center flex-1 gap-6">
                        <p class="text-lg text-center text-white font-medium">Synchronisez votre compte Battle.net :</p>
                        <div class="w-full max-w-[280px]">
                            <input type="text" placeholder="Entrez votre BattleTag" 
                            class="w-full bg-black/40 border border-primary-orange rounded-lg py-3 px-4 text-center text-white placeholder:text-gray-300 focus:ring-1 focus:ring-primary-orange outline-none font-mono">
                        </div>
                        <button class="w-full max-w-[280px] bg-primary-orange hover:bg-amber-500 text-primary-black font-black py-3 px-10 rounded-lg uppercase text-sm">
                        Synchroniser
                        </button>
                    </div>
                </article>

            </section>
        </div>    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    </main>

    <?php include 'components/footer.php'; ?>
    <?php include 'components/modals.php'; ?>

</body>
</html>