<!---------------------->
<!-- TITRE DE LA PAGE -->
<!---------------------->
<div class="d-flex flex-column align-items-center">
    <h1 class="flex-grow-1 text-center fs-3 fst-italic">Mot de passe oublié</h1>
    <p class="text-muted">Entrez votre adresse email pour recevoir un lien de réinitialisation.</p>
</div>

<!---------------->
<!-- FORMULAIRE -->
<!---------------->
<div class="card w-50 mx-auto my-3">
    <div class="card-body">
        <form method="post" action="index.php?controller=Utilisateur&action=forgetMdp">

            <!-- TOKEN CSRF -->
            <input type="hidden" name="token" value="<?php echo $_SESSION["token"]["id"]; ?>">
             
            <!-- CHAMP EMAIL -->
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="email" class="form-control" name="email" placeholder="Entrez votre email">
            </div>

            <!-- BOUTON D'ENVOI -->
            <div class="d-grid">
                <button class="btn btn-secondary" type="submit">Envoyer le lien</button>
            </div>
        </form>
        
        <!-- RETOUR EN ARRIERE -->
        <div class="text-center mt-3">
            <a class="text-decoration-none" href="index.php?controller=Utilisateur&action=formlogon">
                <i class="bi bi-arrow-left"></i>
                Retour à la connexion
            </a>
        </div>
    </div>
</div>