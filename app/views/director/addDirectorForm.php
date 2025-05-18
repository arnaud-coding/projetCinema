<!---------------------->
<!-- TITRE DE LA PAGE -->
<!---------------------->
<div class="d-flex align-items-center">
    <!-- TITRE -->
    <h1 class="flex-grow-1 text-center fs-3 fst-italic">Ajouter un réalisateur</h1>

    <!-- BOUTON RETOUR -->
    <a class="btn darkBtn btnWithBorders" href="index.php?controller=Film&action=home"
        title="Retour en arrière">
        <i class="bi bi-x-lg"></i>
    </a>
</div>

<!---------------->
<!-- FORMULAIRE -->
<!---------------->
<div class="mx-auto lightForm formDarkMode p-3 my-3 w-75">
    <form id="<?= $entity ?>Form" method="post" action="#" enctype="multipart/form-data" novalidate>

        <input type="hidden" id="entity" name="entity" value="<?= $entity ?>">
        <input type="hidden" id="controllerMethod" name="controllerMethod" value="<?= $controllerMethod ?>">

        <!-- TOKEN CSRF -->
        <input type="hidden" name="token" value="<?= $token ?>">

        <!-- CHAMP PRENOM -->
        <div class="mb-3">
            <label for="firstname" class="form-label">Prénom</label>
            <input type="text" id="firstname" class="form-control" name="firstname" placeholder="Entrez le prénom">
            <p id="firstnameError" class="d-none text-danger"></p>
        </div>

        <!-- CHAMP NOM -->
        <div class="mb-3">
            <label for="lastname" class="form-label">Nom</label>
            <input type="text" id="lastname" class="form-control" name="lastname" placeholder="Entrez le nom">
            <p id="lastnameError" class="d-none text-danger"></p>
        </div>

        <!-- CHAMP DATE DE NAISSANCE -->
        <div class="mb-3">
            <label for="birth_date" class="form-label">Date de naissance</label>
            <input type="date" id="birth_date" class="form-control" name="birth_date">
            <p id="birthDateError" class="d-none text-danger"></p>
        </div>

        <!-- CHAMP DATE DE DECES -->
        <div class="mb-3">
            <label for="death_date" class="form-label">Date de décès (optionnel)</label>
            <input type="date" id="death_date" class="form-control" name="death_date">
            <p id="deathDateError" class="d-none text-danger"></p>
        </div>

        <!-- CHAMP BIOGRAPHIE -->
        <div class="mb-3">
            <label for="biography" class="form-label">Biographie (optionnel)</label>
            <textarea id="biography" class="form-control" name="biography" rows="5" placeholder="Renseignez une biographie"></textarea>
            <p id="biographyError" class="d-none text-danger"></p>
        </div>

        <!-- CHAMP NATIONALITE -->
        <div class="mb-3">
            <label for="nationality" class="form-label">Nationalité (optionnel)</label>
            <input id="nationality" class="form-control" type="text" name="nationality" placeholder="Renseignez la nationalité">
            <p id="nationalityError" class="d-none text-danger"></p>
        </div>

        <!-- CHAMP IMAGE -->
        <div class="mb-3">
            <label for="picture" class="form-label">Image (optionnel)</label>
            <input type="file" id="picture" class="form-control" name="picture" accept="image/jpeg, image/jpg, image/png, image/webp, image/gif">
            <p id="pictureError" class="d-none text-danger"></p>
            <img id="picturePreview" src="" class="mt-3" style="max-width: 200px; max-height: 200px; display: none">
        </div>

        <!-- BOUTON D'ENVOI -->
        <div class="d-grid mt-4 mb-2">
            <button class="btn lightBtn btnWithBorders" type="submit">Valider</button>
        </div>
    </form>
</div>