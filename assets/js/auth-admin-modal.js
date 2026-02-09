/* GESTION de la modale de connexion, authentification admin
 */

// Fonction pour ouvrir/fermer les modales
function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.toggle('hidden');
    }
}

// GESTION DE LA CONNEXION (LOGIN)
const loginForm = document.querySelector('#loginForm');

if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const errorDiv = document.querySelector('#loginError');
        const formData = new FormData(this);

        // On envoie vers le script PHP de connexion
        fetch('components/utils/admin_login.php', { 
            method: 'POST', 
            body: formData 
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "success") {
                // Succès : on recharge pour que le PHP détecte la session Admin
                // et redirige l'utilisateur vers le dashboard
                window.location.href = 'admin_user_gestion.php'; 
            } else {
                // Erreur : on affiche le message rouge dans la modale
                if (errorDiv) {
                    errorDiv.innerText = data;
                    errorDiv.classList.remove('hidden');
                }
            }
        })
        .catch(error => {
            console.error('Erreur technique :', error);
        });
    });
}