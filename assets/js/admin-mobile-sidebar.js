(function () {
    const burger = document.getElementById('admin-burger');
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('admin-overlay');
    const closeBtn = document.getElementById('admin-sidebar-close');

    if (!burger || !sidebar || !overlay) return;

    function positionSidebar() {
        const header = document.querySelector('header');
        const headerHeight = header ? header.offsetHeight : 0;
        sidebar.style.top = headerHeight + 'px';
        sidebar.style.height = 'calc(100% - ' + headerHeight + 'px)';
    }

    positionSidebar();
    window.addEventListener('resize', positionSidebar);

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
    }

    burger.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeSidebar();
    });
})();
