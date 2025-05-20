// -----------
// Scroll vers haut de page pour voir message d'erreur global ou succès
// -----------
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // Pour un défilement doux
    });
}

// -----------
// Fonctions de vérification de l'année de sortie
// -----------
function checkReleaseYear(year) {

    if (year === "") {
        return { valid: false, message: "veuillez saisir une année de sortie" };
    }

    year = parseInt(year);

    // Définition des limites
    const minYear = 1900;
    const maxYear = new Date().getFullYear() + 2;

    if (year < minYear) {
        return { valid: false, message: "L'année de sortie ne peut pas être antérieure à 1900" };
    }
    if (year > maxYear) {
        return { valid: false, message: "L'année de sortie ne peut pas être de + de 2 ans dans le futur" };
    }

    return { valid: true };
}

// ---------------------
// validation du formulaire
// ---------------------
const controllerMethod = document.querySelector("#controllerMethod").value;

document.querySelector(`#filmForm`).addEventListener('submit', function (e) {
    e.preventDefault();
    let isValid = true;

    // Validation du titre
    const title = document.querySelector('#title');
    const titleError = document.querySelector('#titleError');
    if (title.value.length < 2) {
        titleError.textContent = "Le titre doit contenir au moins 2 caractères";
        titleError.classList.remove("d-none");
        isValid = false;
    } else {
        titleError.classList.add("d-none");
    }

    // Validation du synopsis
    const synopsis = document.querySelector('#synopsis');
    const synopsisError = document.querySelector('#synopsisError');
    if (synopsis.value.length < 30) {
        synopsisError.textContent = "Le synopsis doit contenir au moins 2 caractères";
        synopsisError.classList.remove("d-none");
        isValid = false;
    } else {
        synopsisError.classList.add("d-none");
    }

    // Validation de l'année de sortie
    const release_year = document.querySelector('#release_year');
    const releaseYearError = document.querySelector('#releaseYearError');
    const checkYear = checkReleaseYear(release_year.value);
    if (checkYear.valid === false) {
        releaseYearError.textContent = checkYear.message;
        releaseYearError.classList.remove("d-none");
        isValid = false;
    } else {
        releaseYearError.classList.add("d-none");
    }

    // Validation de la durée
    const duration = document.querySelector('#duration');
    const durationError = document.querySelector('#durationError');
    if (duration.value === "") {
        durationError.textContent = "Veuillez saisir une durée pour le film (en minutes)";
        durationError.classList.remove("d-none");
        isValid = false;
    } else if (parseInt(duration.value) > 600) {
        durationError.textContent = "la durée du film ne peut dépasser 600 minutes (10 heures)";
        durationError.classList.remove("d-none");
        isValid = false;
    } else {
        durationError.classList.add("d-none");
    }

    // Test de validation de la globalité du formulaire
    if (isValid) {
        console.log("coucou");
        const formData = new FormData(this);
        const message = document.querySelector('#message');
        fetch(`index.php?controller=Film&action=${controllerMethod}`, {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success === true) {
                    this.reset();
                    document.querySelector('#picturePreview').innerHTML = "";
                    message.innerHTML = `<p class='text-success'>${data.message}</p>`;
                } else {
                    message.innerHTML = `<p class='text-danger'>${data.message}</p>`;
                }
            })
            .catch(error => {
                message.innerHTML = "<p class='text-danger'>Erreur lors de l'envoi du formulaire</p>";
            });
        scrollToTop();

    }
});

// -----------------------------------------
// prévisualisation de l'image uploadée
// -----------------------------------------
const picture = document.querySelector('#picture');
const picturePreview = document.querySelector('#picturePreview');
const reader = new FileReader();

picture.addEventListener('change', () => {
    const file = picture.files[0]; // Récupère le fichier sélectionné
    if (file) {
        reader.readAsDataURL(file); // Lit le fichier comme URL
    }
});

// Événement déclenché lorsque le fichier est lu
reader.onload = () => {
    picturePreview.src = reader.result; // Définit la source de l'image
    picturePreview.style.display = 'block';
};
