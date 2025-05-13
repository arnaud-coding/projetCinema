<!---------------------->
<!-- TITRE DE LA PAGE -->
<!---------------------->
<div class="d-flex align-items-center">
    <!-- TITRE -->
    <h1 class="flex-grow-1 text-center fs-3 fst-italic">Ajouter un acteur</h1>

    <!-- BOUTON RETOUR -->
    <a class="btn darkBtn btnWithBorders" href="index.php?controller=Film&action=home"
        title="Retour en arrière">
        <i class="bi bi-x-lg"></i>
    </a>
</div>

<!-- MESSAGE ERREUR / SUCCES -->
<div id="message" class="text-center"></div>

<!---------------->
<!-- FORMULAIRE -->
<!---------------->
<div class="mx-auto lightForm formDarkMode p-3 my-3 w-75">
    <form id="addActorForm" method="post" action="#" enctype="multipart/form-data" novalidate>

        <!-- TOKEN CSRF -->
        <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION["token"]["id"], ENT_QUOTES, "UTF-8") ?>">

        <!-- CHAMP PRENOM -->
        <div class="mb-3">
            <label for="firstname" class="form-label">Prénom</label>
            <input id="firstname" class="form-control" type="text" name="firstname" placeholder="Entrez le prénom">
            <p id="firstnameError" class="d-none text-danger"></p>
        </div>

        <!-- CHAMP NOM -->
        <div class="mb-3">
            <label for="lastname" class="form-label">Nom</label>
            <input id="lastname" type="text" class="form-control" name="lastname" placeholder="Entrez le nom">
            <span id="lastnameError" class="d-none text-danger"></span>
        </div>

        <!-- CHAMP DATE DE NAISSANCE -->
        <div class="mb-3">
            <label for="birth_date" class="form-label">Date de naissance</label>
            <input id="birth_date" class="form-control" type="date" name="birth_date">
            <span id="birthDateError" class="d-none text-danger"></span>
        </div>

        <!-- CHAMP DATE DE DECES -->
        <div class="mb-3">
            <label for="death_date" class="form-label">Date de décès (optionnel)</label>
            <input id="death_date" class="form-control" type="date" name="death_date">
            <span id="deathDateError" class="d-none text-danger"></span>
        </div>

        <!-- CHAMP BIOGRAPHIE -->
        <div class="mb-3">
            <label for="biography" class="form-label">Biographie (optionnel)</label>
            <textarea id="biography" class="form-control" type="text" name="biography" rows="5" placeholder="Renseignez une biographie"></textarea>
            <span id="biographyError" class="d-none text-danger"></span>
        </div>

        <!-- CHAMP NATIONALITE -->
        <div class="mb-3">
            <label for="nationality" class="form-label">Nationalité (optionnel)</label>
            <input id="nationality" class="form-control" type="text" name="nationality" placeholder="Renseignez la nationalité">
            <span id="nationalityError" class="d-none text-danger"></span>
        </div>

        <!-- CHAMP IMAGE -->
        <div class="mb-3">
            <label for="picture" class="form-label">Image (optionnel)</label>
            <input id="picture" class="form-control" type="file" name="picture" accept="image/png, image/jpeg, image/jpg, image/gif">
            <span id="pictureError" class="d-none text-danger"></span>
            <img id="picturePreview" src="" class="mt-3" style="max-width: 200px; max-height: 200px; display: none">
        </div>

        <!-- BOUTON D'ENVOI -->
        <div class="d-grid mt-4 mb-2">
            <button class="btn lightBtn btnWithBorders" type="submit">Valider</button>
        </div>
    </form>
</div>