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
<div class="card mx-auto my-3" style="width: 300px;">
    <div class="card-body lightForm formDarkMode">
        <form id="formSignup" method="post" action="index.php?controller=User&action=create" novalidate>

            <!-- TOKEN CSRF -->
            <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION["token"]["id"], ENT_QUOTES, "UTF-8"); ?>">

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
                <input id="password" class="form-control form-control-sm" type="text" name="password" autocomplete="new-password" placeholder="Entrez votre mot de passe">
                <!-- PASSWORD STRENGTH INDICATORS -->
                <div id="psw-strength" class="w-100 px-1 py-4" hidden>
                    <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 0" aria-valuenow="2"
                            aria-valuemin="0" aria-valuemax="5">
                        </div>
                    </div>
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
            <?php
            // vérifie qu'aucun utilisateur n'est connecté
            if (!isset($_SESSION["user"]["type"])) {
                // si aucun utilisateur connecté : on crée un utilisateur de type 'user' par défault
            ?>
                <input type="hidden" name="type" value="user">
            <?php
            } elseif ($_SESSION["user"]['type'] === 'admin') {
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
                <button class="btn darkBtn btnWithBorders" type="submit">Valider</button>
            </div>
        </form>
    </div>
</div>