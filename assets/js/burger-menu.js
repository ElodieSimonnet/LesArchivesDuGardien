const openBtn = document.getElementById('open-menu');
const closeBtn = document.getElementById('close-menu');
const menu = document.getElementById('mobile-menu');

function openMobileMenu() {
    menu.classList.remove('translate-x-full');
    document.body.classList.add('overflow-hidden');
    openBtn.setAttribute('aria-expanded', 'true');
    // Déplace le focus vers le premier élément du menu
    const firstFocusable = menu.querySelector('a, button');
    if (firstFocusable) firstFocusable.focus();
}

function closeMobileMenu() {
    menu.classList.add('translate-x-full');
    document.body.classList.remove('overflow-hidden');
    openBtn.setAttribute('aria-expanded', 'false');
    // Rend le focus au bouton d'ouverture
    openBtn.focus();
}

if (openBtn && menu) {
    openBtn.addEventListener('click', openMobileMenu);
    closeBtn.addEventListener('click', closeMobileMenu);

    // Fermeture au clavier (Échap)
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !menu.classList.contains('translate-x-full')) {
            closeMobileMenu();
        }
    });
}
