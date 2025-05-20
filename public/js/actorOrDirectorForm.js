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
// Fonctions de vérification des <input type="date">
// -----------
function checkBirthDate(dateStr) {
    // Vérifie que la date soit bien au format YYYY-MM-DD et soit renseignée
    const regex = /^\d{4}-\d{2}-\d{2}$/;
    if (!regex.test(dateStr || dateStr.length === "")) {
        return { valid: false, message: "Format de date invalide (attendu : YYYY-MM-DD) ou date nom renseignée" };
    }

    // Conversion de la chaîne en objet Date
    const inputDate = new Date(dateStr);
    if (isNaN(inputDate)) {
        return { valid: false, message: "Date invalide." };
    }

    // Date minimale : 1er janvier 1900
    const minDate = new Date("1900-01-01");

    // Date actuelle
    const today = new Date();

    // Date il y a 5 ans
    const fiveYearsAgo = new Date();
    fiveYearsAgo.setFullYear(today.getFullYear() - 5);

    // Vérifie que la date soit antérieure ou égale à il y a 5 ans et n'est pas antérieure à l'année 1900
    if (inputDate <= fiveYearsAgo && inputDate >= minDate) {
        return { valid: true };
    } else {
        return {
            valid: false,
            message: "La date de naissance doit être éloignée d'au moins 5 ans de la date actuelle et ne peut pas être antérieure à l'année 1900"
        };
    }
}

function checkDeathDate(dateStr) {
    // Si une date de décès est saisie, on la vérifie
    if (dateStr !== "") {

        // Vérifie si la date est bien au format YYYY-MM-DD
        const regex = /^\d{4}-\d{2}-\d{2}$/;
        if (!regex.test(dateStr)) {
            return { valid: false, message: "Format de date invalide (attendu : YYYY-MM-DD)." };
        }

        // Conversion de la chaîne en objet Date
        const inputDate = new Date(dateStr);
        if (isNaN(inputDate)) {
            return { valid: false, message: "Date invalide." };
        }

        // Date actuelle
        const today = new Date()

        if (inputDate >= today) {
            return { valid: false, message: "La date de décès ne peut pas être postérieure à la date actuelle" };
        } else {
            return { valid: true };
        }

    } else {
        // Champ vide : pas d'erreur (décès inconnu ou personne encore en vie)
        return { valid: true }
    }
}

// ---------------------
// validation du formulaire
// ---------------------
const entity = document.querySelector("#entity").value;
const controllerMethod = document.querySelector("#controllerMethod").value;

document.querySelector(`#${entity}Form`).addEventListener('submit', function (e) {
    e.preventDefault();
    let isValid = true;

    // Validation du prénom
    const firstname = document.querySelector('#firstname');
    const firstnameError = document.querySelector('#firstnameError');
    if (firstname.value.length < 2) {
        firstnameError.textContent = "Le prénom doit contenir au moins 2 caractères";
        firstnameError.classList.remove("d-none");
        isValid = false;
    } else {
        firstnameError.classList.add("d-none");
    }

    // Validation du nom
    const lastname = document.querySelector('#lastname');
    const lastnameError = document.querySelector('#lastnameError');
    if (lastname.value.length < 2) {
        lastnameError.textContent = "Le nom doit contenir au moins 2 caractères";
        lastnameError.classList.remove("d-none");
        isValid = false;
    } else {
        lastnameError.classList.add("d-none");
    }

    // Validation de la date de naissance
    const birth_date = document.querySelector('#birth_date');
    const birthDateError = document.querySelector('#birthDateError');
    const birthCheck = checkBirthDate(birth_date.value);
    if (birthCheck.valid === false) {
        birthDateError.textContent = birthCheck.message;
        birthDateError.classList.remove("d-none");
        isValid = false;
    } else {
        birthDateError.classList.add("d-none");
    }

    // Validation de la date de décès
    const death_date = document.querySelector('#death_date');
    const deathDateError = document.querySelector('#deathDateError');
    const deathCheck = checkDeathDate(death_date.value);
    if (deathCheck.valid === false) {
        deathDateError.textContent = deathCheck.message;
        deathDateError.classList.remove("d-none");
        isValid = false;
    } else {
        deathDateError.classList.add("d-none");
    }

    // Validation de la biographie
    const biography = document.querySelector('#biography');
    const biographyError = document.querySelector('#biographyError');
    if (biography.value !== "") {
        // Si une biographie est saisie, on la vérifie
        if (biography.value.length <= 50) {
            biographyError.textContent = "La biographie doit contenir au moin 30 caractères";
            biographyError.classList.remove("d-none");
            isValid = false;
        } else {
            biographyError.classList.add("d-none");
        }
    } else {
        // Champ vide : pas d'erreur (colonne biographie NULL)
        biographyError.classList.add("d-none");
    }

    // Validation de la nationalité
    const nationality = document.querySelector('#nationality');
    const nationalityError = document.querySelector('#nationalityError');
    if (nationality.value !== "") {
        // Si une nationalité est saisie, on la vérifie
        if (nationality.value.length <= 5) {
            nationalityError.textContent = "La nationalité doit contenir au moin 5 caractères";
            nationalityError.classList.remove("d-none");
            isValid = false;
        } else {
            nationalityError.classList.add("d-none");
        }
    } else {
        // Champ vide : pas d'erreur (colonne nationality NULL)
        nationalityError.classList.add("d-none");
    }

    // Test de validation de la globalité du formulaire
    if (isValid) {

        const formData = new FormData(this);
        const message = document.querySelector('#message');
        fetch(`index.php?controller=${entity}&action=${controllerMethod}`, {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
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
