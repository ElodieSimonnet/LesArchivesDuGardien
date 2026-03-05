let _modalLastFocus = null;

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    _modalLastFocus = document.activeElement;
    modal.showModal();
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.close();
    if (_modalLastFocus) {
        _modalLastFocus.focus();
        _modalLastFocus = null;
    }
}

function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    if (modal.open) {
        closeModal(modalId);
    } else {
        openModal(modalId);
    }
}


document.getElementById('loginModalClose')?.addEventListener('click', () => closeModal('loginModal'));
document.getElementById('registerModalClose')?.addEventListener('click', () => closeModal('registerModal'));


document.getElementById('switchToRegister')?.addEventListener('click', () => {
    closeModal('loginModal');
    openModal('registerModal');
});
document.getElementById('switchToLogin')?.addEventListener('click', () => {
    closeModal('registerModal');
    openModal('loginModal');
});


['loginModal', 'registerModal'].forEach(modalId => {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.addEventListener('cancel', (e) => {
        e.preventDefault();
        closeModal(modalId);
    });
});


['loginModal', 'registerModal'].forEach(modalId => {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.addEventListener('click', (e) => {
        if (!modal.open) return;
        const rect = modal.getBoundingClientRect();
        const isOutside = e.clientX < rect.left || e.clientX > rect.right
                       || e.clientY < rect.top  || e.clientY > rect.bottom;
        if (isOutside) closeModal(modalId);
    });
});


const registerForm = document.querySelector('#registerForm');
if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const password = this.querySelector('input[name="password"]');
        const confirm = this.querySelector('#confirm_password');
        const errorDiv = document.querySelector('#registerError');
        const formData = new FormData(this);

        
        if (password.value !== confirm.value) {
            errorDiv.innerText = "Les mots de passe ne correspondent pas.";
            errorDiv.classList.remove('hidden');
            confirm.classList.add('border-red-500');
            return;
        }

        
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
