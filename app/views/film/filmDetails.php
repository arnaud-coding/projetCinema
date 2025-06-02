<?php

use App\Core\CSRFTokenManager as CSRFTokenManager;

function displayNames($items, $max = null, $controller = null)
{
    $count = count($items);
    $max = $max == null ? $count : $max;

    for ($i = 0; $i < $count; $i++) {
        if ($controller === "Genre") {
            $key = "id_genre";
            $id = $items[$i]->id_genre;
        } elseif ($controller === "Actor") {
            $key = "id_actor";
            $id = $items[$i]->id_actor;
        } elseif ($controller === "Director") {
            $key = "id_director";
            $id = $items[$i]->id_director;
        }

        if ($i === $max - 1) {
            // affichage du dernier élément
            $name = $items[$i]->name; ?>
            <a href="index.php?controller=<?= $controller ?>&action=details&<?= $key ?>=<?= htmlspecialchars($id, ENT_QUOTES, "UTF-8") ?>"
                class="darkTypo menuLinks linksOnHover">
                <b><?= htmlspecialchars($name, ENT_QUOTES, "UTF-8") ?></b>
            </a>
        <?php
            break;
        } else {
            // affichage du 1er à l'avant dernier élément
            $name = $items[$i]->name . ", "; ?>
            <a href="index.php?controller=<?= $controller ?>&action=details&<?= $key ?>=<?= htmlspecialchars($id, ENT_QUOTES, "UTF-8") ?>"
                class="darkTypo menuLinks linksOnHover">
                <b><?= htmlspecialchars($name, ENT_QUOTES, "UTF-8") ?></b>
            </a>
    <?php
        }
    }
}

