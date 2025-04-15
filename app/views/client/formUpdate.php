<!---------------------->
<!-- TITRE DE LA PAGE -->
<!---------------------->
<div class="d-flex align-items-center">

    <!-- TITRE -->
    <h1 class="flex-grow-1 text-center fs-3 fst-italic">Créer un compte utilisateur</h1>

    <!-- BOUTON RETOUR -->
    <?php if (($_SESSION["user"]["statut"] ?? null) == "admin") : ?>
        <a class="btn btn-outline-secondary" href="index.php?controller=Utilisateur&action=listAdmin"
            title="Retour en arrière">
            <i class="bi bi-x-lg"></i>
        </a>
    <?php else : ?>
        <a class="btn btn-outline-secondary" href="index.php?controller=Home&action=home"
            title="Retour en arrière">
            <i class="bi bi-x-lg"></i>
        </a>
    <?php endif; ?>
</div>

<!---------------->
<!-- FORMULAIRE -->
<!---------------->
<div class="card w-50 mx-auto my-3">
    <div class="card-body">
        <form method="post" action="index.php?controller=Utilisateur&action=update">

            <!-- TOKEN CSRF -->
            <input type="hidden" name="token" value="<?php echo $_SESSION["token"]["id"]; ?>">
             
            <!-- CHAMP ID UTILISATEUR -->
            <input type="hidden" name="id_utilisateur" value="<?php echo htmlspecialchars($utilisateur->id_utilisateur, ENT_QUOTES, "UTF-8"); ?>">

            <!-- CHAMP PRENOM -->
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input id="prenom" class="form-control form-control-sm" type="text" name="prenom" value="<?php echo htmlspecialchars($utilisateur->prenom, ENT_QUOTES, "UTF-8"); ?>">
            </div>

            <!-- CHAMP NOM -->
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input id="nom" class="form-control form-control-sm" type="text" name="nom" value="<?php echo htmlspecialchars($utilisateur->nom, ENT_QUOTES, "UTF-8"); ?>">
            </div>

            <!-- CHAMP EMAIL -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" class="form-control form-control-sm" type="email" name="email" value="<?php echo htmlspecialchars($utilisateur->email, ENT_QUOTES,"UTF-8"); ?>">
            </div>

            <!-- CHAMP MDP -->
            <div class="mb-3">
                <label for="mdp" class="form-label">Mot de passe</label>
                <input id="mdp" class="form-control form-control-sm" type="password" name="mdp" placeholder="Entrer un nouveau mot de passe">
                <small class="form-text text-muted">Laissez vide si vous ne souhaitez pas modifier le mot de passe.</small>
            </div>

            <!-- CHAMP STATUT -->
            <?php if (($_SESSION["user"]["statut"] ?? null) == "admin") : ?>
                <div class="mb-3">
                    <label for="statut" class="form-label">Statut</label>
                    <select id="statut" class="form-select form-select-sm" name="statut">
                        <?php
                        $options = ["admin", "user"];
                        foreach ($options as $option) :
                            $selected = ($utilisateur->statut == $option) ? "selected" : "";
                        ?>
                            <option value="<?php echo $option; ?>" <?php echo $selected; ?>><?php echo $option; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <!-- BOUTON D'ENVOI -->
            <div class="d-flex justify-content-center">
                <button class="btn btn-secondary" type="submit">Valider</button>
            </div>
        </form>
    </div>
</div>