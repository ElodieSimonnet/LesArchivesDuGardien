const openBtn = document.getElementById('open-menu');
const closeBtn = document.getElementById('close-menu');
const menu = document.getElementById('mobile-menu');

if (openBtn && menu) {
    openBtn.addEventListener('click', () => {
        menu.classList.remove('translate-x-full'); // Fait glisser le menu vers l'intérieur
        document.body.classList.add('overflow-hidden'); // Empêche le scroll du site
    });

    closeBtn.addEventListener('click', () => {
        menu.classList.add('translate-x-full'); // Fait glisser le menu vers l'extérieur
        document.body.classList.remove('overflow-hidden');
    });
}