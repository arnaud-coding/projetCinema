// On attend que tout le DOM soit chargé avant d'exécuter le code
document.addEventListener('DOMContentLoaded', () => {

    // Sélection de tous les carrousels
    const scrollContainers = document.querySelectorAll(".filmScroll")
    // Sélection de toute les flèches droites et gauches
    const leftArrows = document.querySelectorAll('.scrollLeft');
    const rightArrows = document.querySelectorAll('.scrollRight');


    //  Affiche/cache les flèches d'un carroussel
    function updateArrowsVisibility(scrollContainer) {

        console.log(" updateArrowsVisibility ~ scrollContainer:", scrollContainer)

        // scrollLeft = combien de pixels on a déjà scrollé vers la droite
        const scrollLeft = scrollContainer.scrollLeft;

        // scrollWidth = largeur totale du contenu scrollable
        // clientWidth = largeur visible du conteneur (viewport horizontal)
        const maxScrollLeft = scrollContainer.scrollWidth - scrollContainer.clientWidth;

        // Si on est au début du scroll, on cache la flèche gauche
        // const arrow = letArrow.parentElement;

        // arrow.style.visibility = scrollLeft > 0 ? 'visible' : 'hidden';

        // Si on est à la fin, on cache la flèche droite
        // arrow.style.visibility = scrollLeft < maxScrollLeft ? 'visible' : 'hidden';
    }


    //  Affiche/cache les flèches de tous les carroussels
    function updateAllArrowsVisibility(event) {

        console.log(" updateAllArrowsVisibility ~ left event:", event)

        leftArrows.forEach(leftArrow => {
            const scrollContainer = leftArrow.closest('div');

            updateArrowsVisibility(scrollContainer);

            // Si on est au début du scroll, on cache la flèche gauche
            // const arrow = leftArrow.parentElement;
            // console.log("left", arrow);
            // arrow.style.visibility = scrollLeft > 0 ? 'visible' : 'hidden';
        });

        console.log(" updateAllArrowsVisibility ~ right event:", event)

        rightArrows.forEach(rightArrow => {
            const scrollContainer = rightArrow.closest('div');

            updateArrowsVisibility(scrollContainer);

            // Si on est à la fin, on cache la flèche droite
            // const arrow = rightArrow.parentElement;
            // console.log("right", arrow);
            // arrow.style.visibility = scrollLeft < maxScrollLeft ? 'visible' : 'hidden';
        });
    }

    // Fonction pour défiler vers la gauche
    function scrollContainerLeft(event) {
        const arrow = event.target;
        const scrollContainer = arrow.closest('div');

        scrollContainer.scrollBy({
            left: -1000, // Pixels à défiler vers la gauche
            behavior: 'smooth'
        });
    }

    // Fonction pour défiler vers la droite
    function scrollContainerRight(event) {
        const arrow = event.target;
        const scrollContainer = arrow.closest('div');

        scrollContainer.scrollBy({
            left: 1000, // Pixels à défiler vers la droite
            behavior: 'smooth'
        });
    }

    // Ajout des écouteurs sur les boutons flèches
    leftArrows.forEach(arrow => arrow.addEventListener('click', scrollContainerLeft));
    rightArrows.forEach(arrow => arrow.addEventListener('click', scrollContainerRight));

    // Mise à jour dynamique de l'état des flèches au scroll
    scrollContainers.forEach(container => container.addEventListener('scrollend', (event) => updateArrowsVisibility(event.target)))

    // On vérifie la visibilité des flèches au chargement
    updateAllArrowsVisibility();

    // Réagit aussi quand la taille de l'écran change (ex : mobile → desktop)
    window.addEventListener('resize', updateAllArrowsVisibility);
});
