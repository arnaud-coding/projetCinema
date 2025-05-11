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
      $message = "Vous devez être indentifié pour pouvoir publier une critique";
      header("Location: index.php?controller=User&action=formLogin&message=" . urlencode($message));
      exit();
    }

    // création de la critique avec les données du formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $id_film = intval($_POST['id_film']) ?? null;
      $id_user = $_SESSION['user']['id_user'] ?? null;
      $content = $_POST['content'] ?? null;
      $rating = intval($_POST['rating']) ?? null;
      $publication_date = new DateTime();
      $date = $publication_date->format('Y-m-d');

      // Vérification qu'une note a bien été attribué au film sinon redirection avec message d'erreur
      if (!$rating) {
        $message = "Vous devez au moins attribuer à ce film une note (comprise entre 1 et 5 étoiles) pour que votre avis soit publié";
        header("Location: index.php?controller=Film&action=details&id_film=" . $id_film . "&message=" . urlencode($message));
        exit();
      }

      // Vérification que la longueur du contenu de la critique soit suffisante
      if (strlen($content) < 4) {
        $message = "La longueur d'une critique ne peut être inférieure à 4 caractères";
        header("Location: index.php?controller=Film&action=details&id_film=" . $id_film . "&message=" . urlencode($message));
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
      $message = $success ? "Votre critique a été publiée avec succès" : "Une erreur est survenue, veuillez réessayer ultérieurement";
      header("Location: index.php?controller=Film&action=details&id_film=" . $id_film . "&message=" . urlencode($message));
      exit();
    }
  }
}
