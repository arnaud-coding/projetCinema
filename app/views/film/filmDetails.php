<?php
if (!$film) { ?>
    <p class="d-flex justify-content-center">Le film n'existe pas.</p>
<?php
} else {
    // FILM EXISTANT : AFFICHAGE DÉTAILS FILM
?>
    <div class="container mt-4">
        <!-- TITRE PRINCIPAL = TITRE DU FILM -->
        <h2 class="d-flex justify-content-center fw-bolder"><?= htmlspecialchars($film["details"]->title, ENT_QUOTES, "UTF-8") ?></h2>

        <!-- MENU DES DÉTAILS DU FILM -->
        <nav>
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
            <!-- <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <div class="d-flex">
                    <div id="filmPicture">
                        <img src="" alt="">
                    </div>
                    <div></div>

                </div>
            </div> -->

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


        <h5 d-flex justify-content-center>Synopsis :</h5>
        <p><?= htmlspecialchars($film["details"]->synopsis, ENT_QUOTES, "UTF-8") ?></p>

    </div>
<?php
    var_dump($film);
} ?>