 // Fonction pour ouvrir/fermer les modales
 function toggleModal(modalId) {
     const modal = document.getElementById(modalId);
     if (modal) { // Vérifie que l'élément existe bien avant d'agir (évite les erreurs si l'ID est mal orthographié)
         modal.classList.toggle('hidden'); // Ajoute la classe hidden (cache l'élément) si elle n'est pas là, ou la retire (affiche l'élément) si elle y est déjà
     }
 }

// // GESTION DE L'INSCRIPTION
// const registerForm = document.querySelector('#registerForm'); // récupère le formulaire d'inscription dans le html

// if (registerForm) { // vérifie qu'il est présent sur la page actuelle
//     registerForm.addEventListener('submit', function(e) { // demande au navigateur d'écouter le moment où l'utilisateur valide le formulaire et va créer une fonction qui reçoit l'événement e
//         // Sélection des champs via querySelector
//         const password = this.querySelector('input[name="password"]'); // this = le formulaire
//         const confirm = this.querySelector('#confirm_password');
//         const errorDiv = document.querySelector('#registerError');
//         const submitBtn = this.querySelector('button[type="submit"]');

//         // Réinitialisation de l'affichage
//         errorDiv.classList.add('hidden'); // cache le message d'erreur d'une précédente tentative ratée
//         confirm.classList.remove('border-red-500'); // retire la couleur rouge d'erreur

//         // Vérification de la correspondance des mots de passe
//         if (password.value !== confirm.value) { // si les textes saisis sont différents
//             e.preventDefault(); // Bloque l'envoi des données au serveur php car erreur

//             // Affichage de l'erreur
//             errorDiv.innerText = "Les mots de passe ne correspondent pas."; // remplit la div avec le message d'erreur
//             errorDiv.classList.remove('hidden'); // affiche la div
            
//             // Feedback visuel
//             confirm.classList.add('border-red-500'); // la bordure passe rouge
//             confirm.focus(); // place le curseur dans le champ pour que l'utilisateur corrige
//             return; // arrête lexécution de la fonction
//         }
//     });
// }

// // GESTION DE LA CONNEXION
// const loginForm = document.querySelector('#loginForm');

// if (loginForm) { // vérifie si la variable loginForm contient bien quelque chose, si l'élément a été trouvé dans la page
//     loginForm.addEventListener('submit', function(e) {
//        document.querySelector('#loginError').classList.add('hidden'); // cache l'erreur précédente s'il y en a une quand on valide 
//     });
// }

// GESTION DE L'INSCRIPTION
const registerForm = document.querySelector('#registerForm');
if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const password = this.querySelector('input[name="password"]');
        const confirm = this.querySelector('#confirm_password');
        const errorDiv = document.querySelector('#registerError');
        const formData = new FormData(this);

        // Validation locale
        if (password.value !== confirm.value) {
            errorDiv.innerText = "Les mots de passe ne correspondent pas.";
            errorDiv.classList.remove('hidden');
            confirm.classList.add('border-red-500');
            return;
        }

        // Validation robustesse du mot de passe
        const pwd = password.value;
        if (pwd.length < 12) {
            errorDiv.innerText = "Le mot de passe doit contenir au moins 12 caractères.";
            errorDiv.classList.remove('hidden');
            return;
        }
        if (!/[A-Z]/.test(pwd)) {
            errorDiv.innerText = "Le mot de passe doit contenir au moins une majuscule.";
            errorDiv.classList.remove('hidden');
            return;
        }
        if (!/[a-z]/.test(pwd)) {
            errorDiv.innerText = "Le mot de passe doit contenir au moins une minuscule.";
            errorDiv.classList.remove('hidden');
            return;
        }
        if (!/[0-9]/.test(pwd)) {
            errorDiv.innerText = "Le mot de passe doit contenir au moins un chiffre.";
            errorDiv.classList.remove('hidden');
            return;
        }
        if (!/[^A-Za-z0-9]/.test(pwd)) {
            errorDiv.innerText = "Le mot de passe doit contenir au moins un caractère spécial.";
            errorDiv.classList.remove('hidden');
            return;
        }

        // Envoi au serveur
        fetch('components/utils/auth_register.php', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                window.location.href = data.redirect;
            } else {
                errorDiv.innerText = data.message;
                errorDiv.classList.remove('hidden');
            }
        });
    });
}

// GESTION DE LA CONNEXION
const loginForm = document.querySelector('#loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const errorDiv = document.querySelector('#loginError');
        const formData = new FormData(this);

        fetch('components/utils/auth_login.php', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                window.location.href = data.redirect;
            } else {
                errorDiv.innerText = data.message;
                errorDiv.classList.remove('hidden');
            }
        });
    });
}