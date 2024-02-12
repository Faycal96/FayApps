import './bootstrap';

// Importer ToastifyJS
import Toastify from 'toastify-js';

// Inclure les fichiers CSS de ToastifyJS
import 'toastify-js/src/toastify.css';

// Utiliser ToastifyJS pour afficher un message de notification
Toastify({
    text: "L'utilisateur a été ajouté avec succès!",
    duration: 3000, // Durée d'affichage du message (en millisecondes)
    gravity: "bottom", // Position de la notification (top, bottom, left, right)
    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)" // Couleur de fond de la notification
}).showToast();
