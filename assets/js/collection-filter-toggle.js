// // BOUTON TOGGLE DISPONIBLE/INDISPONIBLE

// let statusContainer = document.getElementById('status-container');
// let statusText = document.getElementById('status-text');

// // définit ce qui se passe quand on clique sur le conteneur
// statusContainer.onclick = function() {

// // bascule la classe 'is-off' (elle s'ajoute ou s'enlève)
// // stocke le résultat dans 'isOff' (sera vrai ou faux)
// let isOff = statusContainer.classList.toggle('is-off');

// // change le texte selon que 'isOff' est vrai ou faux
// if (isOff) {
// // Si l'étiquette 'is-off' est présente
// statusText.innerText = "Indisponible";
//    } else {
// // Si l'étiquette 'is-off' n'est pas là
// statusText.innerText = "Disponible";
//    }
// };


document.addEventListener('DOMContentLoaded', () => {

    //  BOUTON TOGGLE DISPONIBLE
    const toggleBtn = document.getElementById('status-container');
    const toggleTxt = document.getElementById('status-text');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOff = toggleBtn.classList.toggle('is-off');
            if (toggleTxt) toggleTxt.innerText = isOff ? "Indisponible" : "Disponible";
        });
    }

    // LOGIQUE DES MENUS DÉROULANTS
    const filterGroups = document.querySelectorAll('.relative.group');

    filterGroups.forEach(group => {
        const btn = group.querySelector('button');
        const menu = group.querySelector('div.absolute');

        if (btn && menu) {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                // Ferme les autres menus
                document.querySelectorAll('.relative.group div.absolute').forEach(other => {
                    if (other !== menu) other.classList.add('hidden');
                });

                menu.classList.toggle('hidden');
            });

            // Empêche toute interaction de sortir du menu
            // On bloque 'click' et 'change' pour ne pas que les cartes dessous réagissent
            menu.addEventListener('click', (e) => e.stopPropagation());
            menu.addEventListener('change', (e) => e.stopPropagation());
        }
    });

    // FERMETURE SI CLIC EXTÉRIEUR
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.relative.group')) {
            document.querySelectorAll('.relative.group div.absolute').forEach(m => {
                m.classList.add('hidden');
            });
        }
    });

    // SYSTÈME DE FILTRAGE DES CARTES
    const checkboxes = document.querySelectorAll('.filter-checkbox');
    const mountItems = document.querySelectorAll('.mount-item');

    checkboxes.forEach(box => {
        // On écoute le changement sur chaque checkbox
        box.addEventListener('change', () => {
            const activeFilters = {};
            
            // On regroupe les filtres cochés
            checkboxes.forEach(chk => {
                if (chk.checked) {
                    const category = chk.dataset.filter;
                    if (!activeFilters[category]) activeFilters[category] = [];
                    activeFilters[category].push(chk.value);
                }
            });

            // On filtre les cartes
            mountItems.forEach(item => {
                const card = item.querySelector('.mount-card');
                if (!card) return;

                let shouldShow = true;
                for (const category in activeFilters) {
                    const cardValue = card.dataset[category];
                    if (!activeFilters[category].includes(cardValue)) {
                        shouldShow = false;
                        break;
                    }
                }

                // Utilisation de display au lieu de toggle class
                // Cela évite les bugs qui ferment les menus
                item.style.display = shouldShow ? 'block' : 'none';
            });
        });
      });
});