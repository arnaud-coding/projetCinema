<!---------------------->
<!-- TITRE DE LA PAGE -->
<!---------------------->
<div class="d-flex align-items-center">
    <!-- TITRE -->
    <h1 class="flex-grow-1 text-center fs-3 fst-italic">Ajouter un film</h1>

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
    <form id="filmForm" method="post" action="#" enctype="multipart/form-data" novalidate>

        <input type="hidden" id="controllerMethod" name="controllerMethod" value="<?= $controllerMethod ?>">

        <!-- TOKEN CSRF -->
        <input type="hidden" name="token" value="<?= $token ?>">

        <!-- CHAMP TITRE -->
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" id="title" class="form-control" name="title" placeholder="Entrez le titre">
            <p id="titleError" class="d-none text-danger"></p>
        </div>

        <!-- CHAMP SYNOPSIS -->
        <div class="mb-3">
            <label for="synopsis" class="form-label">Synopsis</label>
            <textarea id="synopsis" class="form-control" name="synopsis" rows="5" placeholder="Entrez le synopsis"></textarea>
            <p id="synopsisError" class="d-none text-danger"></p>
        </div>

        <!-- CHAMP ANNEE DE SORTIE -->
        <div class="mb-3">
            <label for="release_year" class="form-label">Année de sortie</label>
            <input type="number" id="release_year" class="form-control" name="release_year" min="1900">
            <p id="releaseYearError" class="d-none text-danger"></p>
        </div>

        <!-- CHAMP DUREE -->
        <div class="mb-3">
            <label for="duration" class="form-label">Durée en minutes</label>
            <input type="number" id="duration" class="form-control" name="duration" min="0">
            <p id="durationError" class="d-none text-danger"></p>
        </div>

        <!-- CHAMP IMAGE -->
        <div class="mb-3">
            <label for="picture" class="form-label">Image (optionnel)</label>
            <input id="picture" class="form-control" type="file" name="picture" accept="image/jpeg, image/jpg, image/png, image/webp, image/gif">
            <p id="pictureError" class="d-none text-danger"></p>
            <img id="picturePreview" src="" class="mt-3" style="max-width: 200px; max-height: 200px; display: none">
        </div>

        <!-- BOUTON D'ENVOI -->
        <div class="d-grid mt-4 mb-2">
            <button class="btn lightBtn btnWithBorders" type="submit">Valider</button>
        </div>
    </form>
</div>