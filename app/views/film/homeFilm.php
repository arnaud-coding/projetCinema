<!--
$filmsByGenres :
Un tableau à 2 dimensions contenant :
             - dimension 1 : key = nom du genre ; value = tableau de films (cf dimension 2)
             - dimension 2 : key = index du tableau de cette dimension (pas utilisé) ; value = objet film
Exemple :
    D1['sci-fi']= D2[]                         (key= genre, value= D2[genre 0])
        D2[0]= film 0 du genre 0                    object film
        D2[1]= film 1 du genre 0                    object film
        D2[2]= film 2 du genre 0                    object film
        D2 [1]
    D1['action']= D2[]                         (key= index 1, value= D2[genre 1])
        D2[0]= film 0 du genre 1                    object film
        D2[0]= film 0 du genre 2                    object film

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

<?php $user = isset($_SESSION["user"]) ? $_SESSION["user"] : null ?>

<!-- AUCUN UTILISATEUR CONNECTE : Message d'incitation à créer un compte -->
<?php if (!$user) { ?>
    <div class="d-flex flex-column justify-content-center align-items-center">
        <p class="welcomeMsg text-info fst-italic mb-3">
            Rejoignez-nous en vous créant un compte,
            <br>ou connectez vous si vous avez déja un compte...
        </p>
    </div>
<?php
}  ?>

<!-- Conteneur principal de la page -->
<div class="container position-relative">
    <!-- Titre principal de la page -->
    <h2 class="text-center fw-bolder">Les films</h2>

    <?php
    // Parcours dimension 1 : les genres et leurs films
    foreach ($filmsByGenres as $genre => $films) { ?>

        <!-- Titre du "carroussel netflix" : nom du genre -->
        <h3 class="mb-0"><?= htmlspecialchars($genre, ENT_QUOTES, "UTF-8")  ?></h3>

        <!-- Carroussel container -->
        <div class="filmScroll d-flex overflow-auto py-3 px-2 gap-3">

            <!-- Flèche gauche (masquée sur petit écran) -->
            <button class="scrollLeft btn darkBtn btnWithBorders position-absolute start-0 translate-middle-y d-none d-md-block z-3"
                style="z-index: 1;  margin-top: 100px">
                <i class="bi bi-chevron-left"></i>
            </button>

            <?php
            // Parcours dimension 2 : les films du genre courant
            foreach ($films as $film) { ?>
                <a href="index.php?controller=Film&action=details&id_film=<?= htmlspecialchars($film->id_film, ENT_QUOTES, "UTF-8") ?>"
                    class="filmLink darkTypo" style="text-decoration: none;">
                    <div class="flex-shrink-0" style="width: 150px;">
                        <object data="img/img_films/<?= htmlspecialchars($film->picture, ENT_QUOTES, "UTF-8") ?>"
                            class="img-fluid rounded shadow-sm" alt="<?= htmlspecialchars($film->title, ENT_QUOTES, "UTF-8") ?>">
                            <img src="img/nopicture.jpg" class="img-fluid rounded shadow-sm mb-1" alt="no picture" style="width: 150px;">
                        </object>

                        <p class="text-center fw-bold mt-2 mb-0"><?= htmlspecialchars($film->title, ENT_QUOTES, "UTF-8") ?></p>
                        <?php if (isset($film->average_rating)) { ?>
                            <p class="text-center my-0">
                                <?= htmlspecialchars($film->average_rating, ENT_QUOTES, "UTF-8") ?>
                                <i class="bi bi-star-fill text-warning" style="font-size: small;"></i>
                            </p>
                        <?php
                        } ?>
                        <p class="text-center my-0"><?= htmlspecialchars($film->duration, ENT_QUOTES, "UTF-8") ?></p>
                    </div>
                </a>
            <?php
            } ?>

            <!-- Flèche droite (masquée sur petit écran) -->
            <button class="scrollRight btn darkBtn btnWithBorders position-absolute end-0 translate-middle-y d-none d-md-block z-3"
                style="z-index: 1; margin-top: 100px">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    <?php
    } ?>
</div>