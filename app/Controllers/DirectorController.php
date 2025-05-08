<?php

namespace App\Controllers;

use App\Controllers\Controller as Controller;
// use App\Entities\Director as Director;
use App\Models\DirectorModel as DirectorModel;
use App\Models\FilmModel as FilmModel;
use Exception;

// ------------------------------------
// CLASSE CONTROLEUR DE LA PAGE REALISATEURS
// ------------------------------------
class DirectorController extends Controller
{

    // RENDU ACCEUIL REALISATEURS
    public function home()
    {
        $this->render("director/homeDirector");
    }

    // NAVIGUE VERS LA PAGE DETAILS REALISATEUR
    // ----------------------
    public function details()
    {
        // RECUPERE ID FILM DEPUIS URL
        $id_director = isset($_GET["id_director"]) ? $_GET["id_director"] : null;
        if (!$id_director) {
            $message = "Erreur systeme: Contactez l'administrateur du système.";
            header("Location: index.php?controller=Director&action=home&message=" . urlencode($message));
            exit;
        }

        // RECUPERE DONNEES REALISATEUR
        $director = $this->getDirectorDetails($id_director);

        // ENVOI DONNEES FILM ET SCRIPTS JS A LA VUE
        $data = [
            "director" => $director,
            "scripts" => []
        ];
        // NAVIGATION VERS PAGE
        $this->render("director/directorDetails", $data);
    }

    // RETOURNE DETAILS D'UN FILM POUR UN REALISATEUR DONNE
    // --------------------
    private function getDirectorDetails($id_director)
    {
        if (!$id_director) {
            // AUCUN ACTEUR FOURNI : REDIRECTION AVEC MESSAGE D'ERREUR
            $message = "Erreur innatendue.";
            header("Location: index.php?controller=Director&action=home&message=" . urlencode($message));
            exit;
        }

        $director = [];

        // RECUPERE LE REALISATEUR EN BDD
        $directorModel = new DirectorModel();
        $details = $directorModel->readByID($id_director);
        if (!$details) {
            // RETOUR SI ACTEUR INEXISTANT
            return null;
        }
        $director['details'] = $details;

        // RECUPERE LES FILMS DU REALISATEUR EN BDD
        $filmModel = new FilmModel();
        $films = $filmModel->readAllByDirectorId($id_director);
        $director['films'] = $films;

        return $director;
    }
}
