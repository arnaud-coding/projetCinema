<!---------------------->
<!-- TITRE DE LA PAGE -->
<!---------------------->
<div class="d-flex align-items-center">

    <!-- TITRE -->
    <h1 class="flex-grow-1 text-center fs-3 fst-italic">Modifier un compte utilisateur</h1>

    <!-- BOUTON RETOUR -->
    <?php if (($_SESSION["user"]["statut"] ?? null) == "admin") : ?>
        <a class="btn btn-outline-secondary" href="index.php?controller=Utilisateur&action=listAdmin"
            title="Retour en arrière">
            <i class="bi bi-x-lg"></i>
        </a>
    <?php else : ?>
        <a class="btn btn-outline-secondary" href="index.php?controller=Film&action=home"
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
            <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION["token"]["id"], ENT_QUOTES, "UTF-8"); ?>">

            <!-- CHAMP ID UTILISATEUR -->
            <input type="hidden" name="id_utilisateur" value="<?php echo htmlspecialchars($user->id_user, ENT_QUOTES, "UTF-8"); ?>">

            <!-- CHAMP PSEUDO -->
            <div class="mb-3">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input id="pseudo" class="form-control form-control-sm" type="text" name="pseudo" value="<?php echo htmlspecialchars($user->pseudo, ENT_QUOTES, "UTF-8"); ?>">
            </div>

            <!-- CHAMP EMAIL -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" class="form-control form-control-sm" type="email" name="email" value="<?php echo htmlspecialchars($user->email, ENT_QUOTES, "UTF-8"); ?>">
            </div>

            <!-- CHAMP MDP -->
            <div class="mb-3">
                <label for="mdp" class="form-label">Mot de passe</label>
                <input id="mdp" class="form-control form-control-sm" type="password" name="mdp" placeholder="Entrer un nouveau mot de passe">
                <small class="form-text text-muted">Laissez vide si vous ne souhaitez pas modifier le mot de passe.</small>
            </div>

            <!-- CHAMP STATUT -->
            <?php if (($_SESSION["user"]["type"] ?? null) == "admin") : ?>
                <div class="mb-3">
                    <label for="statut" class="form-label">Statut</label>
                    <select id="statut" class="form-select form-select-sm" name="statut">
                        <?php
                        $options = ["admin", "user"];
                        foreach ($options as $option) :
                            $selected = ($user->type == $option) ? "selected" : "";
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