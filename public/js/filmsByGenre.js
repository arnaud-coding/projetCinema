// On attend que tout le DOM soit chargé avant d'exécuter le code
document.addEventListener('DOMContentLoaded', () => {

    //  Affiche/cache les flèches d'un carroussel
    function updateOneCarouselArrowsVisibility(scrollContainer) {

        // scrollLeft = combien de pixels on a déjà scrollé vers la droite
        const scrollLeft = scrollContainer.scrollLeft;

        // scrollWidth = largeur totale du contenu scrollable
        // clientWidth = largeur visible du conteneur (viewport horizontal)
        const maxScrollLeft = scrollContainer.scrollWidth - scrollContainer.clientWidth;

        // Si on est au début du scroll, on cache la flèche gauche
        const left = scrollContainer.querySelector('.scrollLeft');
        left.style.visibility = scrollLeft > 0 ? 'visible' : 'hidden';

        // Si on est à la fin, on cache la flèche droite
        const right = scrollContainer.querySelector('.scrollRight');
        right.style.visibility = scrollLeft < maxScrollLeft ? 'visible' : 'hidden';
    }


    //  Affiche/cache les flèches de tous les carroussels
    function updateAllCarouselsArrowsVisibility(event) {

        leftArrows.forEach(leftArrow => {
            const scrollContainer = leftArrow.closest('div');
            updateOneCarouselArrowsVisibility(scrollContainer);
        });

        rightArrows.forEach(rightArrow => {
            const scrollContainer = rightArrow.closest('div');
            updateOneCarouselArrowsVisibility(scrollContainer);
        });
    }

    // Fonction pour défiler vers la gauche
    function scrollContainerToLeft(event) {
        const arrow = event.target;
        const scrollContainer = arrow.closest('div');

        scrollContainer.scrollBy({
            left: -1000, // Pixels à défiler vers la gauche
            behavior: 'smooth'
        });
    }

    // Fonction pour défiler vers la droite
    function scrollContainerToRight(event) {
        const arrow = event.target;
        const scrollContainer = arrow.closest('div');

        scrollContainer.scrollBy({
            left: 1000, // Pixels à défiler vers la droite
            behavior: 'smooth'
        });
    }

    // ------------------------------------------
    // Démarrage du script
    // ------------------------------------------

    // Sélection de tous les carrousels
    const scrollContainers = document.querySelectorAll(".filmScroll")

    // Sélection de toutes les flèches droites et gauches de tous les carousels
    const leftArrows = document.querySelectorAll('.scrollLeft');
    const rightArrows = document.querySelectorAll('.scrollRight');

    // Ajout des écouteurs sur les boutons flèches
    leftArrows.forEach(arrow => arrow.addEventListener('click', scrollContainerToLeft));
    rightArrows.forEach(arrow => arrow.addEventListener('click', scrollContainerToRight));

    // Mise à jour dynamique de l'état des flèches au scroll
    scrollContainers.forEach(container => container.addEventListener('scrollend', (event) => updateOneCarouselArrowsVisibility(event.target)))

    // On ajuste la visibilité des flèches au chargement de la page
    updateAllCarouselsArrowsVisibility();

    // On ajuste la visibilité des flèches au resize de la page
    window.addEventListener('resize', updateAllCarouselsArrowsVisibility);
});
