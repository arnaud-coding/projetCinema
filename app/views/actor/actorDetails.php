<?php if (!$actor) { ?>
    <p class="text-center">Aucune donnée trouvée pour cet acteur</p>
<?php
} else {

    // FORMATAGE DATE ET CALCUL AGE
    $birthDate = new DateTime(htmlspecialchars($actor["details"]->birth_date, ENT_QUOTES, "UTF-8"));
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
    if ($actor["details"]->death_date !== null) {
        $deathDate = new DateTime(htmlspecialchars($actor["details"]->death_date, ENT_QUOTES, "UTF-8"));
        $age = $deathDate->diff($birthDate)->y;
    }
    $formatter = new IntlDateFormatter(
        'fr_FR',               // Langue : français
        IntlDateFormatter::LONG,
        IntlDateFormatter::NONE,
        'Europe/Paris',        // Fuseau horaire
        IntlDateFormatter::GREGORIAN,
        'd MMMM yyyy'          // Format : "4 novembre 1969"
    ) ?>

    <div class="container mt-4">
        <!-- TITRE PRINCIPAL = TITRE DU FILM -->
        <h2 class="text-center fw-bolder"><?= htmlspecialchars($actor["details"]->name, ENT_QUOTES, "UTF-8") ?></h2>

        <!-- MENU DES DÉTAILS DU FILM -->
        <nav class="d-flex justify-content-center mt-4 mb-4">
            <div class="nav nav-pills d-flex flex-nowrap" id="pills-tab" role="tablist">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Accueil</button>
                <button class="nav-link" id="pills-biography-tab" data-bs-toggle="pill" data-bs-target="#pills-biography" type="button" role="tab" aria-controls="pill-biography" aria-selected="false">Biographie</button>
                <button class="nav-link" id="pills-filmography-tab" data-bs-toggle="pill" data-bs-target="#pills-filmography" type="button" role="tab" aria-controls="pill-filmography" aria-selected="false">Filmographie</button>
            </div>
        </nav>

        <!-- CONTENU PRINCIPAL DE LA PAGE -->
        <div class="tab-content" id="pills-tabContent">

            <!-- ACCUEIL DETAILS -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <div class="d-flex mb-3">
                    <!-- PHOTO ACTEUR -->
                    <div id="actorPicture" style="width: 200px;">
                        <object data="img/img_actors/<?= htmlspecialchars($actor["details"]->picture, ENT_QUOTES, "UTF-8") ?>" class="img-fluid rounded shadow-sm">
                            <img src="img/nopicture.jpg" class="img-fluid rounded shadow-sm mb-1" alt="no picture" style="width: 200px;">
                        </object>
                    </div>
                    <!-- INFOS SUR L'ACTEUR -->
                    <div class="ms-3">
                        <!-- NATIONALITE -->
                        <p>Nationalité <b><?= htmlspecialchars(ucfirst($actor["details"]->nationality), ENT_QUOTES, "UTF-8") ?></b></p>
                        <!-- NAISSANCE -->
                        <p>Naissance <b><?= $formatter->format($birthDate) ?></b></p>
                        <!-- DECES -->
                        <?php if ($actor["details"]->death_date !== null) { ?>
                            <p>
                                Décès <b><?= $formatter->format($birthDate) ?></b> à l'âge de <?= $age ?> ans
                            </p>
                        <?php
                        } else { ?>
                            <!-- AGE -->
                            <p>Age <b><?= $age ?> ans</b></p>
                        <?php
                        } ?>
                    </div>
                </div>
            </div>

            <!-- BIOGRAPHIE -->
            <div class="tab-pane fade w-50" id="pills-biography" role="tabpanel" aria-labelledby="pills-biography-tab" tabindex="0">
                <h3 class="mb-4">Biographie</h3>
                <p><?= htmlspecialchars($actor["details"]->biography, ENT_QUOTES, "UTF-8") ?></p>
            </div>

            <!-- FILMOGRAPHIE -->
            <div class="tab-pane fade" id="pills-filmography" role="tabpanel" aria-labelledby="pills-filmography-tab" tabindex="0">
                <div class="container-fluid mt-5">
                    <h3 class="mb-4">Filmographie</h3>
                    <div class="row">
                        <?php foreach ($actor["films"] as $film) { ?>
                            <a href="index.php?controller=Film&action=details&id_film=<?= htmlspecialchars($film->id_film, ENT_QUOTES, "UTF-8") ?>" class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 darkTypo menuLinks" style="text-decoration: none;">
                                <div style="width: 150px;">
                                    <object data="img/img_films/<?= htmlspecialchars($film->picture, ENT_QUOTES, "UTF-8") ?>" class="img-fluid rounded shadow-sm" alt="<?= htmlspecialchars($film->title, ENT_QUOTES, "UTF-8") ?>">
                                        <img src="img/nopicture.jpg" class="img-fluid rounded shadow-sm mb-1" alt="no picture" style="width: 150px;">
                                    </object>
                                    <p class="text-center fw-bold mt-1 mb-0"><?= htmlspecialchars($film->title, ENT_QUOTES, "UTF-8") ?></p>
                                </div>
                            </a>
                        <?php
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} ?>