if (!$film) { ?>
    <p class="text-center">Aucune donnée trouvée pour ce film</p>
<?php
} else { ?>

    <!-- TITRE DU FILM -->
    <h2 class="text-center fw-bolder"><?= htmlspecialchars($film["details"]->title, ENT_QUOTES, "UTF-8") ?></h2>

    <!-- MENU DES DÉTAILS DU FILM -->
    <nav class="d-flex justify-content-center mt-4 mb-4">
        <div class="nav nav-pills d-flex flex-nowrap overflow-auto pb-3" id="pills-tab" role="tablist">
            <button class="nav-link active menuLinks darkTypo" id="pills-home-tab" data-bs-toggle="pill"
                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Accueil</button>
            <button class="nav-link menuLinks darkTypo" id="pills-casting-tab" data-bs-toggle="pill"
                data-bs-target="#pills-casting" type="button" role="tab" aria-controls="pill-casting" aria-selected="false">Casting</button>
            <button class="nav-link menuLinks darkTypo" id="pills-reviews-tab" data-bs-toggle="pill"
                data-bs-target="#pills-reviews" type="button" role="tab" aria-controls="pill-reviews" aria-selected="false">Critiques</button>
            <!-- BOUTON MODIFIER ET BOUTON SUPPRIMER -->
            <?php if (isset($_SESSION["user"]) && $_SESSION["user"]["type"] === "admin") { ?>
                <a class="ms-2 p-2 darkBtn btnWithBorders"
                    href="index.php?controller=Film&action=updateForm&id_film=<?= htmlspecialchars($film["details"]->id_film, ENT_QUOTES, "UTF-8") ?>">Modifier
                </a>
                <a class="deleteLink btn btn-danger" href="#" data-entity="Film" data-item="ce film"
                    id="deleteFilm-<?= htmlspecialchars($film["details"]->id_film, ENT_QUOTES, "UTF-8") ?>">Supprimer
                </a>
            <?php
            } ?>
        </div>
    </nav>

    <!-- CONTENU PRINCIPAL DE LA PAGE -->
    <div class="tab-content" id="pills-tabContent">

        <!-- ACCUEIL DETAILS -->
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
            <div class="d-flex mb-3">
                <!-- AFFICHE FILM -->
                <div id="filmPicture" style="width: 200px;">
                    <object data="img/img_films/<?= htmlspecialchars($film["details"]->picture, ENT_QUOTES, "UTF-8") ?>" class="img_fluid rounded shadow-sm">
                        <img src="img/nopicture.jpg" class="img-fluid rounded shadow-sm mb-1" alt="no picture" style="width: 200px;">
                    </object>
                </div>
                <!-- INFOS SUR LE FILM -->
                <div class="ms-3">
                    <!-- ANNEE DE SORTIE | DUREE | GENRES -->
                    <p>
                        Sorti en <?= "<b>" . htmlspecialchars($film["details"]->release_year, ENT_QUOTES, "UTF-8") . "</b> | "
                                        . htmlspecialchars($film["details"]->duration, ENT_QUOTES, "UTF-8") . " | " ?>
                        <?php
                        displayNames($film["genres"], null, "Genre");
                        ?>
                    </p>
                    <!-- REALISATEURS(S) -->
                    <p>
                        Réalisé par <?php displayNames($film["directors"], null, "Director") ?>
                    </p>
                    <!-- LES 3 ACTEURS PRINCIPAUX -->
                    <p>
                        Avec <?php displayNames($film["actors"], 3, "Actor") ?>
                    </p>
                    <?php if (isset($film["average_rating"])) { ?>
                        <!-- NOTE TELESPECTATEURS -->
                        <div class="card text-center p-1" style="width: 115px;">
                            <p class="card-title my-0 fs-6 fw-bold">Spectateurs</p>
                            <p class="fs-4 mb-0 fw-bolder">
                                <?= htmlspecialchars($film["average_rating"], ENT_QUOTES, "UTF-8") ?>
                                <i class="bi bi-star-fill text-warning"></i>
                            </p>
                            <p class="card-text my-0 py-0" style="font-size:x-small;"><small><?= count($film["reviews"]) . " critiques" ?></small></p>
                        </div>
                    <?php
                    } ?>
                </div>
            </div>
            <!-- SYNOPSIS -->
            <h4>Synopsis :</h4>
            <p><?= htmlspecialchars($film["details"]->synopsis, ENT_QUOTES, "UTF-8") ?></p>
        </div>

        <!-- CASTING -->
        <div class="tab-pane fade" id="pills-casting" role="tabpanel" aria-labelledby="pills-casting-tab" tabindex="0">
            <p hidden id="film-<?= htmlspecialchars($film["details"]->id_film, ENT_QUOTES, "UTF-8") ?>"></p>

            <!-- REALISATEURS -->
            <div>
                <div class="d-inline-flex align-items-center mb-4">
                    <h3 class="mb-0">Réalisateur(s)</h3>
                    <!-- ADMIN CONNECTE : Button modal addToFilm -->
                    <?php if (isset($_SESSION["user"]) && $_SESSION["user"]["type"] === "admin") { ?>
                        <a href="#" id="addDirector" class="fs-6 ms-3 p-2 addToFilmOpenModal darkBtn btnWithBorders">Ajouter réalisateur</a>
                    <?php
                    } ?>
                </div>

                <div id="DirectorList" class="d-flex">
                    <?php if ($film["directors"] === []) { ?>
                        <p>Aucun réalisateur associé à ce film pour l'instant</p>
                        <?php
                    } else {
                        foreach ($film["directors"] as $director) : ?>
                            <!-- LISTE DES REALISATEURS DU FILM -->
                            <div id="director-<?= htmlspecialchars($director->id_director, ENT_QUOTES, "UTF-8") ?>"
                                class="mb-4 mx-4">
                                <a href="index.php?controller=Director&action=details&id_director=<?= htmlspecialchars($director->id_director, ENT_QUOTES, "UTF-8") ?>"
                                    class="darkTypo menuLinks">
                                    <div class="me-5" style="width: 155px">
                                        <object data="img/img_directors/<?= htmlspecialchars($director->picture, ENT_QUOTES, "UTF-8") ?>"
                                            class="img-fluid rounded shadow-sm" alt="<?= htmlspecialchars($director->name, ENT_QUOTES, "UTF-8") ?>"
                                            style="width: 155px">
                                            <img src="img/nopicture.jpg" class="img-fluid rounded shadow-sm mb-1" alt="no picture" style="width: 155px">
                                        </object>
                                        <p class="text-center fw-bold mt-1 mb-0"><?= htmlspecialchars($director->name, ENT_QUOTES, "UTF-8") ?></p>
                                    </div>
                                </a>
                                <?php if (isset($_SESSION["user"]) && $_SESSION["user"]["type"] === "admin") { ?>
                                    <!-- ADMIN CONNECTE : Bouton retirer réalisateur du film -->
                                    <a id="removeDirector-<?= htmlspecialchars($director->id_director, ENT_QUOTES, "UTF-8") ?>"
                                        href="#" class="text-center btnRemoveFromFilm btn btn-danger mt-2" style="width: 155px">
                                        Retirer du film
                                    </a>
                                <?php
                                } ?>
                            </div>
                    <?php endforeach;
                    } ?>
                </div>
            </div>

            <!-- ACTEURS -->
            <div class="container-fluid mt-5">
                <div class="d-inline-flex align-items-center mb-4">
                    <h3 class="mb-0">Acteurs</h3>
                    <!-- ADMIN CONNECTE : Button trigger modal addToFilm -->
                    <?php if (isset($_SESSION["user"]) && $_SESSION["user"]["type"] === "admin") { ?>
                        <a href="#" id="addActor" class="fs-6 ms-3 p-2 addToFilmOpenModal darkBtn btnWithBorders">Ajouter acteur</a>
                    <?php
                    } ?>
                </div>

                <div id="ActorList" class="row g-3 px-3">
                    <?php if ($film["actors"] === []) { ?>
                        <p>Aucun acteur associé à ce film pour l'instant</p>
                        <?php
                    } else {
                        foreach ($film["actors"] as $actor) : ?>
                            <!-- Liste des acteurs associés au film -->
                            <div id="actor-<?= htmlspecialchars($actor->id_actor, ENT_QUOTES, "UTF-8") ?>"
                                class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-4 d-flex justify-content-center">
                                <div style="width: 155px;">
                                    <!-- Carte acteur : lien vers détails acteur au clic -->
                                    <a href="index.php?controller=Actor&action=details&id_actor=<?= htmlspecialchars($actor->id_actor, ENT_QUOTES, "UTF-8") ?>"
                                        class="darkTypo menuLinks">
                                        <div style="width: 155px">
                                            <object data="img/img_actors/<?= htmlspecialchars($actor->picture, ENT_QUOTES, "UTF-8") ?>"
                                                class="img-fluid rounded shadow-sm" alt="<?= htmlspecialchars($actor->name, ENT_QUOTES, "UTF-8") ?>"
                                                style="width: 155px">
                                                <img src="img/nopicture.jpg" class="img-fluid rounded shadow-sm mb-1" alt="no picture" style="width: 155px">
                                            </object>
                                            <p class="text-center fw-bold mt-1 mb-0"><?= htmlspecialchars($actor->name, ENT_QUOTES, "UTF-8") ?><i></i></p>
                                        </div>
                                    </a>
                                    <?php if (isset($_SESSION["user"]) && $_SESSION["user"]["type"] === "admin") { ?>
                                        <!-- ADMIN CONNECTE : Bouton retirer acteur du film -->
                                        <a id="removeActor-<?= htmlspecialchars($actor->id_actor, ENT_QUOTES, "UTF-8") ?>"
                                            href="#" class="text-center btnRemoveFromFilm btn btn-danger mt-2" style="width: 155px">
                                            Retirer du film
                                        </a>
                                    <?php
                                    } ?>
                                </div>
                            </div>
                    <?php endforeach;
                    } ?>
                </div>
            </div>

            <!-- Modal addToFilm -->
            <div id="myModal" class="modal">
                <div class="modal-content lightForm formDarkMode">
                    <div hidden id="filmID<?= htmlspecialchars($film["details"]->id_film, ENT_QUOTES, "UTF-8") ?>"></div>
                    <div class="d-flex justify-content-center">
                        <h2 id="modalTitle" class="text-center pb-0"></h2>
                        <a href="#" class="close-btn darkBtn btnWithBorders px-2" title="Retour en arrière"><i class="bi bi-x-lg"></i></a>
                    </div>
                    <p id="resultMsg"></p>
                    <div class="d-flex mt-3">
                        <input type="text" id="modalSearch" class="form-control">
                    </div>
                    <div id="searchResults"></div>
                </div>
            </div>
        </div>

        <!-- CRITIQUES -->
        <div class=" tab-pane fade" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab" tabindex="0">
            <h3 class="text-center mt-5 mb-4">Critiques téléspectateurs</h3>
            <?php if (!$film["reviews"]) { ?>
                <p class="card-text text-center m-3">
                    Aucune critique pour l'instant,<br>Soyez le premier à donner votre avis sur ce film !
                </p>
                <?php
            } else {
                // PARCOURS LES CRITIQUES PUBLIÉES SUR LE FILM
                foreach ($film["reviews"] as $review) {

                    // CONVERTIT DATE
                    $date = new DateTime(htmlspecialchars($review->publication_date, ENT_QUOTES, "UTF-8"));
                    $formatter = new IntlDateFormatter(
                        'fr_FR',               // Langue : français
                        IntlDateFormatter::LONG,
                        IntlDateFormatter::NONE,
                        'Europe/Paris',        // Fuseau horaire
                        IntlDateFormatter::GREGORIAN,
                        'd MMMM yyyy'          // Format : "4 novembre 1969"
                    ) ?>

                    <div id="review-<?= htmlspecialchars($review->id_review, ENT_QUOTES, "UTF-8") ?>"
                        class="d-flex justify-content-between align-items-center lightForm formDarkMode m-3 p-3">
                        <div>
                            <p>
                                <i><b><?= htmlspecialchars($review->pseudo, ENT_QUOTES, "UTF-8") ?></b></i>, le <?= $formatter->format($date) ?>
                            </p>
                            <p>
                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                    <i class="bi bi-star-fill publishedReview <?= $i <= htmlspecialchars($review->rating, ENT_QUOTES, "UTF-8") ? 'active' : '' ?>" data-value="<?= $i ?>"></i>
                                <?php
                                } ?>
                            </p>
                            <p><?= htmlspecialchars($review->content, ENT_QUOTES, "UTF-8") ?></p>
                        </div>
                        <?php if (isset($_SESSION["user"]) && $_SESSION["user"]["type"] === "admin") { ?>
                            <!-- BOUTON ADMIN : SUPPRESSION CRITIQUE -->
                            <a href="#" id="deleteReview-<?= htmlspecialchars($review->id_review, ENT_QUOTES, "UTF-8") ?>"
                                data-entity="Review" data-item="cette critique" class="deleteLink btn btn-danger ms-5">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        <?php
                        } ?>
                    </div>
            <?php
                }
            } ?>

            <!-- FORMULAIRE : PUBLIER UNE CRITIQUE -->
            <div class="card m-3 lightForm formDarkMode">
                <b><label class="form-label fst-italic ms-4 mt-3" for="commentaire">Donnez votre avis !</label></b>
                <!-- Sélection de la note sous forme d'étoiles -->
                <div id="star-rating" class="ms-4">
                    <i class="bi bi-star-fill star" data-value="1"></i>
                    <i class="bi bi-star-fill star" data-value="2"></i>
                    <i class="bi bi-star-fill star" data-value="3"></i>
                    <i class="bi bi-star-fill star" data-value="4"></i>
                    <i class="bi bi-star-fill star" data-value="5"></i>
                </div>
                <p id="ratingValue" class="mt-2 ms-4" style="display: none;"><b>Note : </b>0/5</p>

                <!-- Formulaire -->
                <form action="index.php?controller=Review&action=add" method="post">
                    <!-- Token CSRF -->
                    <input type="hidden" name="token" value="<?php echo CSRFTokenManager::generateCSRFToken() ?>">
                    <!-- Note -->
                    <input type="hidden" name="rating" id="rating">
                    <!-- ID film -->
                    <input type="hidden" name="id_film" value="<?= htmlspecialchars($film["details"]->id_film, ENT_QUOTES, "UTF-8") ?>">
                    <!-- Texte critique -->
                    <div class="m-3">
                        <textarea class="form-control" name="content" placeholder="Ecrivez votre critique ici"></textarea>
                    </div>
                    <button class="btn darkBtn btnWithBorders mx-3 mb-3" type="submit">Publier</button>
                </form>
            </div>
        </div>
    </div>
<?php
} ?>