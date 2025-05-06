<?php
if (!$film) { ?>
    <p class="d-flex justify-content-center">Le film n'existe pas.</p>
<?php
} else { ?>

    <div class="container mt-4">
        <!-- TITRE PRINCIPAL = TITRE DU FILM -->
        <h2 class="d-flex justify-content-center fw-bolder"><?= htmlspecialchars($film["details"]->title, ENT_QUOTES, "UTF-8") ?></h2>

        <!-- MENU DES DÉTAILS DU FILM -->
        <nav class="d-flex justify-content-center mt-4 mb-4">
            <div class="nav nav-pills" id="pills-tab" role="tablist">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Accueil</button>
                <button class="nav-link" id="pills-casting-tab" data-bs-toggle="pill" data-bs-target="#pills-casting" type="button" role="tab" aria-controls="pill-casting" aria-selected="false">Casting</button>
                <button class="nav-link" id="pills-reviews-tab" data-bs-toggle="pill" data-bs-target="#pills-reviews" type="button" role="tab" aria-controls="pill-reviews" aria-selected="false">Critiques</button>
                <button class="nav-link" id="pills-similar-tab" data-bs-toggle="pill" data-bs-target="#pills-similar" type="button" role="tab" aria-controls="pill-similar" aria-selected="false">Films similaires</button>
            </div>
        </nav>

        <!-- CONTENU PRINCIPAL DE LA PAGE -->
        <div class="tab-content" id="pills-tabContent">

            <!-- ACCEUIL DETAILS -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <div class="d-flex mb-3">
                    <!-- AFFICHE FILM -->
                    <div id="filmPicture" style="width: 200px;">
                        <object data="img/img_films/<?= htmlspecialchars($film["details"]->picture, ENT_QUOTES, "UTF-8") ?>" class="img-fluid rounded shadow-sm">
                            <img src="img/nopicture.jpg" class="img-fluid rounded shadow-sm mb-1" alt="no picture" style="width: 200px;">
                        </object>
                    </div>
                    <!-- INFOS SUR LE FILM -->
                    <div class="ms-3">
                        <!-- ANNEE DE SORTIE | DUREE | GENRES -->
                        <p>
                            Sorti en <?= "<b>" . htmlspecialchars($film["details"]->release_year, ENT_QUOTES, "UTF-8") . "</b> | "
                                            . htmlspecialchars($film["details"]->duration, ENT_QUOTES, "UTF-8") . " | " ?>
                            <a href="" class="darkTypo menuLinks">
                                <b><?= htmlspecialchars($film["genres"][0]->name, ENT_QUOTES, "UTF-8") . ", " ?></b>
                            </a>
                            <a href="" class="darkTypo menuLinks">
                                <b><?= htmlspecialchars($film["genres"][1]->name, ENT_QUOTES, "UTF-8")  ?></b>
                            </a>
                        </p>
                        <!-- REALISATEURS(S) -->
                        <p>
                            Réalisé par
                            <?php
                            if (count($film["directors"]) === 1) { ?>
                                <a href="" class="darkTypo menuLinks">
                                    <b><?= htmlspecialchars($film["directors"][0]->name, ENT_QUOTES, "UTF-8") ?></b>
                                </a>
                            <?php
                            } else { ?>
                                <a href="" class="darkTypo menuLinks">
                                    <b><?= htmlspecialchars($film["directors"][0]->name, ENT_QUOTES, "UTF-8") . ", " ?></b>
                                </a>
                                <a href="" class="darkTypo menuLinks">
                                    <b><?= htmlspecialchars($film["directors"][1]->name, ENT_QUOTES, "UTF-8") ?></b>
                                </a>
                            <?php
                            } ?>

                        </p>
                        <!-- LES 3 ACTEURS PRINCIPAUX -->
                        <p>
                            Avec
                            <a href="" class="darkTypo menuLinks">
                                <b><?= htmlspecialchars($film["actors"][0]->name, ENT_QUOTES, "UTF-8") . ", " ?></b>
                            </a>
                            <a href="" class="darkTypo menuLinks">
                                <b><?= htmlspecialchars($film["actors"][1]->name, ENT_QUOTES, "UTF-8") . ", " ?></b>
                            </a>
                            <a href="" class="darkTypo menuLinks">
                                <b><?= htmlspecialchars($film["actors"][2]->name, ENT_QUOTES, "UTF-8") ?></b>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- SYNOPSIS -->
                <h5>Synopsis :</h5>
                <p><?= htmlspecialchars($film["details"]->synopsis, ENT_QUOTES, "UTF-8") ?></p>
            </div>

            <!-- CASTING -->
            <div class="tab-pane fade" id="pills-casting" role="tabpanel" aria-labelledby="pills-casting-tab" tabindex="0">
                VADOR : JE SUIS ...
            </div>

            <!-- CRITIQUES -->
            <div class="tab-pane fade" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab" tabindex="0">
                VADOR : TON PERE.
            </div>

            <!-- FILMS SIMILAIRES -->
            <div class="tab-pane fade" id="pills-similar" role="tabpanel" aria-labelledby="pills-reviews-tab" tabindex="0">
                LUKE : NOOOON !!!
            </div>
        </div>
    </div>
<?php
    var_dump($film);
} ?>