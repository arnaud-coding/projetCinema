<?php

namespace App\Controllers;

use App\Controllers\Controller as Controller;
use App\Entities\Avis as Avis;
use App\Models\AvisModel as AvisModel;
use Exception;
use DateTime;

// ------------------------------------
// CLASSE CONTROLEUR DE L'ENTITE CLIENT
// ------------------------------------
class AvisController extends Controller
{
  // ----------------------------
  //  AJOUTER UN AVIS
  // ----------------------------
  // public function add()
  // {

  //   // Pas d'utilisateur connecté : redirection vers page de login pour se connecter pour pouvoir laisser un avis
  //   if (!isset($_SESSION['user'])) {
  //     $this->myHeader("Client", "formLogin", "error_avis");
  //     exit;
  //   }

  //   // création de l'avis avec les données renseignées
  //   if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  //     $id_produit = intval($_POST['id_produit']) ?? null;
  //     $id_client = $_SESSION['user']['id_client'] ?? null;
  //     $commentaire = $_POST['commentaire'] ?? null;
  //     $note = intval($_POST['note']) ?? null;
  //     $date_avis = new DateTime();
  //     $date = $date_avis->format('Y-m-d H:i:s');

  //     // Vérification que le formulaire a bien été rempli
  //     if (strlen($commentaire) >= 3 && $note) {

  //       $avis = new Avis();
  //       $avis->setId_produit($id_produit);
  //       $avis->setId_client($id_client);
  //       $avis->setCommentaire($commentaire);
  //       $avis->setNote($note);
  //       $avis->setDate_avis($date);

  //       $avisModel = new AvisModel();
  //       $avisModel->add($avis);
  //       header("Location: index.php?controller=Produit&action=show&id_produit=" . $id_produit);
  //       exit;
  //     } else {
  //       $message = "Veuillez définir une note et un texte d'au moins 3 caractères pour que votre avis soit publié.";
  //       header("Location: index.php?controller=Produit&action=show&id_produit=" . $id_produit . "&message=" . urlencode($message));
  //       exit;
  //     }
  //   }
  // }
}
