<div id="loginModal" class="fixed inset-0 flex items-center justify-center bg-black/80 p-8 z-[300] hidden" aria-hidden="true">

    <div role="dialog" aria-modal="true" aria-labelledby="loginModalTitle" class="bg-primary-brown border-2 border-primary-orange p-8 rounded-lg shadow-2xl w-full mx-auto max-w-lg relative">

        <button onclick="closeModal('loginModal')" class="absolute top-4 right-4 text-a11y-gray hover:text-primary-orange text-4xl" aria-label="Fermer la fenêtre de connexion">&times;</button>

        <h2 id="loginModalTitle" class="text-2xl font-bold text-primary-orange mb-6 text-center uppercase tracking-widest">Connexion</h2>

        <div id="loginError" role="alert" aria-live="assertive" class="hidden bg-red-900/50 border border-red-500 text-red-200 p-3 rounded mb-4 text-sm text-center">
            Identifiants incorrects.
        </div>

        <form id="loginForm" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div>
                <label for="loginId" class="block text-primary-white text-lg mb-1">Identifiant</label>
                <input type="text" name="username" id="loginId" placeholder="Nom d'aventurier ou email" required
                    autocomplete="username" aria-describedby="loginError"
                    class="w-full bg-row-dark border border-amber-600/70 text-white p-2 rounded focus:outline-none focus:border-yellow-500 transition-colors">
            </div>

            <div>
                <label for="loginPassword" class="block text-primary-white text-lg mb-1">Mot de passe</label>
                <div class="relative">
                    <input type="password" name="password" id="loginPassword" placeholder="••••••••" required
                        autocomplete="current-password" aria-describedby="loginError"
                        class="w-full bg-row-dark border border-amber-600/70 text-white p-2 pr-10 rounded focus:outline-none focus:border-yellow-500 transition-colors">
                    <button type="button" class="toggle-password absolute inset-y-0 right-3 flex items-center text-a11y-gray hover:text-primary-orange transition-colors cursor-pointer" aria-label="Afficher/masquer le mot de passe">
                        <svg class="eye-open w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg class="eye-closed hidden w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/></svg>
                    </button>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-primary-orange hover:bg-primary-orange-hover text-primary-black uppercase font-bold py-2 px-4 rounded transition-all duration-200 transform shadow-lg">
                Accéder aux archives
            </button>
        </form>

        <p class="mt-4 text-center text-gray-200 text-sm md:text-lg">
            Pas encore de compte ? <button type="button" onclick="closeModal('loginModal'); openModal('registerModal');" class="text-primary-orange hover:underline">Inscrivez-vous</button>
        </p>
    </div>
</div>


<div id="registerModal" class="fixed inset-0 z-[300] flex items-center justify-center bg-black/80 p-8 hidden" aria-hidden="true">

    <div role="dialog" aria-modal="true" aria-labelledby="registerModalTitle" class="bg-primary-brown border-2 border-primary-orange p-8 rounded-lg shadow-2xl w-full mx-auto max-w-lg relative">

        <button onclick="closeModal('registerModal')" class="absolute top-4 right-4 text-a11y-gray hover:text-primary-orange text-4xl" aria-label="Fermer la fenêtre d'inscription">&times;</button>

        <h2 id="registerModalTitle" class="text-2xl font-bold text-primary-orange mb-6 text-center uppercase tracking-widest">Inscription</h2>

        <div id="registerError" role="alert" aria-live="assertive" class="hidden bg-red-900/50 border border-red-500 text-red-200 p-3 rounded mb-4 text-sm text-center">
            Identifiants incorrects.
        </div>

        <form id="registerForm" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div>
                <label for="reg-username" class="block text-primary-white text-lg mb-1">Nom d'utilisateur</label>
                <input type="text" name="username" id="reg-username" placeholder="ex: Thrall" required
                    autocomplete="username" aria-describedby="registerError"
                    class="w-full bg-row-dark border border-amber-600/70 text-white p-2 rounded focus:outline-none focus:border-yellow-500 transition-colors">
            </div>

            <div>
                <label for="reg-email" class="block text-primary-white text-lg mb-1">Email</label>
                <input type="email" name="email" id="reg-email" placeholder="ex: thrall@azeroth.com" required
                    autocomplete="email" aria-describedby="registerError"
                    class="w-full bg-row-dark border border-amber-600/70 text-white p-2 rounded focus:outline-none focus:border-yellow-500 transition-colors">
            </div>

            <div>
                <label for="password" class="block text-primary-white text-lg mb-1">Mot de passe</label>
                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="••••••••" required
                        autocomplete="new-password" aria-describedby="registerError"
                        class="password-strength-input w-full bg-row-dark border border-amber-600/70 text-white p-2 pr-10 rounded focus:outline-none focus:border-yellow-500 transition-colors"
                        data-strength="strength-register">
                    <button type="button" class="toggle-password absolute inset-y-0 right-3 flex items-center text-a11y-gray hover:text-primary-orange transition-colors cursor-pointer" aria-label="Afficher/masquer le mot de passe">
                        <svg class="eye-open w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg class="eye-closed hidden w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/></svg>
                    </button>
                </div>
                <div id="strength-register" class="password-strength hidden mt-2">
                    <div class="flex gap-1 mb-1">
                        <div class="strength-bar h-1.5 flex-1 rounded bg-gray-700 transition-all duration-300"></div>
                        <div class="strength-bar h-1.5 flex-1 rounded bg-gray-700 transition-all duration-300"></div>
                        <div class="strength-bar h-1.5 flex-1 rounded bg-gray-700 transition-all duration-300"></div>
                    </div>
                    <p class="strength-label text-xs font-bold"></p>
                </div>
                <p class="text-xs text-a11y-gray mt-1">Min. 12 caractères, 1 majuscule, 1 minuscule, 1 chiffre, 1 caractère spécial.</p>
            </div>

            <div>
                <label for="confirm_password" class="block text-primary-white text-lg mb-1">Confirmez le mot de passe</label>
                <div class="relative">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="••••••••" required
                        autocomplete="new-password" aria-describedby="registerError"
                        class="w-full bg-row-dark border border-amber-600/70 text-white p-2 pr-10 rounded focus:outline-none focus:border-yellow-500 transition-colors">
                    <button type="button" class="toggle-password absolute inset-y-0 right-3 flex items-center text-a11y-gray hover:text-primary-orange transition-colors cursor-pointer" aria-label="Afficher/masquer le mot de passe">
                        <svg class="eye-open w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg class="eye-closed hidden w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/></svg>
                    </button>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-primary-orange hover:bg-primary-orange-hover text-primary-black uppercase font-bold py-2 px-4 rounded transition-all duration-200 transform shadow-lg">
                Sceller mon inscription
            </button>
        </form>

        <p class="mt-4 text-center text-gray-200 text-sm md:text-lg">
            Déjà inscrit(e) ? <button type="button" onclick="closeModal('registerModal'); openModal('loginModal');" class="text-primary-orange hover:underline">Connectez-vous</button>
        </p>
    </div>
</div>

<script src="assets/js/password-utils.js" defer></script>
