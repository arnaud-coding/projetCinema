<?php if (!$genre) { ?>
    <p class="text-center">Aucune donnée trouvée pour ce genre</p>
<?php
} else { ?>
    <h3 class="text-center mb-4"><?= $genre["details"]->name ?></h3>
    <div class="row">
        <?php foreach ($genre["films"] as $film) { ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-4 d-flex justify-content-center">
                <div style="width: 150px;">
                    <a href="index.php?controller=Film&action=details&id_film=<?= htmlspecialchars($film->id_film, ENT_QUOTES, "UTF-8") ?>"
                        class="darkTypo menuLinks">
                        <object data="img/img_films/<?= htmlspecialchars($film->picture, ENT_QUOTES, "UTF-8") ?>" class="img-fluid rounded shadow-sm" alt="<?= htmlspecialchars($film->title, ENT_QUOTES, "UTF-8") ?>">
                            <img src="img/nopicture.jpg" class="img-fluid rounded shadow-sm mb-1" alt="no picture" style="width: 150px;">
                        </object>
                        <p class="text-center fw-bold mt-1 mb-0"><?= htmlspecialchars($film->title, ENT_QUOTES, "UTF-8") ?></p>
                    </a>
                </div>
            </div>
        <?php
        } ?>
    </div>
<?php
}
