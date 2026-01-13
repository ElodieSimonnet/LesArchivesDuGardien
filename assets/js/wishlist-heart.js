// WISHLIST, FONCTIONNEMENT DES COEURS

let wishlistBtns = document.querySelectorAll('.wishlist-btn');

wishlistBtns.forEach(btn => {
    btn.onclick = function() {
    
        btn.classList.toggle('is-favorite');
    };
});