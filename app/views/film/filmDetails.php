<?php
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
            <a href="index.php?controller=<?= $controller ?>&action=details&<?= $key ?>=<?= htmlspecialchars($id, ENT_QUOTES, "UTF-8") ?>" class="darkTypo menuLinks linksOnHover">
                <b><?= htmlspecialchars($name, ENT_QUOTES, "UTF-8") ?></b>
            </a>
        <?php
            break;
        } else {
            // affichage du 1er à l'avant dernier élément
            $name = $items[$i]->name . ", "; ?>
            <a href="index.php?controller=<?= $controller ?>&action=details&<?= $key ?>=<?= htmlspecialchars($id, ENT_QUOTES, "UTF-8") ?>" class="darkTypo menuLinks linksOnHover">
                <b><?= htmlspecialchars($name, ENT_QUOTES, "UTF-8") ?></b>
            </a>
    <?php
        }
    }
};

if (!$film) { ?>
    <p class="text-center">Aucune donnée trouvée pour ce film</p>
<?php
} else { ?>

    <div class="container mt-4">
        <!-- TITRE PRINCIPAL = TITRE DU FILM -->
        <h2 class="text-center fw-bolder"><?= htmlspecialchars($film["details"]->title, ENT_QUOTES, "UTF-8") ?></h2>

        <!-- MENU DES DÉTAILS DU FILM -->
        <nav class="d-flex justify-content-center mt-4 mb-4">
            <div class="nav nav-pills d-flex flex-nowrap" id="pills-tab" role="tablist">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Accueil</button>
                <button class="nav-link" id="pills-casting-tab" data-bs-toggle="pill" data-bs-target="#pills-casting" type="button" role="tab" aria-controls="pill-casting" aria-selected="false">Casting</button>
                <button class="nav-link" id="pills-reviews-tab" data-bs-toggle="pill" data-bs-target="#pills-reviews" type="button" role="tab" aria-controls="pill-reviews" aria-selected="false">Critiques</button>
                <button class="nav-link" id="pills-similar-tab" data-bs-toggle="pill" data-bs-target="#pills-similar" type="button" role="tab" aria-controls="pill-similar" aria-selected="false">Films similaires</button>
            </div>
        </nav>

        <!-- CONTENU PRINCIPAL DE LA PAGE -->
        <div class="tab-content" id="pills-tabContent">

            <!-- ACCUEIL DETAILS -->
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
                    </div>
                </div>
                <!-- SYNOPSIS -->
                <h4>Synopsis :</h4>
                <p><?= htmlspecialchars($film["details"]->synopsis, ENT_QUOTES, "UTF-8") ?></p>
            </div>

            <!-- CASTING -->
            <div class="tab-pane fade" id="pills-casting" role="tabpanel" aria-labelledby="pills-casting-tab" tabindex="0">
                <div>
                    <h3 class="mb-4">Réalisateur(s)</h3>
                    <div class="d-flex">
                        <?php foreach ($film["directors"] as $director) { ?>
                            <a href="index.php?controller=Director&action=details&id_director=<?= htmlspecialchars($director->id_director, ENT_QUOTES, "UTF-8") ?>" class="darkTypo menuLinks" style="text-decoration: none;">
                                <div class="me-5" style="width: 150px;">
                                    <object data="img/img_directors/<?= htmlspecialchars($director->picture, ENT_QUOTES, "UTF-8") ?>" class="img-fluid rounded shadow-sm" alt="<?= htmlspecialchars($director->name, ENT_QUOTES, "UTF-8") ?>">
                                        <img src="img/nopicture.jpg" class="img-fluid rounded shadow-sm mb-1" alt="no picture" style="width: 150px;">
                                    </object>
                                    <p class="text-center fw-bold mt-1 mb-0"><?= htmlspecialchars($director->name, ENT_QUOTES, "UTF-8") ?></p>
                                </div>
                            </a>
                        <?php
                        } ?>
                    </div>
                </div>
                <div class="container-fluid mt-5">
                    <h3 class="mb-4">Acteurs</h3>
                    <div class="row">
                        <?php foreach ($film["actors"] as $actor) { ?>
                            <a href="index.php?controller=Actor&action=details&id_actor=<?= htmlspecialchars($actor->id_actor, ENT_QUOTES, "UTF-8") ?>" class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 darkTypo menuLinks" style="text-decoration: none;">
                                <div style="width: 150px;">
                                    <object data="img/img_actors/<?= htmlspecialchars($actor->picture, ENT_QUOTES, "UTF-8") ?>" class="img-fluid rounded shadow-sm" alt="<?= htmlspecialchars($actor->name, ENT_QUOTES, "UTF-8") ?>">
                                        <img src="img/nopicture.jpg" class="img-fluid rounded shadow-sm mb-1" alt="no picture" style="width: 150px;">
                                    </object>
                                    <p class="text-center fw-bold mt-1 mb-0"><?= htmlspecialchars($actor->name, ENT_QUOTES, "UTF-8") ?></p>
                                </div>
                            </a>
                        <?php
                        } ?>
                    </div>
                </div>
            </div>

            <!-- CRITIQUES -->
            <div class="tab-pane fade" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab" tabindex="0">
                <h3 class="text-center mt-5 mb-4">Critiques téléspectateurs</h3>
                <?php if (!$film["reviews"]) { ?>
                    <p class="card-text text-center m-3">
                        Aucune critique pour l'instant,<br>Soyez le premier à donner votre avis sur ce film !
                    </p>
                    <?php
                } else {
                    // PARCOURS LES CRITIQUES PUBLIÉES SUR LE FILM
                    foreach ($film["reviews"] as $review) {
                        $date = new DateTime(htmlspecialchars($review->publication_date, ENT_QUOTES, "UTF-8"));
                        $formatter = new IntlDateFormatter(
                            'fr_FR',               // Langue : français
                            IntlDateFormatter::LONG,
                            IntlDateFormatter::NONE,
                            'Europe/Paris',        // Fuseau horaire
                            IntlDateFormatter::GREGORIAN,
                            'd MMMM yyyy'          // Format : "4 novembre 1969"
                        )
                    ?>
                        <div class="card lightForm formDarkMode m-3 p-3">
                            <p class="card-text">
                                <i><b><?= htmlspecialchars($review->pseudo, ENT_QUOTES, "UTF-8") ?></b></i>, le <?= $formatter->format($date) ?>
                            </p>
                            <p class="card-text"><?= htmlspecialchars($review->content, ENT_QUOTES, "UTF-8") ?></p>
                            <div class="card-text">
                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                    <i class="bi bi-star-fill publishedReview <?= $i <= htmlspecialchars($review->rating, ENT_QUOTES, "UTF-8") ? 'active' : '' ?>" data-value="<?= $i ?>"></i>
                                <?php
                                } ?>
                            </div>
                        </div>
                <?php
                    }
                } ?>

                <!-- FORMULAIRE : PUBLIER UNE CRITIQUE -->
                <div class="card m-3 lightForm formDarkMode">
                    <b><label class="form-label fst-italic ms-4 mt-3" for="commentaire">Donnez votre avis !</label></b>
                    <div id="star-rating" class="ms-4">
                        <i class="bi bi-star-fill star" data-value="1"></i>
                        <i class="bi bi-star-fill star" data-value="2"></i>
                        <i class="bi bi-star-fill star" data-value="3"></i>
                        <i class="bi bi-star-fill star" data-value="4"></i>
                        <i class="bi bi-star-fill star" data-value="5"></i>
                    </div>
                    <p id="ratingValue" class="mt-2 ms-4" style="display: none;"><b>Note : </b>0/5</p>

                    <form action="index.php?controller=Review&action=add" method="post">
                        <input type="hidden" name="rating" id="rating">
                        <input type="hidden" name="id_film" value="<?= htmlspecialchars($film["details"]->id_film, ENT_QUOTES, "UTF-8") ?>">
                        <div class="m-3">
                            <textarea class="form-control" name="content" placeholder="Ecrivez votre critique ici"></textarea>
                        </div>
                        <button class="btn darkBtn btnWithBorders mx-3 mb-3" type="submit">Publier</button>
                    </form>
                </div>
            </div>

            <!-- FILMS SIMILAIRES -->
            <div class="tab-pane fade" id="pills-similar" role="tabpanel" aria-labelledby="pills-reviews-tab" tabindex="0">
                LUKE : NOOOON !!!
            </div>
        </div>
    </div>
<?php
} ?>