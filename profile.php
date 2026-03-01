<?php
require_once 'components/utils/db_connection.php';
// Si l'utilisateur n'est pas connecté, on le renvoie à l'accueil
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>
<?php include 'retrieveUserData.php';?>
<?php
// Si le compte est suspendu ou banni, on détruit la session et on redirige
if (!$user || $user['status'] !== 'Actif') {
    session_destroy();
    header('Location: index.php');
    exit();
}
?>
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
    <main id="main-content" class="bg-[url(../images/lava_cave_mob.webp)] bg-cover bg-center min-h-screen pt-16 pb-16
                 md:bg-[url(../images/lava_cave_tab.webp)] lg:bg-[url(../images/lava_cave.webp)]">
        <h1 class="sr-only">Mon Profil</h1>
        <div class="max-w-4xl mx-auto px-4 flex flex-col gap-6">
            <section class="grid md:grid-cols-3 gap-6">
                <article class="flex flex-col items-center justify-center bg-primary-brown border-2 border-primary-orange rounded-lg p-6 text-center shadow-2xl">
                    <form action="components/utils/upload_avatar.php" method="POST" enctype="multipart/form-data" id="profileAvatarForm">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <label for="profileAvatarInput" class="relative w-32 h-32 mb-4 flex items-center justify-center group cursor-pointer" aria-label="Cliquez pour changer votre avatar">
                            
                            <div class="absolute inset-0 border-4 border-double border-primary-orange rounded-full transition-colors"></div>
                            
                            <img src="<?php echo !empty($user['avatar']) ? htmlspecialchars($user['avatar']) : 'assets/images/avatar-profile.webp'; ?>" 
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
                </article>

                <article class="flex flex-col items-center justify-center bg-primary-brown border-2 border-primary-orange rounded-lg p-6 text-center shadow-lg">
                    <div class="w-32 h-32 mb-4 border-2 border-primary-orange rounded-full flex items-center justify-center">
                        <img src="assets/images/home_icons/dragon_icon.png" alt="Icone Monture" class="w-[110px] h-[110px] object-contain">
                    </div>
                    <h2 class="text-primary-orange text-lg font-bold uppercase tracking-tight">Montures obtenues</h2>
                    <p class="text-primary-white text-xl font-bold mt-2 font-mono"><?php echo $countOwnedMounts; ?> / <?php echo $countTotalMounts; ?></p>
                </article>

                <article class="flex flex-col items-center justify-center bg-primary-brown border-2 border-primary-orange rounded-lg p-6 text-center shadow-lg">
                    <div class="w-32 h-32 mb-4 border-2 border-primary-orange rounded-full flex items-center justify-center">
                        <img src="assets/images/home_icons/cat_icon.png" alt="Icone Mascotte" class="w-[110px] h-[110px] object-contain">
                    </div>
                    <h2 class="text-primary-orange text-lg font-bold uppercase tracking-tight">Mascottes obtenues</h2>
                    <p class="text-primary-white text-xl font-bold mt-2 font-mono"><?php echo $countOwnedPets; ?> / <?php echo $countTotalPets; ?></p>
                </article>
            </section>

            <section class="grid md:grid-cols-3 gap-6">
                <article class="md:col-span-2 bg-primary-brown border-2 border-primary-orange rounded-lg overflow-hidden shadow-2xl">
                    <div class="pt-6">
                        <h2 class="text-primary-orange text-2xl font-bold uppercase text-center tracking-[0.2em]">Paramètres</h2>
                        <div class="h-[1px] bg-primary-orange w-full mt-4"></div>
                    </div>

                    <div class="p-6 md:p-8 flex flex-col gap-8">

                        <?php $flash = get_flash(); if ($flash): ?>
                            <div id="flash-message" role="alert" aria-live="polite" class="p-4 <?= $flash['type'] === 'success' ? 'bg-green-500/10 border-green-500 text-green-400' : 'bg-red-500/10 border-red-500 text-red-400' ?> border rounded-lg text-sm font-bold uppercase text-center">
                                <?= htmlspecialchars($flash['message']) ?>
                            </div>
                        <?php endif; ?>

                        <!-- FORMULAIRE EMAIL -->
                        <form action="components/utils/update_profile.php" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="type" value="email">
                            <div class="flex flex-col md:flex-row md:items-center gap-4">
                                <label for="email" class="text-primary-orange text-sm lg:text-base font-bold w-32 shrink-0">Email :</label>
                                <div class="flex flex-1 gap-3">
                                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly
                                    autocomplete="email"
                                    class="flex-1 bg-black/40 border border-primary-orange rounded-lg px-4 py-3 text-sm lg:text-base text-a11y-gray font-mono focus:outline-none focus:ring-1 focus:ring-primary-orange">
                                    <button type="button" onclick="toggleEdit('email')" id="btn-edit-email" aria-label="Modifier l'email" class="border border-primary-orange rounded-xl p-3 hover:bg-primary-orange transition-all group">
                                        <svg class="w-6 h-6 text-primary-orange group-hover:text-primary-black transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div id="edit-email" class="hidden mt-4 flex flex-col gap-4">
                                <div class="flex flex-col md:flex-row md:items-center gap-4">
                                    <label for="email-password" class="text-primary-orange text-sm lg:text-base font-bold w-32 shrink-0">Mot de passe :</label>
                                    <div class="relative flex-1">
                                        <input type="password" id="email-password" name="current_password" placeholder="Confirmez votre mot de passe" required
                                        autocomplete="current-password"
                                        class="w-full bg-black/40 border border-amber-900 rounded-lg px-4 py-3 pr-12 text-sm lg:text-base text-a11y-gray font-mono focus:outline-none focus:ring-1 focus:ring-primary-orange">
                                        <button type="button" class="toggle-password absolute inset-y-0 right-3 flex items-center text-a11y-gray hover:text-primary-orange transition-colors cursor-pointer" aria-label="Afficher/masquer le mot de passe">
                                            <svg class="eye-open w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <svg class="eye-closed hidden w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex gap-3 justify-end">
                                    <button type="button" onclick="cancelEdit('email', '<?php echo htmlspecialchars($user['email'], ENT_QUOTES); ?>')" class="px-5 py-2 border border-primary-orange text-primary-orange font-bold uppercase text-xs lg:text-sm rounded hover:bg-primary-orange hover:text-primary-black transition-all">Annuler</button>
                                    <button type="submit" class="px-5 py-2 bg-primary-orange text-primary-black font-bold uppercase text-xs lg:text-sm rounded hover:bg-amber-500 transition-all">Enregistrer</button>
                                </div>
                            </div>
                        </form>

                        <!-- FORMULAIRE USERNAME -->
                        <form action="components/utils/update_profile.php" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="type" value="username">
                            <div class="flex flex-col md:flex-row md:items-center gap-4">
                                <label for="name" class="text-primary-orange text-sm lg:text-base font-bold w-32 shrink-0">Nom d'utilisateur :</label>
                                <div class="flex flex-1 gap-3">
                                    <input type="text" id="name" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly
                                    autocomplete="username"
                                    class="flex-1 bg-black/40 border border-primary-orange rounded-lg px-4 py-3 text-sm lg:text-base text-a11y-gray font-mono focus:outline-none focus:ring-1 focus:ring-primary-orange">
                                    <button type="button" onclick="toggleEdit('username')" id="btn-edit-username" aria-label="Modifier le nom d'utilisateur" class="border border-primary-orange rounded-xl p-3 hover:bg-primary-orange transition-all group">
                                        <svg class="w-6 h-6 text-primary-orange group-hover:text-primary-black transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div id="edit-username" class="hidden mt-4 flex flex-col gap-4">
                                <div class="flex flex-col md:flex-row md:items-center gap-4">
                                    <label for="username-password" class="text-primary-orange text-sm lg:text-base font-bold w-32 shrink-0">Mot de passe :</label>
                                    <div class="relative flex-1">
                                        <input type="password" id="username-password" name="current_password" placeholder="Confirmez votre mot de passe" required
                                        autocomplete="current-password"
                                        class="w-full bg-black/40 border border-amber-900 rounded-lg px-4 py-3 pr-12 text-sm lg:text-base text-a11y-gray font-mono focus:outline-none focus:ring-1 focus:ring-primary-orange">
                                        <button type="button" class="toggle-password absolute inset-y-0 right-3 flex items-center text-a11y-gray hover:text-primary-orange transition-colors cursor-pointer" aria-label="Afficher/masquer le mot de passe">
                                            <svg class="eye-open w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <svg class="eye-closed hidden w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex gap-3 justify-end">
                                    <button type="button" onclick="cancelEdit('username', '<?php echo htmlspecialchars($user['username'], ENT_QUOTES); ?>')" class="px-5 py-2 border border-primary-orange text-primary-orange font-bold uppercase text-xs lg:text-sm rounded hover:bg-primary-orange hover:text-primary-black transition-all">Annuler</button>
                                    <button type="submit" class="px-5 py-2 bg-primary-orange text-primary-black font-bold uppercase text-xs lg:text-sm rounded hover:bg-amber-500 transition-all">Enregistrer</button>
                                </div>
                            </div>
                        </form>

                        <!-- FORMULAIRE MOT DE PASSE -->
                        <form action="components/utils/update_profile.php" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="type" value="password">
                            <div class="flex flex-col md:flex-row md:items-center gap-4">
                                <label class="text-primary-orange text-sm lg:text-base font-bold w-32 shrink-0">Mot de passe :</label>
                                <div class="flex flex-1 gap-3">
                                    <input type="password" value="********" readonly disabled
                                    class="flex-1 bg-black/40 border border-primary-orange rounded-lg px-4 py-3 text-sm lg:text-base text-a11y-gray font-mono focus:outline-none">
                                    <button type="button" onclick="toggleEdit('password')" id="btn-edit-password" aria-label="Modifier le mot de passe" class="border border-primary-orange rounded-lg p-3 hover:bg-primary-orange transition-all group">
                                        <svg class="w-6 h-6 text-primary-orange group-hover:text-primary-black transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div id="edit-password" class="hidden mt-4 flex flex-col gap-4">
                                <div class="flex flex-col md:flex-row md:items-center gap-4">
                                    <label for="current-password" class="text-primary-orange text-sm lg:text-base font-bold w-32 shrink-0">Actuel :</label>
                                    <div class="relative flex-1">
                                        <input type="password" id="current-password" name="current_password" placeholder="Mot de passe actuel" required
                                        autocomplete="current-password"
                                        class="w-full bg-black/40 border border-amber-900 rounded-lg px-4 py-3 pr-12 text-sm lg:text-base text-a11y-gray font-mono focus:outline-none focus:ring-1 focus:ring-primary-orange">
                                        <button type="button" class="toggle-password absolute inset-y-0 right-3 flex items-center text-a11y-gray hover:text-primary-orange transition-colors cursor-pointer" aria-label="Afficher/masquer le mot de passe">
                                            <svg class="eye-open w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <svg class="eye-closed hidden w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex flex-col md:flex-row md:items-center gap-4">
                                    <label for="new-password" class="text-primary-orange text-sm lg:text-base font-bold w-32 shrink-0">Nouveau :</label>
                                    <div class="relative flex-1">
                                        <input type="password" id="new-password" name="new_password" placeholder="Nouveau mot de passe" required
                                        autocomplete="new-password"
                                        class="password-strength-input w-full bg-black/40 border border-amber-900 rounded-lg px-4 py-3 pr-12 text-sm lg:text-base text-a11y-gray font-mono focus:outline-none focus:ring-1 focus:ring-primary-orange"
                                        data-strength="strength-profile">
                                        <button type="button" class="toggle-password absolute inset-y-0 right-3 flex items-center text-a11y-gray hover:text-primary-orange transition-colors cursor-pointer" aria-label="Afficher/masquer le mot de passe">
                                            <svg class="eye-open w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <svg class="eye-closed hidden w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/></svg>
                                        </button>
                                    </div>
                                </div>
                                <div id="strength-profile" class="password-strength hidden md:pl-36">
                                    <div class="flex gap-1 mb-1">
                                        <div class="strength-bar h-1.5 flex-1 rounded bg-gray-700 transition-all duration-300"></div>
                                        <div class="strength-bar h-1.5 flex-1 rounded bg-gray-700 transition-all duration-300"></div>
                                        <div class="strength-bar h-1.5 flex-1 rounded bg-gray-700 transition-all duration-300"></div>
                                    </div>
                                    <p class="strength-label text-xs font-bold"></p>
                                </div>
                                <div class="flex flex-col md:flex-row md:items-center gap-4">
                                    <label for="confirm-password" class="text-primary-orange text-sm lg:text-base font-bold w-32 shrink-0">Confirmer :</label>
                                    <div class="relative flex-1">
                                        <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirmez le nouveau mot de passe" required
                                        autocomplete="new-password"
                                        class="w-full bg-black/40 border border-amber-900 rounded-lg px-4 py-3 pr-12 text-sm lg:text-base text-a11y-gray font-mono focus:outline-none focus:ring-1 focus:ring-primary-orange">
                                        <button type="button" class="toggle-password absolute inset-y-0 right-3 flex items-center text-a11y-gray hover:text-primary-orange transition-colors cursor-pointer" aria-label="Afficher/masquer le mot de passe">
                                            <svg class="eye-open w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <svg class="eye-closed hidden w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/></svg>
                                        </button>
                                    </div>
                                </div>
                                <p class="text-xs lg:text-sm text-a11y-gray">Min. 12 caractères, 1 majuscule, 1 minuscule, 1 chiffre, 1 caractère spécial.</p>
                                <div class="flex gap-3 justify-end">
                                    <button type="button" onclick="cancelEdit('password')" class="px-5 py-2 border border-primary-orange text-primary-orange font-bold uppercase text-xs lg:text-sm rounded hover:bg-primary-orange hover:text-primary-black transition-all">Annuler</button>
                                    <button type="submit" class="px-5 py-2 bg-primary-orange text-primary-black font-bold uppercase text-xs lg:text-sm rounded hover:bg-amber-500 transition-all">Enregistrer</button>
                                </div>
                            </div>
                        </form>

                        <form id="deleteAccountForm" action="delete_account.php" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="confirm_delete" value="1">
                            <button type="button" id="openDeleteModal" class="w-full mt-4 bg-primary-orange hover:bg-red-600 text-primary-black hover:text-primary-white font-bold py-3.5 rounded-lg uppercase text-sm lg:text-base tracking-widest transition-all active:scale-[0.98]">
                                Supprimer son compte
                            </button>
                        </form>
                    </div>
                </article>

                <article class="bg-primary-brown border-2 border-primary-orange rounded-lg overflow-hidden flex flex-col shadow-2xl">
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
                            <input type="text" placeholder="BattleTag" 
                            class="w-full bg-black/40 border border-primary-orange rounded-lg py-3 px-4 text-center text-white placeholder:text-a11y-gray focus:ring-1 focus:ring-primary-orange outline-none font-mono">
                        </div>
                        <button class="w-full max-w-[280px] bg-primary-orange hover:bg-amber-500 text-primary-black font-black py-3 px-10 rounded-lg uppercase text-sm">
                        Synchroniser
                        </button>
                    </div>
                </article>

            </section>
        </div>    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    </main>

    <!-- Modale de confirmation de suppression de compte -->
    <div id="confirmDeleteModal" class="fixed inset-0 flex items-center justify-center bg-black/80 p-8 z-[400] hidden" aria-hidden="true">
        <div role="dialog" aria-modal="true" aria-labelledby="confirmDeleteTitle" aria-describedby="confirmDeleteDesc"
             class="bg-primary-brown border-2 border-red-600 p-8 rounded-lg shadow-2xl w-full mx-auto max-w-md relative">
            <h2 id="confirmDeleteTitle" class="text-2xl font-bold text-red-500 mb-4 text-center uppercase tracking-widest">Supprimer le compte</h2>
            <p id="confirmDeleteDesc" class="text-primary-white text-center mb-8 leading-relaxed">
                Êtes-vous certain de vouloir supprimer votre compte ?<br>
                <strong>Toutes vos collections seront perdues.</strong> Cette action est irréversible.
            </p>
            <div class="flex gap-4 justify-center">
                <button type="button" id="cancelDeleteBtn"
                    class="px-6 py-3 border-2 border-primary-orange text-primary-orange font-bold uppercase text-sm rounded-lg hover:bg-primary-orange hover:text-primary-black transition-all">
                    Annuler
                </button>
                <button type="button" id="confirmDeleteBtn"
                    class="px-6 py-3 bg-red-600 text-white font-bold uppercase text-sm rounded-lg hover:bg-red-700 transition-all">
                    Confirmer la suppression
                </button>
            </div>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>
    <?php include 'components/modals.php'; ?>

    <script>
        // ============================================================
        // MODALE DE CONFIRMATION DE SUPPRESSION DE COMPTE
        // ============================================================
        const openDeleteBtn  = document.getElementById('openDeleteModal');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const deleteModal    = document.getElementById('confirmDeleteModal');
        const deleteForm     = document.getElementById('deleteAccountForm');

        function openDeleteModal() {
            deleteModal.classList.remove('hidden');
            deleteModal.setAttribute('aria-hidden', 'false');
            cancelDeleteBtn.focus();
        }

        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
            deleteModal.setAttribute('aria-hidden', 'true');
            openDeleteBtn.focus();
        }

        if (openDeleteBtn)    openDeleteBtn.addEventListener('click', openDeleteModal);
        if (cancelDeleteBtn)  cancelDeleteBtn.addEventListener('click', closeDeleteModal);
        if (confirmDeleteBtn) confirmDeleteBtn.addEventListener('click', () => deleteForm.submit());

        // Échap + piège de focus pour la modale de suppression
        document.addEventListener('keydown', function(e) {
            if (!deleteModal || deleteModal.classList.contains('hidden')) return;

            if (e.key === 'Escape') {
                closeDeleteModal();
                return;
            }
            if (e.key === 'Tab') {
                const focusable = Array.from(deleteModal.querySelectorAll('button')).filter(el => el.offsetParent !== null);
                const first = focusable[0];
                const last  = focusable[focusable.length - 1];
                if (e.shiftKey && document.activeElement === first) {
                    e.preventDefault(); last.focus();
                } else if (!e.shiftKey && document.activeElement === last) {
                    e.preventDefault(); first.focus();
                }
            }
        });

        // Clic sur le fond pour annuler
        deleteModal.addEventListener('click', function(e) {
            if (e.target === deleteModal) closeDeleteModal();
        });

        // ============================================================
        // Disparition automatique des messages de succès/erreur
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

        function toggleEdit(field) {
            const editBlock = document.getElementById('edit-' + field);
            const editBtn = document.getElementById('btn-edit-' + field);
            editBlock.classList.remove('hidden');
            editBtn.classList.add('hidden');

            if (field === 'email') {
                const input = document.getElementById('email');
                input.removeAttribute('readonly');
                input.focus();
            } else if (field === 'username') {
                const input = document.getElementById('name');
                input.removeAttribute('readonly');
                input.focus();
            }
        }

        function cancelEdit(field, originalValue) {
            const editBlock = document.getElementById('edit-' + field);
            const editBtn = document.getElementById('btn-edit-' + field);
            editBlock.classList.add('hidden');
            editBtn.classList.remove('hidden');

            if (field === 'email') {
                const input = document.getElementById('email');
                input.setAttribute('readonly', true);
                if (originalValue) input.value = originalValue;
            } else if (field === 'username') {
                const input = document.getElementById('name');
                input.setAttribute('readonly', true);
                if (originalValue) input.value = originalValue;
            } else if (field === 'password') {
                document.getElementById('current-password').value = '';
                document.getElementById('new-password').value = '';
                document.getElementById('confirm-password').value = '';
            }
        }
    </script>

</body>
</html>