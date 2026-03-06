document.querySelectorAll('.spell-item').forEach(item => {
    item.addEventListener('click', () => {
        const tooltip = item.querySelector('.spell-tooltip');
        if (!tooltip) return;

        document.querySelectorAll('.spell-tooltip.active').forEach(t => {
            if (t !== tooltip) {
                t.classList.remove('active', 'opacity-100');
                t.classList.add('opacity-0', 'pointer-events-none');
            }
        });

        const isActive = tooltip.classList.contains('active');
        if (isActive) {
            tooltip.classList.remove('active', 'opacity-100');
            tooltip.classList.add('opacity-0', 'pointer-events-none');
        } else {
            tooltip.classList.add('active', 'opacity-100');
            tooltip.classList.remove('opacity-0', 'pointer-events-none');
        }
    });
});

document.addEventListener('click', (e) => {
    if (!e.target.closest('.spell-item')) {
        document.querySelectorAll('.spell-tooltip.active').forEach(t => {
            t.classList.remove('active', 'opacity-100');
            t.classList.add('opacity-0', 'pointer-events-none');
        });
    }
});
