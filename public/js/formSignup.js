// -----------------------------------------
// validation du formulaire
// -----------------------------------------
document.getElementById('formSignup').addEventListener('submit', function (e) {
    e.preventDefault();
    let isValid = true;
    /*

    // Validation du titre de la creation
    const title = document.querySelector('#title');
    const titleError = document.getElementById('titleError');
    if (title.value.length < 5) {
        titleError.textContent = "Le titre de la création doit contenir au moins 5 caractères";
        titleError.style.display = "block";
        isValid = false;
    } else {
        titleError.style.display = "none";
    }

    // Validation de la description de la creation
    const description = document.querySelector('#description');
    const descriptionError = document.getElementById('descriptionError');
    if (description.value.length < 8) {
        descriptionError.textContent = "La description de la création doit contenir au moins 8 caractères";
        descriptionError.style.display = "block";
        isValid = false;
    } else {
        descriptionError.style.display = "none";
    }

    // Validation de la date de création de la creation
    const created_at = document.querySelector('#created_at');
    const created_atError = document.getElementById('created_atError');
    if (created_at.value === '') {
        created_atError.textContent = "Veuillez renseigner une date de création";
        created_atError.style.display = "block";
        isValid = false;
    } else {
        created_atError.style.display = "none";
    }

    // Validation de l'image de la creation
    const picture = document.querySelector('#picture');
    const pictureError = document.getElementById('pictureError');
    if (picture.value === '') {
        pictureError.textContent = "Veuillez uploader un fichier";
        pictureError.style.display = "block";
        isValid = false;
    } else {
        pictureError.style.display = "none";
    }

    // Validation de la catégorie de la creation
    const categorie = document.querySelector('#categorie');
    const categorieError = document.getElementById('categorieError');
    if (categorie.value === '') {
        categorieError.textContent = "Veuillez sélectionner une catégorie";
        categorieError.style.display = "block";
        isValid = false;
    } else {
        categorieError.style.display = "none";
    }

    // test de validation de la globalité du formulaire
    const formSuccess = document.querySelector('#formSuccess');
    const formFailure = document.querySelector('#formFailure');
*/

    // ------------ Formulaire validé : soumission du formulaire
    if (isValid) {
        // AJAX
        document.querySelector('#formSignup').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
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
        });
    }
})