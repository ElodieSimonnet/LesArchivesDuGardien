// ============================================================
// GESTION DES MODALES ACCESSIBLES
// ============================================================

let _modalLastFocus = null;

// Récupère tous les éléments focusables visibles dans un conteneur
function _getFocusable(container) {
    return Array.from(container.querySelectorAll(
        'a[href], button:not([disabled]), input:not([disabled]), textarea:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
    )).filter(el => el.offsetParent !== null);
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    _modalLastFocus = document.activeElement;
    modal.classList.remove('hidden');
    modal.setAttribute('aria-hidden', 'false');
    // Déplace le focus vers le premier élément focusable de la modale
    const focusable = _getFocusable(modal);
    if (focusable.length) focusable[0].focus();
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.add('hidden');
    modal.setAttribute('aria-hidden', 'true');
    // Rend le focus à l'élément qui avait le focus avant l'ouverture
    if (_modalLastFocus) {
        _modalLastFocus.focus();
        _modalLastFocus = null;
    }
}

function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    if (modal.classList.contains('hidden')) {
        openModal(modalId);
    } else {
        closeModal(modalId);
    }
}

// Piège de focus (Tab / Shift+Tab) + fermeture à l'Échap
document.addEventListener('keydown', function(e) {
    const openModalId = ['loginModal', 'registerModal'].find(id => {
        const el = document.getElementById(id);
        return el && !el.classList.contains('hidden');
    });
    if (!openModalId) return;

    const modal = document.getElementById(openModalId);

    if (e.key === 'Escape') {
        closeModal(openModalId);
        return;
    }

    if (e.key === 'Tab') {
        const focusable = _getFocusable(modal);
        if (!focusable.length) { e.preventDefault(); return; }
        const first = focusable[0];
        const last = focusable[focusable.length - 1];
        if (e.shiftKey) {
            if (document.activeElement === first) {
                e.preventDefault();
                last.focus();
            }
        } else {
            if (document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        }
    }
});

// Clic sur le fond (backdrop) pour fermer
document.addEventListener('click', function(e) {
    ['loginModal', 'registerModal'].forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal && !modal.classList.contains('hidden') && e.target === modal) {
            closeModal(modalId);
        }
    });
});

// ============================================================
// GESTION DE L'INSCRIPTION
// ============================================================
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

// ============================================================
// GESTION DE LA CONNEXION
// ============================================================
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
