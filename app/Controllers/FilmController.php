<?php

namespace App\Controllers;

use App\Controllers\Controller as Controller;
use App\Entities\Film as Film;
use App\Entities\Genre as Genre;
use App\Models\FilmModel as FilmModel;
use App\Models\GenreModel as GenreModel;
use Exception;

// ----------------------------------
// CLASSE CONTROLEUR DE LA PAGE FILMS
// ----------------------------------
class FilmController extends Controller
{
    // RENDU ACCEUIL FILMS
    // --------------------
    public function home()
    {
        $filmsByGenre = $this->displayByGenre(); // Récupération des films par leur genre

        // SCRIPTS JS
        $data = [
            "filmsByGenre" => $filmsByGenre,
            "scripts" => ["type='module' src='../public/js/filmsByGenre.js'"]
        ];

        // NAVIGATION VERS PAGE
        $this->render("film/homeFilm", $data);
    }


    // AFFICHAGE DE FILMS PAR GENRE
    // --------------------
    public function displayByGenre()
    {

        $id_genre = 7; // Science-fiction

        if (!$id_genre) {
            // AUCUN GENRE FOURNI : REDIRECTION AVEC MESSAGE D'ERREUR
            $message = "Erreur innatendue.";
            header("Location: index.php?controller=Film&action=home&message=" . urlencode($message));
        } else {
            // VERIFIE QUE LE GENRE EXISTE EN BDD
            $genreModel = new GenreModel();
            $genre = $genreModel->readByID($id_genre);

            if (!$genre) {
                // ID GENRE FOURNI NE CORRESPONDANT A AUCUN GENRE DE LA BDD
                // todo : erreur etrange "applications vous a redirigé à de trop nombreuses reprises."
                return [];
                // $message = "Le genre donné n'existe pas dans notre base de données.";
                // header("Location: index.php?controller=Film&action=home&message=" . urlencode($message));
            } else {

                // GENRE OK : LECTURE DES FILMS PAR GENRE
                $filmModel = new FilmModel();
                $filmsByGenre = $filmModel->readByGenre($id_genre);

                if (!$filmsByGenre) {
                    // AUCUN FILM POUR LE GENRE FOURNI
                    return [];
                    // $message = "Il n'y a pas de films appartenant à ce genre.";
                    // header("Location: index.php?controller=Film&action=home&message=" . urlencode($message));
                } else {

                    // CONVERSION DES MINUTES EN HEURES/MINUTES
                    foreach ($filmsByGenre as $film) {
                        $film->duration = $this->convertMinutesToHours($film->duration);
                    }

                    // FILMS EXISTANTS : RETOUR DU RESULTAT
                    return $filmsByGenre;
                }
            }
        }
    }
}
