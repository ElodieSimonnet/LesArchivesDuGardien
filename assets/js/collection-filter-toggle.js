// BOUTON TOGGLE DISPONIBLE/INDISPONIBLE

let statusContainer = document.getElementById('status-container');
let statusText = document.getElementById('status-text');

// définit ce qui se passe quand on clique sur le conteneur
statusContainer.onclick = function() {

// bascule la classe 'is-off' (elle s'ajoute ou s'enlève)
// stocke le résultat dans 'isOff' (sera vrai ou faux)
let isOff = statusContainer.classList.toggle('is-off');

// change le texte selon que 'isOff' est vrai ou faux
if (isOff) {
// Si l'étiquette 'is-off' est présente
statusText.innerText = "Indisponible";
   } else {
// Si l'étiquette 'is-off' n'est pas là
statusText.innerText = "Disponible";
   }
};