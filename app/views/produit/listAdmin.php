<!---------------------->
<!-- TITRE DE LA PAGE -->
<!---------------------->
<div class="d-flex align-items-center">
    <!-- TITRE -->
    <h1 class="flex-grow-1 text-center fs-3 fst-italic">Liste des livres</h1>

    <!-- BOUTON RETOUR -->
    <a class="btn btn-outline-secondary" href="index.php?controller=Utilisateur&action=menuAdmin"
        title="Retour en arrière">
        <i class="bi bi-x-lg"></i>
    </a>
</div>

<!-------------------->
<!-- CREER UN LIVRE -->
<!-------------------->
<div class="d-flex justify-content-center my-3">
    <!-- <a class="btn btn-secondary" href="index.php?controller=Livre&action=formCreate">Créer un livre</a> -->
    <button id="btnToken" type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFormCreate">Créer un livre</button>
</div>

<!------------------------>
<!-- TABLEAU DES LIVRES -->
<!------------------------>
<table class="table table-bordered table-hover text-center align-middle my-3">

    <!-- ENTÊTE DU TABLEAU -->
    <thead class="table-secondary">
        <tr>
            <th scope="col">Titre</th>
            <th scope="col">Auteur</th>
            <th scope="col">Genre</th>
            <th scope="col">Année</th>
            <th scope="col">Statut</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>

    <!-- CORPS DU TABLEAU -->
    <tbody id="tabLivre">
        <?php foreach ($livres as $livre) : ?>
            <tr>
                <td class="text-start ps-3"><?php echo htmlspecialchars($livre->titre, ENT_QUOTES, "UTF-8"); ?></td>
                <td class="text-start ps-3"><?php echo htmlspecialchars($livre->auteur, ENT_QUOTES, "UTF-8"); ?></td>
                <td class="text-start ps-3"><?php echo htmlspecialchars($livre->genre, ENT_QUOTES, "UTF-8"); ?></td>
                <td><?php echo htmlspecialchars($livre->annee, ENT_QUOTES, "UTF-8"); ?></td>
                <td>
                    <?php if ($livre->statut == 0) : ?>
                        <span class="badge bg-success">Disponible</span>
                    <?php else : ?>
                        <span class="badge bg-warning">Réservé</span>
                    <?php endif; ?>
                <td>
                    <a class="btn btn-sm btn-warning" href="index.php?controller=Livre&action=formUpdate&id_livre=<?php echo htmlspecialchars($livre->id_livre, ENT_QUOTES, "UTF-8"); ?>"
                        title="Modifier">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a class="btn btn-sm btn-danger" href="index.php?controller=Livre&action=delete&id_livre=<?php echo htmlspecialchars($livre->id_livre, ENT_QUOTES, "UTF-8"); ?>&token=<?php echo $_SESSION["token"]["id"]; ?>"
                        title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet livre ?');">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal -->
<?php include "formCreate.php"; ?>