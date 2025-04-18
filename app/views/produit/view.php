<?php
$message = isset($_GET['message']) ? $_GET['message'] : '';
?>
<p style="color: red"><?php echo $message ?></p>
<!---------------------->
<!-- TITRE DE LA PAGE -->
<!---------------------->
<div class="d-flex align-items-center">

    <!-- TITRE -->
    <h1 class="flex-grow-1 text-center fs-2 fst-italic">Détails du produit</h1>

    <!-- BOUTON RETOUR -->
    <a class="btn btn-outline-secondary" href="index.php?controller=Produit&action=listByCategory&id_categorie=<?php echo htmlspecialchars($produit->id_categorie, ENT_QUOTES, "UTF-8") ?>" title="Retour en arrière">
        <i class="bi bi-x-lg"></i>
    </a>
</div>

<!---------------->
<!-- LE PRODUIT -->
<!---------------->
<div class="row align-items-center my-3">

    <!-- IMAGE -->
    <div class="col-3">
        <img class="img-fluid rounded-3" src="images/produits/produit.jpg" alt="Image du produit">
    </div>

    <!-- DESCRIPTION -->
    <div class="offset-1 col-8">
        <div class="card bg-light border-0">
            <div class="card-body">
                <h2 class="card-title"><?php echo htmlspecialchars($produit->produit, ENT_QUOTES, "UTF-8"); ?></h2>
                <p class="card-text m-0"><strong>Description : </strong><?php echo htmlspecialchars($produit->description, ENT_QUOTES, "UTF-8"); ?></p>
                <p class="card-text m-0"><strong>marque : </strong><?php echo htmlspecialchars($produit->marque, ENT_QUOTES, "UTF-8"); ?></p>
                <p class="card-text"><strong>Prix : </strong><?php echo htmlspecialchars($produit->prix, ENT_QUOTES, "UTF-8"); ?> € TTC</p>
                <p class="card-text"><strong>Catégorie : </strong><?php echo htmlspecialchars($produit->categorie, ENT_QUOTES, "UTF-8"); ?></p>

                <!-- BOUTONS AJOUTER AU PANIER OU CONNEXION -->
                <?php if (isset($_SESSION["user"]["id_client"])) : ?>
                    <!-- BOUTON AJOUTER AU PANIER -->
                    <a class="btn btn-success" href="index.php?controller=Client&action=addToCart&id_produit=<?php echo htmlspecialchars($produit->id_produit, ENT_QUOTES, "UTF-8"); ?>&prix=<?php echo htmlspecialchars($produit->prix, ENT_QUOTES, "UTF-8"); ?>">Ajouter au panier</a>
                <?php else : ?>

                    <!-- BOUTON CONNEXION -->
                    <a class="btn btn-secondary" href="index.php?controller=Client&action=formLogin"> Se connecter pour ajouter au panier</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Avis publiés-->
<h2 class="text-center mt-5 mb-3 fst-italic">Avis</h2>
<div class="card">
    <?php if (!$avis) {
    ?>
        <i class="card-text text-center m-3">Aucun avis laissé sur ce produit pour l'instant.</i>
        <?php
    } else {
        foreach ($avis as $value) {
            // Créer un objet DateTime en UTC à partir de la date récupérée de la BDD sous forme d'une string
            $date = new DateTime($value->date_avis, new DateTimeZone('UTC'));
            // Convertir la date en heure française (fuseau horaire Europe/Paris)
            $date = $date->setTimezone(new DateTimeZone('Europe/Paris'));
            // Formatter la date au format français
            $date = $date->format('Y/m/d à H:i');

        ?>
            <!-- AVIS -->
            <div class="card bg-light m-3 p-3">
                <p class="card-text"><i><strong><?php echo $value->firstname ?></strong></i>, le <?php echo $date ?></p>
                <p class="card-text"><?php echo $value->commentaire ?></p>
                <div class="card-text">
                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                        <i class="bi bi-star-fill starr <?php echo ($i <= $value->note) ? 'active' : ''; ?>" data-value="<?= $i ?>"></i>
                    <?php
                    } ?>
                </div>
            </div>
    <?php
        }
    } ?>

    <div class="card bg-light m-3">
        <strong><label class="form-label fst-italic ms-4 mt-3" for="commentaire">Donnez votre avis !</label></strong>
        <div id="star-rating" class="ms-4">
            <i class="bi bi-star-fill star" data-value="1"></i>
            <i class="bi bi-star-fill star" data-value="2"></i>
            <i class="bi bi-star-fill star" data-value="3"></i>
            <i class="bi bi-star-fill star" data-value="4"></i>
            <i class="bi bi-star-fill star" data-value="5"></i>
        </div>
        <p id="rating-value" class="mt-2 ms-4" style="display: none;"><strong>Note : </strong>0/5</p>

        <form action="index.php?controller=Avis&action=add" method="post">
            <input type="hidden" name="note" id="note">
            <input type="hidden" name="id_produit" value="<?php echo $produit->id_produit ?>">
            <div class="m-3">
                <textarea class="form-control" name="commentaire" id="commentaire" placeholder="Ecrivez votre commentaire ici"></textarea>
            </div>
            <button class="btn btn-primary mx-3 mb-3" type="submit">Publier</button>
        </form>
    </div>
</div>