// -----------
// Fonctions de vérification des <input type="date">
// -----------
function birthDateChecking(dateStr) {
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

function deathDateChecking(dateStr) {
    // Si une date de décès est saisie, on la vérifie
    if (deathDateValue !== "") {

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

        if (inputDate > today) {
            return { valid: true };
        } else {
            return { valid: false, message: "La date de décès ne peut pas être postérieure à la date actuelle" };
        }

    } else {
        // Champ vide : pas d'erreur (décès inconnu ou personne encore en vie)
        return { valid: true }
    }
}

// ---------------------
// validation du formulaire
// ---------------------
document.getElementById('creationForm').addEventListener('submit', function (e) {
    e.preventDefault();
    let isValid = true;

    // Validation du nom et du  prénom de l'acteur
    const firstname = document.querySelector('#firstname');
    const firstnameError = document.getElementById('#firstnameError');
    const lastname = document.querySelector('#lastname');
    const lastnameError = document.getElementById('#lastnameError');
    if (title.value.length < 2 &&) {
        firstnameError.textContent = "Le prénom de l'acteur doit contenir au moins 2 caractères";
        firstnameError.style.display = "block";
        lastnameError.textContent = "Le nom de l'acteur doit contenir au moins 2 caractères";
        lastnameError.style.display = "block";
        isValid = false;
    } else {
        firstnameError.style.display = "none";
        lastnameError.style.display = "none";
    }

    // Validation de la date de naissance de l'acteur
    const birth_date = document.querySelector('#birth_date');
    const birthDateError = document.querySelector('#birthDateError');
    const birthCheck = birthDateChecking(birth_date.value);
    if (birthCheck.valid === false) {
        birthDateError.textContent = birthCheck.message;
        birthDateError.style.display = "block";
        isValid = false;
    } else {
        birthDateError.style.display = "none";
    };

    // Validation de la date de décès de l'acteur
    const death_date = document.querySelector('#death_date');
    const deathDateError = document.querySelector('#deathDateError');
    const deathCheck = deathDateChecking(death_date.value);
    if (birthCheck.valid === false) {
        deathDateError.textContent = birthCheck.message;
        deathDateError.style.display = "block";
        isValid = false;
    } else {
        deathDateError.style.display = "none";
    };

    // Validation de la biographie de l'acteur
    const biography = document.querySelector('#biography');
    const biographyError = document.querySelector('#biographyError');
    if (biographie.value !== "") {
        // Si une biographie est saisie, on la vérifie
        if (biography.value.length <= 50) {
            biographyError.textContent = "La biographie doit contenir au moin 30 caractères";
            biographyError.style.display = "block";
            isValid = false;
        } else {
            biographyError.style.display = "none";
        }
    } else {
        // Champ vide : pas d'erreur (colonne biographie NULL)
        biographyError.style.display = "none";
    }
    ;

    // Validation de la nationalité de l'acteur
    const nationality = document.querySelector('#nationality');
    const nationalityError = document.querySelector('#nationalityError');
    if (biographie.value !== "") {
        // Si une nationalité est saisie, on la vérifie
        if (nationality.value.length <= 5) {
            nationalityError.textContent = "La nationalité doit contenir au moin 5 caractères";
            nationalityError.style.display = "block";
            isValid = false;
        } else {
            nationalityError.style.display = "none";
        }
    } else {
        // Champ vide : pas d'erreur (colonne biographie NULL)
        nationalityError.style.display = "none";
    };

    // Test de validation de la globalité du formulaire
    if (isValid) {
        document.querySelector('#addActorForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const message = document.querySelector('#message');
            fetch("index.php?controller=Actor&action=add", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {
                        this.reset();
                        message.innerHTML = `<p class='text-success'>${data.message}</p>`;
                    } else {
                        message.innerHTML = `<p class='text-danger'>${data.message}</p>`;
                    }
                })
                .catch(error => {
                    message.textContent = "Erreur lors de l'envoi du formulaire";
                })
        })
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
    console.log('eventHandler: readFileName', file);
    if (file) {
        console.log('eventHandler: reader.readAsDataURL(file)');
        reader.readAsDataURL(file); // Lit le fichier comme URL
    }
});

// Événement déclenché lorsque le fichier est lu
reader.onload = () => {
    console.log("onload: load done")
    picturePreview.src = reader.result; // Définit la source de l'image
    picturePreview.style.display = 'block';
};
