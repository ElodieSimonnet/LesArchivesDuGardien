document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', (e) => {
        if (!confirm('Supprimer cette monture ?')) e.preventDefault();
    });
});
