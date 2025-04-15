<!---------------------->
<!-- TITRE DE LA PAGE -->
<!---------------------->
<div class="d-flex align-items-center">

    <!-- TITRE -->
    <h1 class="flex-grow-1 text-center fs-3 fst-italic">Modifier le livre</h1>

    <!-- BOUTON RETOUR -->
    <a class="btn btn-outline-secondary" href="index.php?controller=Livre&action=listAdmin"
        title="Retour en arrière">
        <i class="bi bi-x-lg"></i>
    </a>
</div>

<!---------------->
<!-- FORMULAIRE -->
<!---------------->
<div class="card w-50 mx-auto my-3">
    <div class="card-body">
        <form id="form" method="post" action="index.php?controller=Livre&action=update">

            <!-- TOKEN CSRF -->
            <input type="hidden" name="token" value="<?php echo $_SESSION["token"]["id"]; ?>">

            <!-- CHAMP ID -->
            <input type="hidden" name="id_livre" value="<?php echo htmlspecialchars($livre->id_livre, ENT_QUOTES, "UTF-8") ?>">

            <!-- CHAMP TITRE -->
            <div class="mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input id="titre" class="form-control form-control-sm" type="text" name="titre" value="<?php echo htmlspecialchars($livre->titre, ENT_QUOTES, "UTF-8"); ?>">
                <span id="titreError" class="form-text text-danger"></span>
            </div>

            <!-- CHAMP NOM -->
            <div class="mb-3">
                <label for="auteur" class="form-label">Auteur</label>
                <input id="auteur" class="form-control form-control-sm" type="text" name="auteur" value="<?php echo htmlspecialchars($livre->auteur, ENT_QUOTES, "UTF-8"); ?>">
                <span id="auteurError" class="form-text text-danger"></span>
            </div>

            <!-- CHAMP GENRE -->
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input id="genre" class="form-control form-control-sm" type="text" name="genre" value="<?php echo htmlspecialchars($livre->genre, ENT_QUOTES, "UTF-8"); ?>">
                <span id="genreError" class="form-text text-danger"></span>
            </div>

            <!-- CHAMP ANNEE -->
            <div class="mb-3">
                <label for="annee" class="form-label">Année</label>
                <input id="annee" class="form-control form-control-sm" type="number" name="annee" value="<?php echo htmlspecialchars($livre->annee, ENT_QUOTES, "UTF-8"); ?>">
                <span id="anneeError" class="form-text text-danger"></span>
            </div>

            <!-- BOUTON D'ENVOI -->
            <div class="d-flex justify-content-center">
                <button class="btn btn-secondary" type="submit">Valider</button>
            </div>
        </form>
    </div>
</div>