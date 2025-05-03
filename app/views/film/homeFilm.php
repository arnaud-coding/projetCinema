<?php $message = isset($_GET["message"]) ? $_GET["message"] : "" ?>
<p><?php echo $message ?></p>
<!--
$filmsByGenres :
    Un tableau à 3 dimensions contenant :
        - dimension 1 : key = index du tableau de cette dimension (pas utilisé) ; value = tableau (cf dimension 2)
        - dimension 2 : key = nom du genre ; value = tableau (cf dimension 3)
        - dimension 3 : key = index du tableau de cette dimension (pas utilisé) ; value = objet film
Exemple :
    D1[0]= D2[]                         (key= index 0, value= D2[genre 0])
        D2['sci-fi'] = D3[]                 (key= genre, value= D3[genre 0])
            D3[0]= film 0 du genre 0            object film
            D3[1]= film 1 du genre 0            object film
            D3[2]= film 2 du genre 0            object film
        D2 [1]
    D1[1]= D2[]                         (key= index 1, value= D2[genre 1])
        D2['action'] = D3[]                 (key= genre, value= D3[genre 0])
            D3[0]= film 0 du genre 1            object film
            D3[0]= film 0 du genre 2            object film
-->

<!--
AFFICHER DES LISTES DE FILMS PAR GENRE :
    - POUR CHAQUE GENRE :
        - NOM DU GENRE
        - "CARROUSEL" DE FILMS, POUR CHAQUE FILM :
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
    <?php

    // Parcours dimension 1 : les genres et leurs films
    // ------------------------------------------------
    foreach ($filmsByGenres as $filmsByGenre) {

        // Parcours dimension 2 : un genre et ses films
        // ------------------------------------------------
        foreach ($filmsByGenre as $genre => $films) { ?>

            <!-- Titre du "carroussel netflix" -->
            <h3 class="mb-0"><?= $genre ?></h3>
            <?php

            // Parcours dimension 3 : les films du genre courant
            // ------------------------------------------------
            ?>
            <!-- Carroussel container -->
            <div id="filmScroll" class="d-flex overflow-auto py-3 px-2 gap-3">

                <!-- Flèche gauche (masquée sur petit écran) -->
                <button id="scrollLeft" class="btn btn-dark position-absolute top-50 start-0 translate-middle-y d-none d-md-block z-3" style="z-index: 1;">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <?php
                // Liste des films en scroll horizontal
                foreach ($films as $film) { ?>
                    <div class="flex-shrink-0" style="width: 150px;">
                        <object data="img/img_films/<?= $film->picture ?>" class="img-fluid rounded shadow-sm" alt="<?= $film->title; ?>">
                            <img src="img/nopicture.jpg" class="img-fluid rounded shadow-sm mb-1" alt="no picture" style="width: 150px;">
                        </object>

                        <p class="text-center fw-bold mt-2 mb-0"><?= $film->title ?></p>
                        <p class="text-center mt-0"><?= $film->duration ?></p>
                    </div>
                <?php
                }
                ?>

                <!-- Flèche droite (masquée sur petit écran) -->
                <button id="scrollRight" class="btn btn-dark position-absolute top-50 end-0 translate-middle-y d-none d-md-block z-3" style="z-index: 1;">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
    <?php

        }
    }
    die;
    ?>


</div>