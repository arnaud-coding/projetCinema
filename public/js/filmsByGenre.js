// On attend que tout le DOM soit chargé avant d'exécuter le code
document.addEventListener('DOMContentLoaded', () => {

    // Sélection du conteneur qui défile horizontalement (lignes de films)
    const scrollContainer = document.getElementById('filmScroll');
    // Sélection des deux boutons de navigation gauche et droite
    const btnLeft = document.getElementById('scrollLeft');
    const btnRight = document.getElementById('scrollRight');

    // Fonction pour mettre à jour l'état des flèches (active ou masquée)
    function updateArrowVisibility() {

        // scrollLeft = combien de pixels on a déjà scrollé vers la droite
        const scrollLeft = scrollContainer.scrollLeft;
        // scrollWidth = largeur totale du contenu scrollable
        // clientWidth = largeur visible du conteneur (viewport horizontal)
        const maxScrollLeft = scrollContainer.scrollWidth - scrollContainer.clientWidth;

        // Si on est au début du scroll, on cache la flèche gauche
        btnLeft.style.visibility = scrollLeft > 0 ? 'visible' : 'hidden';
        // Si on est à la fin, on cache la flèche droite
        btnRight.style.visibility = scrollLeft < maxScrollLeft ? 'visible' : 'hidden';
    }

    // Fonction pour défiler vers la gauche
    function scrollLeftFunc() {
        scrollContainer.scrollBy({
            left: -1000, // Pixels à défiler vers la gauche
            behavior: 'smooth'
        });
    }

    // Fonction pour défiler vers la droite
    function scrollRightFunc() {
        scrollContainer.scrollBy({
            left: 1000, // Pixels à défiler vers la droite
            behavior: 'smooth'
        });
    }

    // Ajout des écouteurs sur les boutons flèches
    btnLeft.addEventListener('click', scrollLeftFunc);
    btnRight.addEventListener('click', scrollRightFunc);

    // Mise à jour dynamique de l'état des flèches au scroll
    scrollContainer.addEventListener('scroll', updateArrowVisibility);

    // On vérifie la visibilité des flèches au chargement
    updateArrowVisibility();

    // Réagit aussi quand la taille de l'écran change (ex : mobile → desktop)
    window.addEventListener('resize', updateArrowVisibility);
});
