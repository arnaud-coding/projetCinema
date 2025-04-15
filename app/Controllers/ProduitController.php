<?php

// DEFINITION DE L'ESPACE DE NOM
namespace App\Controllers;

// IMPORT DE CLASSES
use App\Controllers\Controller as Controller;
use App\Models\AvisModel as AvisModel;

//------------------------------------
// CLASSE CONTROLEUR DE L'ENTITE LIVRE
//------------------------------------
class ProduitController extends Controller
{

  public function listByCategory()
  {
    $id_categorie = isset($_GET['id_categorie']) ? $_GET['id_categorie'] : '';

    $produits = json_decode(file_get_contents("https://www.cefii-developpements.fr/olivier1422/cefii_market/market_api/public/index.php?controller=Produit&action=listByCategory&id_categorie=" . $id_categorie));

    $this->render('produit/listByCategorie', ['produits' => $produits]);
  }

  public function show()
  {
    $id_produit = isset($_GET['id_produit']) ? $_GET['id_produit'] : '';

    $produit = json_decode(file_get_contents("https://www.cefii-developpements.fr/olivier1422/cefii_market/market_api/public/index.php?controller=Produit&action=show&id_produit=" . $id_produit));

    $avisModel = new AvisModel();
    $avis = $avisModel->readByProduit($id_produit);

    $this->render('produit/view', ['produit' => $produit, 'avis' => $avis]);
  }
}
