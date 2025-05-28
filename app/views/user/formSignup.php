<!---------------------->
<!-- TITRE DE LA PAGE -->
<!---------------------->
<div class="d-flex align-items-center">

    <!-- TITRE -->
    <h1 class="flex-grow-1 text-center fs-3 fst-italic">Inscription</h1>

    <!-- BOUTON RETOUR -->
    <a class="btn darkBtn btnWithBorders" href="index.php?controller=User&action=formLogin"
        title="Retour en arrière">
        <i class="bi bi-x-lg"></i>
    </a>
</div>

<!-- MESSAGE D'ERREUR -->
<p id="message-failure" class="text-center text-danger"></p>
<!-- MESSAGE DE SUCCES -->
<p id="message-success" class="text-center text-success"></p>

<!---------------->
<!-- FORMULAIRE -->
<!---------------->
<div class="mx-auto lightForm formDarkMode p-3 my-3" style="width: 300px;">
    <form id="formSignUp" method="post" action="index.php?controller=User&action=signUp" novalidate>

        <!-- TOKEN CSRF -->
        <input type="hidden" name="token" value="<?= $token ?>">

        <!-- CHAMP EMAIL -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control form-control-sm" type="email" name="email" autocomplete="username" placeholder="Entrez votre email">
            <span id="emailError" class="text-danger" hidden></span>
        </div>

        <!-- CHAMP PSEUDO -->
        <div class="mb-3">
            <label for="pseudo" class="form-label">Pseudo</label>
            <input id="pseudo" class="form-control form-control-sm" type="text" name="pseudo" placeholder="Entrez votre pseudo">
            <span id="pseudoError" class="text-danger" hidden></span>
        </div>

        <!-- CHAMP MDP -->
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" class="form-control form-control-sm" type="password" name="password" autocomplete="new-password" placeholder="Entrez votre mot de passe">

            <!-- ZONE DE CONTROLE DU MDP -->
            <div id="psw-strength" class="w-100 px-1 py-4" hidden>
                <!-- BARRE DE PROGRESSION -->
                <div class="progress mb-3" style="height: 5px">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 0" aria-valuenow="2"
                        aria-valuemin="0" aria-valuemax="5">
                    </div>
                </div>
                <!-- PASSWORD STRENGTH INDICATORS -->
                <div>
                    <i id="xmarkLength" class="fa-solid fa-xmark text-danger"></i>
                    <i id="checkLength" class="fa-solid fa-check text-success"></i>
                    <label class="ms-2">8 caractères minimum</label>
                </div>
                <div>
                    <i id="xmarkMaj" class="fa-solid fa-xmark text-danger"></i>
                    <i id="checkMaj" class="fa-solid fa-check text-success"></i>
                    <label class="ms-2">Une majuscule</label>
                </div>
                <div>
                    <i id="xmarkMin" class="fa-solid fa-xmark text-danger"></i>
                    <i id="checkMin" class="fa-solid fa-check text-success"></i>
                    <label class="ms-2">Une minuscule</label>
                </div>
                <div>
                    <i id="xmarkNumber" class=" fa-solid fa-xmark text-danger"></i>
                    <i id="checkNumber" class=" fa-solid fa-check text-success"></i>
                    <label class="ms-2">Un chiffre</label>
                </div>
                <div>
                    <i id="xmarkSpecialChar" class="fa-solid fa-xmark text-danger"></i>
                    <i id="checkSpecialChar" class="fa-solid fa-check text-success"></i>
                    <label class="ms-2">Un caractère spécial</label>
                </div>
            </div>
        </div>

        <!-- CHAMP TYPE D'UTILISATEUR -->
        <?php if (!isset($_SESSION["user"]["type"])) { ?>
            <!-- si aucun utilisateur connecté : on crée un utilisateur de type 'user' par défault -->
            <input type="hidden" name="type" value="user">
        <?php
        } elseif ($_SESSION["user"]['type'] === 'admin') { ?>
            <!-- 'admin' connecté : il peut choisir de créer un compte 'admin' ou 'user' -->
            <div class="mb-3 mt-3">
                <label class="form-label" for="type">Type :</label>
                <select class="form-control" name="type">
                    <option value="user">user</option>
                    <option value="admin">admin</option>
                </select>
            </div>
        <?php
        } ?>

        <!-- BOUTON D'ENVOI -->
        <div class="d-flex justify-content-center">
            <button class="btn darkBtn btnWithBorders" type="submit">Valider</button>
        </div>
    </form>
</div>