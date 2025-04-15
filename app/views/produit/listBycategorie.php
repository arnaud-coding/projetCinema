<!---------------------->
<!-- TITRE DE LA PAGE -->
<!---------------------->
<h1 class="text-center fs-2 fst-italic">Produits de la catégorie "<?php echo htmlspecialchars($produits[0]->categorie) ?>"</h1>
<?php
// var_dump($produits)
?>
<!---------------------------->
<!-- LISTE DES PRODUITS -->
<!---------------------------->
<?php if (isset($produits)) : ?>
    <div class="d-flex flex-wrap justify-content-center my-3">
        <!-- ALIMENTATION DE CARD D'EVENEMENTS -->
        <?php foreach ($produits as $produit): ?>
            <div class="card bg-light m-2" style="width: 240px;">
                <img class="card-img-top" src="images/nopicture.jpg" alt="Card image">
                <div class="card-body">
                    <h5 class="card-title text-center"><?php echo htmlspecialchars($produit->produit, ENT_QUOTES, "UTF-8"); ?></h5>
                    <p class="card-text m-0 text-truncate"><strong>Description : </strong><?php echo htmlspecialchars($produit->description, ENT_QUOTES, "UTF-8"); ?></p>
                    <p class="card-text m-0"><strong>Marque : </strong><?php echo htmlspecialchars($produit->marque, ENT_QUOTES, "UTF-8"); ?></p>
                    <p class="card-text"><strong>Prix : </strong><?php echo $produit->prix; ?> € TTC</p>
                    <a class="btn btn-primary d-grid mb-1" href="index.php?controller=Produit&action=show&id_produit=<?php echo htmlspecialchars($produit->id_produit, ENT_QUOTES, "UTF-8"); ?>">Détails et avis</a>
                    <a class="btn btn-success d-grid" href="index.php?controller=Client&action=addToCart&id_produit=<?php echo htmlspecialchars($produit->id_produit, ENT_QUOTES, "UTF-8"); ?>&prix=<?php echo htmlspecialchars($produit->prix, ENT_QUOTES, "UTF-8"); ?>">Ajouter au panier</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>