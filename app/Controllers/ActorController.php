<?php

namespace App\Controllers;

use App\Controllers\Controller as Controller;
// use App\Entities\Actor as Actor;
use App\Models\ActorModel as ActorModel;
use App\Models\FilmModel as FilmModel;
use Exception;

// ------------------------------------
// CLASSE CONTROLEUR DE LA PAGE ACTEURS
// ------------------------------------
class ActorController extends Controller
{

    // RENDU ACCEUIL ACTEURS
    // ----------------------
    public function home()
    {
        $this->render("actor/homeActor");
    }

    // NAVIGUE VERS LA PAGE DETAILS FILM
    // ----------------------
    public function details()
    {
        // RECUPERE ID FILM DEPUIS URL
        $id_actor = isset($_GET["id_actor"]) ? $_GET["id_actor"] : null;
        if (!$id_actor) {
            $message = "Erreur systeme: Contactez l'administrateur du système.";
            header("Location: index.php?controller=Actor&action=home&message=" . urlencode($message));
            exit;
        }

        // RECUPERE DONNEES ACTEUR
        $actor = $this->getActorDetails($id_actor);

        // ENVOI DONNEES FILM ET SCRIPTS JS A LA VUE
        $data = [
            "actor" => $actor,
            "scripts" => []
        ];
        // NAVIGATION VERS PAGE
        $this->render("actor/actorDetails", $data);
    }

    // RETOURNE DETAILS D'UN FILM POUR UN FILM DONNE
    // --------------------
    private function getActorDetails($id_actor)
    {
        if (!$id_actor) {
            // AUCUN ACTEUR FOURNI : REDIRECTION AVEC MESSAGE D'ERREUR
            $message = "Erreur innatendue.";
            header("Location: index.php?controller=Actor&action=home&message=" . urlencode($message));
            exit;
        }

        $actor = [];

        // RECUPERE L'ACTEUR EN BDD
        $actorModel = new ActorModel();
        $details = $actorModel->readByID($id_actor);
        if (!$details) {
            // RETOUR SI ACTEUR INEXISTANT
            return null;
        }
        $actor['details'] = $details;

        // RECUPERE LES FILMS DE L'ACTEUR EN BDD
        $filmModel = new FilmModel();
        $films = $filmModel->readAllByActorId($id_actor);
        $actor['films'] = $films;

        return $actor;
    }
}
