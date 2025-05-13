<div class="container-fluid mt-5">
    <h3 class="text-center mb-4">Les réalisateurs</h3>
    <div class="row mx-auto">
        <?php foreach ($directors as $director) { ?>
            <a href="index.php?controller=Director&action=details&id_director=<?= htmlspecialchars($director->id_director, ENT_QUOTES, "UTF-8") ?>" class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 darkTypo menuLinks" style="text-decoration: none;">
                <div style="width: 150px;">
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