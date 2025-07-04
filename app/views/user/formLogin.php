<?php $message = isset($_GET["message"]) ? $_GET["message"] : "" ?>
<!---------------------->
<!-- TITRE DE LA PAGE -->
<!---------------------->
<div class="d-flex align-items-center">

    <!-- TITRE -->
    <h1 class="flex-grow-1 text-center fs-3 fst-italic">Se connecter à mon compte</h1>

    <!-- BOUTON RETOUR -->
    <a class="btn darkBtn btnWithBorders" href="index.php?controller=Film&action=home"
        title="Retour en arrière">
        <i class="bi bi-x-lg"></i>
    </a>
</div>

<!-- MESSAGE D'ERREUR -->
<p id="message-failure" class="text-center text-danger"></p>
<!-- MESSAGE DE SUCCES -->
<p id="message-success" class="text-center text-success"><?= $message ?></p>

<!---------------->
<!-- FORMULAIRE -->
<!---------------->
<div class="card mx-auto lightForm formDarkMode p-3 my-3" style="width: 300px;">
    <div class="card-body ">
        <form method="post" action="index.php?controller=User&action=login" novalidate>

            <!-- TOKEN CSRF -->
            <input type="hidden" name="token" value="<?= $token ?>">

            <!-- CHAMP EMAIL -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control" name="email" placeholder="Entrez votre email" value="bob@gmail.com">
            </div>

            <!-- CHAMP MDP -->
            <div class="mb-1">
                <label for="password" class="form-label">Mot de passe</label>
                <input id="password" class="form-control" type="password" name="password" placeholder="Entrez votre mot de passe" value="superBob=0!">
            </div>

            <!-- LIEN VERS MDP OUBLIE -->
            <div class="mb-3 text-end">
                <a class="text-decoration-none" href="index.php?controller=User&action=formForgetMdp">Mot de passe oublié ?</a>
            </div>

            <!-- BOUTON D'ENVOI -->
            <div class="d-grid">
                <button class="btn lightBtn btnWithBorders" type="submit">Valider</button>
            </div>
        </form>

        <!-- LIEN VERS LA CREATION DE COMPTE -->
        <div class="text-center mt-4">
            <p class="fw-bold">Vous n'avez pas enore de compte ?</p>
            <a class="btn darkBtn btnWithBorders" href="index.php?controller=User&action=formSignup">Créer un compte</a>
        </div>
    </div>
</div>