<?php $message = isset($_GET["message"]) ? $_GET["message"] : "" ?>
<p><?php echo $message ?></p>
<?php
// var_dump($filmsByGenre)
?>

<!--
AFFICHER UNE LISTE DE FILMS
    - PAR GENRE
    - POUR CHAQUE FILM :
        - TITLE
        - PICTURE
        - ANNEE
        - DUREE
        - GENRES
        - REVIEW
            - RATING MEAN
-->

<div class="container mt-4 position-relative">
    <!-- Titre principal de la page -->
    <h2 class="d-flex justify-content-center">Les films</h2>

    <!-- Titre du "carroussel netflix" -->
    <h3 class="mb-0">Science-fiction</h3>
    <!-- Flèche gauche (masquée sur petit écran) -->
    <button id="scrollLeft" class="btn btn-dark position-absolute top-50 start-0 translate-middle-y d-none d-md-block z-3" style="z-index: 1;">
        <i class="bi bi-chevron-left"></i>
    </button>

    <!-- Liste des films en scroll horizontal -->
    <div id="filmScroll" class="d-flex overflow-auto py-3 px-2 gap-3">
        <?php foreach ($filmsByGenre as $film) { ?>
            <div class="flex-shrink-0" style="width: 150px;">
                <object data="img/img_films/<?= $film->picture ?>" type="image/png" class="img-fluid rounded shadow-sm" alt="<?= $film->title; ?>">
                    <img src="img/nopicture.jpg" style="width: 150px;">
                </object>

                <p class="text-center fw-bold mt-2 mb-0"><?= $film->title ?></p>
                <p class="text-center mt-0"><?= $film->duration ?></p>
            </div>
        <?php
        }; ?>
    </div>

    <!-- Flèche droite (masquée sur petit écran) -->
    <button id="scrollRight" class="btn btn-dark position-absolute top-50 end-0 translate-middle-y d-none d-md-block z-3" style="z-index: 1;">
        <i class="bi bi-chevron-right"></i>
    </button>
</div>