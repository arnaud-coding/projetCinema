<!---------------------->
<!-- TITRE DE LA PAGE -->
<!---------------------->
<div class="d-flex flex-column align-items-center">
    <h1 class="flex-grow-1 text-center fs-3 fst-italic">Réinitialisation du mot de passe</h1>
    <p class="text-muted">Entrez votre nouveau mot de passe pour sécuriser votre compte.</p>
</div>

<!---------------->
<!-- FORMULAIRE -->
<!---------------->
<div class="card w-50 mx-auto my-3">
    <div class="card-body">
        <form method="post" action="index.php?controller=Utilisateur&action=updateMdp">

            <!-- CHAMP TOKEN -->
            <input type="hidden" name="token" value="<?php echo $_SESSION["token"]["id"];; ?>">  

            <!-- CHAMP MDP -->
            <div class="mb-3">
                <label for="mdp" class="form-label">Nouveau mot de passe</label>
                <input id="mdp" type="password" class="form-control" name="mdp" placeholder="Entrez un nouveau mot de passe">
                <small class="text-muted">Le mot de passe doit contenir au moins 8 caractères.</small>
            </div>

            <!-- BOUTON D'ENVOI -->
            <div class="d-grid">
                <button class="btn btn-secondary" type="submit">Réinitialiser le mot de passe</button>
            </div>
        </form>
    </div>
</div>