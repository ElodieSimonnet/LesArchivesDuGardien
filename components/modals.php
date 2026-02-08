<div id="loginModal" class="fixed inset-0  flex items-center justify-center bg-black/80 p-8 z-[300] hidden">
    
    <div class="bg-primary-brown border-2 border-primary-orange p-8 rounded-lg shadow-2xl w-full mx-auto max-w-lg relative">
        
        <button onclick="toggleModal('loginModal')" class="absolute top-4 right-4 text-gray-400 hover:text-primary-orange text-4xl">&times;</button>
        
        <h2 class="text-2xl font-bold text-primary-orange mb-6 text-center uppercase tracking-widest">Connexion</h2>

        <div id="loginError" class="hidden bg-red-900/50 border border-red-500 text-red-200 p-3 rounded mb-4 text-sm text-center">
            Identifiants incorrects.
        </div>

        <form id="loginForm" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div>
                <label class="block text-primary-white text-lg mb-1">Identifiant</label>
                <input type="text" name="username" id="loginId" placeholder="Nom d'aventurier ou email" required
                    class="w-full bg-row-dark border border-amber-600/70 text-white p-2 rounded focus:outline-none focus:border-yellow-500 transition-colors">
            </div>

            <div>
                <label class="block text-primary-white text-lg mb-1">Mot de passe</label>
                <input type="password" name="password" placeholder="••••••••" required
                    class="w-full bg-row-dark border border-amber-600/70 text-white p-2 rounded focus:outline-none focus:border-yellow-500 transition-colors">
            </div>

            <button type="submit" 
                class="w-full bg-primary-orange hover:bg-primary-orange-hover text-primary-black uppercase font-bold py-2 px-4 rounded transition-all duration-200 transform shadow-lg">
                Accéder aux archives
            </button>
        </form>

        <p class="mt-4 text-center text-gray-200 text-sm md:text-lg">
            Pas encore de compte ? <a href="#" onclick="toggleModal('loginModal'); toggleModal('registerModal');" class="text-primary-orange hover:underline">Inscrivez-vous</a>
        </p>
    </div>
</div>


<div id="registerModal" class="fixed inset-0 z-300 flex items-center justify-center bg-black/80 p-8 hidden">
    
    <div class="bg-primary-brown border-2 border-primary-orange p-8 rounded-lg shadow-2xl w-full mx-auto max-w-lg relative">
        
        <button onclick="toggleModal('registerModal')" class="absolute top-4 right-4 text-gray-400 hover:text-primary-orange text-4xl">&times;</button>
        
        <h2 class="text-2xl font-bold text-primary-orange mb-6 text-center uppercase tracking-widest">Inscription</h2>

        <div id="registerError" class="hidden bg-red-900/50 border border-red-500 text-red-200 p-3 rounded mb-4 text-sm text-center">
            Identifiants incorrects.
        </div>

        <form id="registerForm" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div>
                <label class="block text-primary-white text-lg mb-1">Nom d'utilisateur</label>
                <input type="text" name="username" placeholder="ex: Thrall" required
                    class="w-full bg-row-dark border border-amber-600/70 text-white p-2 rounded focus:outline-none focus:border-yellow-500 transition-colors">
            </div>

            <div>
                <label class="block text-primary-white text-lg mb-1">Email</label>
                <input type="email" name="email" placeholder="ex: thrall@azeroth.com" required
                    class="w-full bg-row-dark border border-amber-600/70 text-white p-2 rounded focus:outline-none focus:border-yellow-500 transition-colors">
            </div>

            <div>
                <label class="block text-primary-white text-lg mb-1">Mot de passe</label>
                <input type="password" name="password" id="password" placeholder="••••••••" required
                    class="w-full bg-row-dark border border-amber-600/70 text-white p-2 rounded focus:outline-none focus:border-yellow-500 transition-colors">
            </div>

            <div>
                <label class="block text-primary-white text-lg mb-1">Confirmez le mot de passe</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="••••••••" required
                    class="w-full bg-row-dark border border-amber-600/70 text-white p-2 rounded focus:outline-none focus:border-yellow-500 transition-colors">
            </div>

            <button type="submit" 
                class="w-full bg-primary-orange hover:bg-primary-orange-hover text-primary-black uppercase font-bold py-2 px-4 rounded transition-all duration-200 transform shadow-lg">
                Sceller mon inscription
            </button>
        </form>

        <p class="mt-4 text-center text-gray-200 text-sm md:text-lg">
            Déjà inscrit(e) ? <a href="#" onclick="toggleModal('registerModal'); toggleModal('loginModal');" class="text-primary-orange hover:underline">Connectez-vous</a>
        </p>
    </div>
</div>