<?php

namespace App\Controllers;

use App\Controllers\Controller as Controller;
use App\Entities\Review as Review;
use App\Models\ReviewModel as ReviewModel;
use Exception;
use DateTime;

class ReviewController extends Controller
{
  //  AJOUTER UN AVIS
  // -------------------
  public function add()
  {

    // Pas d'utilisateur connecté : redirection vers page de login pour se connecter pour pouvoir laisser un review
    if (!isset($_SESSION['user'])) {
      $message = "Vous devez être identifié pour publier une critique";
      header("Location: index.php?controller=User&action=formLogin&msgKO=" . urlencode($message));
      exit();
    }

    // Verification de la methode de requête
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      $message = "Erreur : cette page doit être appelée via une requête POST";
      header("Location: index.php?controller=Film&action=home&msgKO=" . urlencode($message));
      exit();
    }

    // Récupération des données du formulaire
    $id_film = intval($_POST['id_film']) ?? null;
    $id_user = $_SESSION['user']['id_user'] ?? null;
    $content = $_POST['content'] ?? null;
    $rating = intval($_POST['rating']) ?? null;
    $publication_date = new DateTime();
    $date = $publication_date->format('Y-m-d');

    // Vérification qu'une note a bien été attribué au film sinon redirection avec message d'erreur
    if (!$rating) {
      $message = "Vous devez au moins attribuer à ce film une note (comprise entre 1 et 5 étoiles) pour que votre avis soit publié";
      header("Location: index.php?controller=Film&action=details&id_film=" . $id_film . "&msgKO=" . urlencode($message));
      exit();
    }

    // Vérification que la longueur du contenu de la critique soit suffisante
    if (strlen($content) < 4) {
      $message = "La longueur d'une critique ne peut être inférieure à 4 caractères";
      header("Location: index.php?controller=Film&action=details&id_film=" . $id_film . "&msgKO=" . urlencode($message));
      exit();
    }

    // Hydratation de l'entité Review avec les données du formulaire
    $review = new Review();
    $review->setId_film($id_film);
    $review->setId_user($id_user);
    $review->setContent($content);
    $review->setRating($rating);
    $review->setPublication_date($date);

    // Création de la critique en BDD et redirection vers la page des détails du film
    $reviewModel = new ReviewModel();
    $success = $reviewModel->add($review);

    if (!$success) {
      $message = "Une erreur est survenue, veuillez réessayer ultérieurement";
      header("Location: index.php?controller=Film&action=details&id_film=" . $id_film . "&msgKO=" . urlencode($message));
      exit();
    }

    $message = "Votre critique a été publiée avec succès";
    header("Location: index.php?controller=Film&action=details&id_film=" . $id_film . "&msgOK=" . urlencode($message));
    exit();
  }

  // SUPPRIMER UNE CRITIQUE (MODERATION)
  // -------------------
  public function delete()
  {
    $id_review = isset($_GET['id_review']) ? $_GET['id_review'] : '';

    $reviewModel = new ReviewModel();
    $success = $reviewModel->delete($id_review);

    echo json_encode([
      'success' => $success,
      'message' => $success ? 'Critique supprimée avec succès' : 'Echec de la suppression de la critique'
    ]);
    exit();
  }
}
