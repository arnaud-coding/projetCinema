// ----------------------
// DARK MODE - LIGHT MODE
// ----------------------

// SELECTION DES ELEMENTS DU DOM
const btnModeDark = document.querySelector("#btnModeDark");
const main = document.querySelector("main");
const h1 = document.querySelector("h1");

// RECUPERATION DU MODE DANS LE LOCALSTORAGE
let darkMode = JSON.parse(localStorage.getItem("darkMode"));


// INITIALISATION DU MODE
if (darkMode) {
    fctDarkMode();
}

// CHANGEMENT DE MODE AU CLICK
btnModeDark.addEventListener("click", () => {
    fctDarkMode();
    localStorage.setItem("darkMode", JSON.stringify(!darkMode));
});

// FONCTION CHANGEMENT DE MODE
function fctDarkMode() {
    btnModeDark.classList.toggle("text-black");
    btnModeDark.classList.toggle("text-warning");
    main.classList.toggle("bg-secondary");
    main.classList.toggle("bg-light");
    h1.classList.toggle("text-white");
    h1.classList.toggle("text-black");
}


// ------------
// POPUP COOKIE
// ------------

// SELECTION DES ELEMENTS DU DOM
const modalCookie = new bootstrap.Modal(document.querySelector("#modalCookie"));
const btnCookieRefuse = document.querySelector("#btnCookieRefuse");
const btnCookieAccept = document.querySelector("#btnCookieAccept");


// CONTROLE DE L'EXISTENCE D'UN COOKIE D'ACCEPTATION
fetch("index.php?controller=User&action=ctrlCookie")
    .then((response) => response.json()) // On récupère la réponse et on la transforme en objet JSON
    .then((data) => // On récupère les données
    {
        if (!data) modalCookie.show();
    })
    .catch(error => {
        console.error("Erreur:", error);
    });

// ACCEPTATION DES COOKIES
btnCookieAccept.addEventListener("click", () => {
    fetch("index.php?controller=User&action=validCookie&cookie=accept")
        .then((response) => response.json()) // On récupère la réponse et on la transforme en objet JSON
        .then((data) => // On récupère les données
        {
            if (data) modalCookie.hide();
        })
        .catch(error => {
            console.error("Erreur:", error);
        });
});

// REFUS DES COOKIES
btnCookieRefuse.addEventListener("click", () => {
    fetch("index.php?controller=Utilisateur&action=validCookie")
        .then((response) => response.json()) // On récupère la réponse et on la transforme en objet JSON
        .then((data) => // On récupère les données
        {
            if (data) modalCookie.hide();
        })
        .catch(error => {
            console.error("Erreur:", error);
        });
});


// -----------------------
// FLECHE SCROLL HAUT PAGE
// -----------------------

// SELECTION DE LA FLECHE
const arrowScroll = document.querySelector("#arrowScroll");


// AFFICHAGE DE LA FLECHE AU SCROLL
window.addEventListener("scroll", () => {
    if (window.scrollY > 100) {
        arrowScroll.style.visibility = "visible";
    } else {
        arrowScroll.style.visibility = "hidden";
    }
})

// RETOUR HAUT DE PAGE AU CLICK
arrowScroll.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // Pour un défilement doux
    });
});