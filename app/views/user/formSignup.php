<!---------------------->
<!-- TITRE DE LA PAGE -->
<!---------------------->
<div class="d-flex align-items-center">

    <!-- TITRE -->
    <h1 class="flex-grow-1 text-center fs-3 fst-italic">Inscription</h1>

    <!-- BOUTON RETOUR -->
    <a class="btn btn-outline-secondary" href="index.php?controller=User&action=formLogin"
        title="Retour en arrière">
        <i class="bi bi-x-lg"></i>
    </a>
</div>

<!-- MESSAGE D'ERREUR -->
<?php
$message = isset($_GET['message']) ? $_GET['message'] : '';
$success = isset($_GET['success']) ? $_GET['success'] : null;
// Afficher uniquement quand success est passé (true or false)
if ($success !== null) {
    if ($success === '1') {
?>
        <p class="text-center text-success"><?php echo $message ?></p>
    <?php
    } else {
    ?>
        <p class="text-center text-danger"><?php echo $message ?></p>
<?php
    }
}
?>
<!---------------->
<!-- FORMULAIRE -->
<!---------------->
<div class="card w-50 mx-auto my-3">
    <div class="card-body">
        <form method="post" action="index.php?controller=User&action=create" novalidate>

            <!-- TOKEN CSRF -->
            <input type="hidden" name="token" value="<?php echo $_SESSION["token"]["id"]; ?>">

            <!-- CHAMP EMAIL -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" class="form-control form-control-sm" type="email" name="email" placeholder="Entrez votre email">
            </div>

            <!-- CHAMP PSEUDO -->
            <div class="mb-3">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input id="pseudo" class="form-control form-control-sm" type="text" name="pseudo" placeholder="Entrez votre pseudo">
            </div>

            <!-- CHAMP MDP -->
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input id="password" class="form-control form-control-sm" type="password" name="password" placeholder="Entrez votre mot de passe">
            </div>

            <!-- CHAMP TYPE D'UTILISATEUR -->
            <?php
            // vérifie qu'aucun utilisateur n'est connecté
            if (!isset($_SESSION['type'])) {
                // si aucun utilisateur connecté : on crée un utilisateur de type 'user' par défault
            ?>
                <input type="hidden" name="type" value="user">
            <?php
            } elseif ($_SESSION['type'] === 'admin') {
                // 'admin' connecté : il peut choisir de créer un compte 'admin' ou 'user'
            ?>
                <div class="mb-3 mt-3">
                    <label class="form-label" for="type">Type :</label>
                    <select class="form-control" name="type">
                        <option value="user">user</option>
                        <option value="admin">admin</option>
                    </select>
                </div>
            <?php
            }
            ?>

            <!-- ZONE DE CONTROLE DU MDP -->
            <div class="w-100" id="menuCheck" style="display: none;">

                <!-- AFFICHAGE DU MDP -->
                <div class="form-check">
                    <input class="form-check-input" id="showPassword" type="checkbox">
                    <label class="form-check-label fs-6 text-muted" for="showPassword">Afficher le mot de passe</label>
                </div>

                <!-- BARRE DE PROGRESSION -->
                <div class="progress mx-3 my-3" style="height: 0.5em;">
                    <div id="progressBar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>

                <!-- LISTE DES CRITERES -->
                <ul class="list-group">
                    <li class="list-group-item border-0 py-0">
                        <i id="length" class="bi bi-x-circle-fill text-danger"></i>
                        <span class="text-muted">8 caractères minimum</span>
                    </li>
                    <li class="list-group-item border-0 py-0">
                        <i id="uppercase" class="bi bi-x-circle-fill text-danger"></i>
                        <span class="text-muted">Une majuscule</span>
                    </li>
                    <li class="list-group-item border-0 py-0">
                        <i id="lowercase" class="bi bi-x-circle-fill text-danger"></i>
                        <span class="text-muted">Une minuscule</span>
                    </li>
                    <li class="list-group-item border-0 py-0">
                        <i id="number" class="bi bi-x-circle-fill text-danger"></i>
                        <span class="text-muted">Un chiffre</span>
                    </li>
                    <li class="list-group-item border-0 py-0">
                        <i id="special" class="bi bi-x-circle-fill text-danger"></i>
                        <span class="text-muted">Un caractère spécial</span>
                    </li>
                </ul>
            </div>

            <!-- BOUTON D'ENVOI -->
            <div class="d-flex justify-content-center">
                <button class="btn btn-secondary" type="submit">Valider</button>
            </div>
        </form>
    </div>
</div>