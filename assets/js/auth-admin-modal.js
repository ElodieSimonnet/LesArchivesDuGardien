function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.toggle('hidden');
    }
}

const loginForm = document.querySelector('#loginForm');

if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const errorDiv = document.querySelector('#loginError');
        const formData = new FormData(this);

fetch('../actions/admin_login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                
                window.location.href = 'dashboard.php';
            } else {
                
                if (errorDiv) {
                    errorDiv.textContent = data.message;
                    errorDiv.classList.remove('hidden');
                }
            }
        })
        .catch(error => {
            console.error('Erreur technique :', error);
        });
    });
}
