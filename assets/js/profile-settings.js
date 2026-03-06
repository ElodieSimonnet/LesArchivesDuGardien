function toggleEdit(field) {
    const editBlock = document.getElementById('edit-' + field);
    const editBtn = document.getElementById('btn-edit-' + field);
    editBlock.classList.remove('hidden');
    editBtn.classList.add('hidden');

    if (field === 'email') {
        const input = document.getElementById('email');
        input.removeAttribute('readonly');
        input.focus();
    } else if (field === 'username') {
        const input = document.getElementById('name');
        input.removeAttribute('readonly');
        input.focus();
    }
}

function cancelEdit(field, originalValue) {
    const editBlock = document.getElementById('edit-' + field);
    const editBtn = document.getElementById('btn-edit-' + field);
    editBlock.classList.add('hidden');
    editBtn.classList.remove('hidden');

    if (field === 'email') {
        const input = document.getElementById('email');
        input.setAttribute('readonly', true);
        if (originalValue) input.value = originalValue;
    } else if (field === 'username') {
        const input = document.getElementById('name');
        input.setAttribute('readonly', true);
        if (originalValue) input.value = originalValue;
    } else if (field === 'password') {
        document.getElementById('current-password').value = '';
        document.getElementById('new-password').value = '';
        document.getElementById('confirm-password').value = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const openDeleteBtn    = document.getElementById('openDeleteModal');
    const cancelDeleteBtn  = document.getElementById('cancelDeleteBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const deleteModal      = document.getElementById('confirmDeleteModal');
    const deleteForm       = document.getElementById('deleteAccountForm');

    function openDeleteModal() {
        deleteModal.classList.remove('hidden');
        deleteModal.setAttribute('aria-hidden', 'false');
        cancelDeleteBtn.focus();
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        deleteModal.setAttribute('aria-hidden', 'true');
        openDeleteBtn.focus();
    }

    if (openDeleteBtn)    openDeleteBtn.addEventListener('click', openDeleteModal);
    if (cancelDeleteBtn)  cancelDeleteBtn.addEventListener('click', closeDeleteModal);
    if (confirmDeleteBtn) confirmDeleteBtn.addEventListener('click', () => deleteForm.submit());

    document.addEventListener('keydown', function(e) {
        if (!deleteModal || deleteModal.classList.contains('hidden')) return;
        if (e.key === 'Escape') { closeDeleteModal(); return; }
        if (e.key === 'Tab') {
            const focusable = Array.from(deleteModal.querySelectorAll('button')).filter(el => el.offsetParent !== null);
            const first = focusable[0];
            const last  = focusable[focusable.length - 1];
            if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
            else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
        }
    });

    deleteModal.addEventListener('click', function(e) {
        if (e.target === deleteModal) closeDeleteModal();
    });
});
