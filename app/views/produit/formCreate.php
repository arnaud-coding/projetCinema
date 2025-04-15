<!---------------->
<!-- FORMULAIRE -->
<!---------------->
<div class="modal fade" id="modalFormCreate" tabindex="-1" aria-labelledby="modalFormCreate" aria-hidden="true">>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- ENTETE DU FORMULAIRE -->
            <div class="modal-header">
                <h2 class="flex-grow-1 text-center fs-3 fst-italic">Créer un livre</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- CORPS DU FORMULAIRE -->
            <div class="modal-body">
                <form id="form" method="post" action="index.php?controller=Livre&action=create">

                    <!-- TOKEN CSRF -->
                    <input id="token" type="hidden" name="token" value=""> 

                    <!-- CHAMP TITRE -->
                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre</label>
                        <input id="titre" class="form-control form-control-sm" type="text" name="titre" placeholder="Entrez le titre du livre">
                        <span id="titreError" class="form-text text-danger"></span>
                    </div>

                    <!-- CHAMP NOM -->
                    <div class="mb-3">
                        <label for="auteur" class="form-label">Auteur</label>
                        <input id="auteur" class="form-control form-control-sm" type="text" name="auteur" placeholder="Entrez le nom de l'auteur">
                        <span id="auteurError" class="form-text text-danger"></span>
                    </div>

                    <!-- CHAMP GENRE -->
                    <div class="mb-3">
                        <label for="genre" class="form-label">Genre</label>
                        <input id="genre" class="form-control form-control-sm" type="text" name="genre" placeholder="Entrez le genre du livre">
                        <span id="genreError" class="form-text text-danger"></span>
                    </div>

                    <!-- CHAMP ANNEE -->
                    <div class="mb-3">
                        <label for="annee" class="form-label">Année</label>
                        <input id="annee" class="form-control form-control-sm" type="number" name="annee" placeholder="Entrez l'année de parution">
                        <span id="anneeError" class="form-text text-danger"></span>
                    </div>

                    <!-- BOUTON D'ENVOI -->
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-secondary" type="submit">Valider</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>