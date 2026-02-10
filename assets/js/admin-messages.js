// Gestion des messages de succès et d'erreur
document.addEventListener('DOMContentLoaded', function() {
    const successMessageEdit = document.getElementById('success-message-edit');
    const successMessageAvatar = document.getElementById('success-message-avatar');
    const successMessageUser = document.getElementById('success-message-user');
    const errorMessage = document.getElementById('error-message');
    
    // Fonction pour faire disparaître un message
    function hideMessage(messageElement) {
        if (messageElement) {
            setTimeout(() => {
                messageElement.style.transition = 'opacity 0.5s';
                messageElement.style.opacity = '0';
                setTimeout(() => messageElement.remove(), 500);
            }, 3000);
        }
    }
    
    // Nettoyer l'URL des paramètres success/error
    function cleanUrl() {
        const url = new URL(window.location);
        if (url.searchParams.has('success') || url.searchParams.has('error')) {
            url.searchParams.delete('success');
            url.searchParams.delete('error');
            window.history.replaceState({}, '', url);
        }
    }
    
    // Appliquer aux messages
    hideMessage(successMessageEdit);
    hideMessage(successMessageAvatar);
    hideMessage(successMessageUser);
    hideMessage(errorMessage);

    // Nettoyer l'URL après un court délai
    if (successMessageEdit || successMessageAvatar || successMessageUser || errorMessage) {
        setTimeout(cleanUrl, 3500);
    }
});