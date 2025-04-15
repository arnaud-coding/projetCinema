<?php
$produits = $_SESSION["panier"] ?? [];
?>
<h1 class="text-center fs-2 fst-italic">Mon panier</h1>
<?php if (empty($produits)) { ?>
  <p class="text-center">Le panier est vide.</p>
<?php
} else {
?>
  <p class="text-center">
    <a class="btn btn-danger" href="index.php?controller=Client&action=clearCart">Vider le panier</a>
  </p>

  <div class="d-flex flex-wrap justify-content-center my-3">
    <?php
    $prix = 0;

    foreach ($produits as $index => $produit):
      $produit = json_decode(file_get_contents("https://www.cefii-developpements.fr/olivier1422/cefii_market/market_api/public/index.php?controller=Produit&action=show&id_produit=" . $produit['id_produit']));
      $prix += $produits[$index]['prix'];

    ?>

      <div class="card bg-light m-2" style="width: 240px;">
        <img class="card-img-top" src="images/" alt="Card image">
        <div class="card-body">
          <h5 class="card-title text-center"><?php echo htmlspecialchars($produit->produit, ENT_QUOTES, "UTF-8"); ?></h5>
          <p class="card-text m-0 text-truncate"><strong>Description : </strong><?php echo htmlspecialchars($produit->description, ENT_QUOTES, "UTF-8"); ?></p>
          <p class="card-text mb-2"><strong>Marque : </strong><?php echo htmlspecialchars($produit->marque, ENT_QUOTES, "UTF-8"); ?></p>
          <form method="post" action="index.php?controller=Client&action=setQuantity">
            <div class="d-flex">
              <input type="hidden" name="indexPanier" value="<?php echo $index ?>">
              <input type="hidden" name="id_produit" value="<?php echo $produit->id_produit ?>">
              <input type="hidden" name="prix" value="<?php echo $produit->prix ?>">
              <i class="bi bi-dash-lg btn btn-secondary"></i>
              <input class="text-center w-75 mx-2" type="number" name="quantite" id="quantite" value="<?php echo $produits[$index]['quantite'] ?>">
              <i class="bi bi-plus btn btn-secondary"></i>
            </div>
            <input class="btn btn-primary w-100 mt-2 mb-2" type="submit" value="Mettre à jour">
          </form>
          <p class="card-text"><strong>Prix à l'unité : </strong><?php echo $produit->prix; ?> €</p>
          <p class="card-text"><strong>Prix total : <?php echo $produits[$index]['prix']; ?> €</strong></p>
          <a class="btn btn-secondary d-grid mb-1" href="index.php?controller=Produit&action=show&id_produit=<?php echo htmlspecialchars($produit->id_produit, ENT_QUOTES, "UTF-8"); ?>">Voir les détails</a>
          <a class="btn btn-danger d-grid" href="index.php?controller=Client&action=removeFromCart&produit=<?php echo htmlspecialchars($index, ENT_QUOTES, "UTF-8"); ?>">Retirer du panier</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <p class="text-center"><?php echo count($produits) ?> article(s)</p>
  <p class="text-center">Prix total de la commande : <strong><?php echo $prix ?> €</strong></p>
  <?php
  $_SESSION['montant_commande'] = $prix;
  ?>
  <p class="text-center">
    <a class="btn btn-success" href="index.php?controller=Client&action=validateOrder">Finaliser la commande</a>
  </p>
<?php
}
