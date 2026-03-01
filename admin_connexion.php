<?php require_once 'components/utils/db_connection.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Connexion | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-[#1a0f0a] flex items-center justify-center min-h-screen">

<main class="w-full flex justify-center px-4">
    <div class="bg-primary-brown border-2 border-primary-orange p-8 rounded-lg shadow-2xl w-full max-w-lg">
        
        <h1 class="text-2xl font-bold text-primary-orange mb-6 text-center uppercase tracking-widest">Connexion Administrateur</h1>

        <div id="loginError" role="alert" aria-live="polite" class="hidden bg-red-900/50 border border-red-500 text-red-200 p-3 rounded mb-4 text-sm text-center">
            Identifiants incorrects.
        </div>

        <form id="loginForm" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            
            <div>
                <label for="username" class="block text-primary-white text-lg mb-1">Identifiant</label>
                <input type="text" id="username" name="username" required
                    autocomplete="username" aria-describedby="loginError"
                    class="w-full bg-row-dark border border-amber-600/70 text-white p-2 rounded focus:outline-none focus:border-yellow-500">
            </div>

            <div>
                <label for="password" class="block text-primary-white text-lg mb-1">Mot de passe</label>
                <input type="password" id="password" name="password" required
                    autocomplete="current-password" aria-describedby="loginError"
                    class="w-full bg-row-dark border border-amber-600/70 text-white p-2 rounded focus:outline-none focus:border-yellow-500">
            </div>

            <button type="submit" 
                class="w-full bg-primary-orange hover:bg-amber-500 text-primary-black uppercase font-bold py-2 px-4 rounded transition-all shadow-lg">
                Accéder aux archives
            </button>
        </form>
    </div>
</main>

    <script src="assets/js/auth-admin-modal.js"></script>
</body>
</html>