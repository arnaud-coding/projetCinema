// ----------------------
// DARK MODE - LIGHT MODE
// ----------------------

// SELECTION DES ELEMENTS DU DOM
const btnModeDark = document.querySelector("#btnModeDark");
const navs = document.querySelectorAll(".navbar");
const main = document.querySelector("main");
const footer = document.querySelector("footer");
const buttonLinks = document.querySelectorAll(".buttonLinks");
const profileBtn = document.querySelectorAll(".profileBtn");
const userIcon = document.querySelector("#userIcon");
const dropdownUserLinks = document.querySelectorAll(".dropdownUserLinks");
const menuLinks = document.querySelectorAll(".menuLinks");
const socialIcons = document.querySelectorAll(".socialIcons");
const filmsLink = document.querySelectorAll(".filmLink");

// RECUPERATION DU MODE DANS LE LOCALSTORAGE
let darkMode = localStorage.getItem("darkMode") === 'true';

// INITIALISATION DU MODE
if (darkMode) {
    toggleDarkMode();
}

// CHANGEMENT DE MODE AU CLICK
btnModeDark.addEventListener("click", () => {
    darkMode = !darkMode;
    toggleDarkMode();
});

// FONCTION CHANGEMENT DE MODE
function toggleDarkMode() {

    btnModeDark.classList.toggle("bi-moon-fill");
    btnModeDark.classList.toggle("bi-sun-fill");
    btnModeDark.classList.toggle("text-warning");
    btnModeDark.classList.toggle("text-dark");

    userIcon.classList.toggle("text-dark");
    userIcon.classList.toggle("text-light");

    navs.forEach((nav) => {
        nav.classList.toggle("darkBg");
    });
    buttonLinks.forEach((button) => {
        button.classList.toggle("btn-outline-dark");
        button.classList.toggle("btn-outline-light");
    });
    profileBtn.forEach((button) => {
        button.classList.toggle("darkBtn");
        button.classList.toggle("lightBtn");
    });
    dropdownUserLinks.forEach((link) => {
        link.classList.toggle("darkBg");
        link.classList.toggle("lightBg");
    });
    menuLinks.forEach((link) => {
        link.classList.toggle("darkTypo");
        link.classList.toggle("lightTypo");
    });
    filmsLink.forEach((link) => {
        link.classList.toggle("darkTypo");
        link.classList.toggle("lightTypo");
    })
    main.classList.toggle("darkBg");
    footer.classList.toggle("darkBg");

    localStorage.setItem("darkMode", darkMode);
}

// OPACITE AU SURVOL
btnModeDark.addEventListener("mouseover", () => {
    btnModeDark.classList.add("opacity-75");
});
btnModeDark.addEventListener("mouseout", () => {
    btnModeDark.classList.remove("opacity-75");
});
socialIcons.forEach((icon) => {
    icon.addEventListener("mouseover", () => {
        icon.classList.add("opacity-75");
    });
    icon.addEventListener("mouseout", () => {
        icon.classList.remove("opacity-75");
    });
});


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


// ----------------------------
// FORM VALIDATION (common part)
// ----------------------------
//! Les formulaires utilisant cette function doivent comporter les éléments msgFailure/success
function validateForm(formData, isValid) {
    if (isValid) {
        const msgFailure = document.querySelector("#message-failure");
        const msgSuccess = document.querySelector("#message-success");
        msgFailure.innerHTML = "";
        msgSuccess.innerHTML = "";

        fetch("index.php?controller=User&action=create", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.redirect) {
                    // redirection demandée par la réponse du controlleur
                    window.location.href = data.redirect;
                } else {
                    // navigation non demandée : afficher message reçu
                    if (data.success === true) {
                        this.reset();
                        // afficher message de succès
                        msgSuccess.textContent = data.message;
                    } else {
                        // afficher message d'erreur
                        msgFailure.textContent = data.message;
                    }
                }
            })
            .catch(error => {
                console.error(error);
                msgFailure.textContent = "Erreur lors de l'envoi du formulaire";
            });

    }
}