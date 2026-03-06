document.getElementById('search-news').addEventListener('input', function() {
    const normalize = s => s.normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase();
    const search = normalize(this.value.trim());
    document.querySelectorAll('.news-row').forEach(row => {
        const name = normalize(row.dataset.name || '');
        row.style.display = search.length < 2 || name.includes(search) ? '' : 'none';
    });
});

document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', (e) => {
        if (!confirm('Supprimer cet article ?')) e.preventDefault();
    });
});
