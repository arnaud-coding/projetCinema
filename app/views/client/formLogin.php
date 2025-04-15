<!---------------------->
<!-- TITRE DE LA PAGE -->
<!---------------------->
<div class="d-flex align-items-center">

    <!-- TITRE -->
    <h1 class="flex-grow-1 text-center fs-3 fst-italic">Se connecter à mon compte</h1>

    <!-- BOUTON RETOUR -->
    <a class="btn btn-outline-secondary" href="index.php?controller=Home&action=home"
        title="Retour en arrière">
        <i class="bi bi-x-lg"></i>
    </a>
</div>

<!---------------->
<!-- FORMULAIRE -->
<!---------------->
<div class="card w-50 mx-auto my-3">
    <div class="card-body">
        <form method="post" action="index.php?controller=Client&action=login">

            <!-- TOKEN CSRF -->
            <input type="hidden" name="token" value="<?php echo $_SESSION["token"]["id"]; ?>">

            <!-- CHAMP EMAIL -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control" name="email" placeholder="Entrez votre email">
            </div>

            <!-- CHAMP MDP -->
            <div class="mb-1">
                <label for="mdp" class="form-label">Mot de passe</label>
                <input id="mdp" class="form-control" type="password" name="mdp" placeholder="Entrez votre mot de passe">
            </div>

            <!-- LIEN VERS MDP OUBLIE -->
            <div class="mb-3 text-end">
                <a class="text-decoration-none" href="index.php?controller=Client&action=formForgetMdp">Mot de passe oublié ?</a>
            </div>

            <!-- BOUTON D'ENVOI -->
            <div class="d-grid">
                <button class="btn btn-secondary" type="submit">Valider</button>
            </div>
        </form>

        <!-- LIEN VERS LA CREATION DE COMPTE -->
        <div class="text-center mt-4">
            <p class="fw-bold">Vous n'avez pas de compte ?</p>
            <a class="btn btn-outline-secondary" href="index.php?controller=Client&action=formCreate">Créer un compte</a>
        </div>
    </div>
</div>