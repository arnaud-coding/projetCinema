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

        $genres = [
            "Science-fiction" => 7,
            "Action" => 1,
            "Drame" => 5,
            "Horreur" => 6,
            "Thriller" => 9
        ];

        /*
        Résultat :
            Un tableau à 2 dimensions contenant :
                - dimension 1 : key = nom du genre ; value = tableau de films (cf dimension 2)
                - dimension 2 : key = index du tableau de cette dimension (pas utilisé) ; value = objet film
        Exemple :
            D1['sci-fi']= D2[]                         (key= genre, value= D2[genre 0])
                D2[0]= film 0 du genre 0                    object film
                D2[1]= film 1 du genre 0                    object film
                D2[2]= film 2 du genre 0                    object film
                D2 [1]
            D1['action']= D2[]                         (key= index 1, value= D2[genre 1])
                D2[0]= film 0 du genre 1                    object film
                D2[0]= film 0 du genre 2                    object film

        */
        $filmsByGenres = [];
        foreach ($genres as $name => $id) {

            $films = $this->displayByGenre($id);    // renvoie un tableau de type D2 (cf exemple)
            $filmsByGenres[$name] = $films;       // ajoute le D2 au D1
        }

        // SCRIPTS JS
        $data = [
            "filmsByGenres" => $filmsByGenres,
            "scripts" => ["type='module' src='../public/js/filmsByGenre.js'"]
        ];

        // NAVIGATION VERS PAGE
        $this->render("film/homeFilm", $data);
    }


    // AFFICHAGE DE FILMS PAR GENRE
    // --------------------
    public function displayByGenre($id_genre)
    {

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
            } else {

                // GENRE OK : LECTURE DES FILMS PAR GENRE
                $filmModel = new FilmModel();
                $filmsByGenre = $filmModel->readByGenre($id_genre);

                if (!$filmsByGenre) {
                    // AUCUN FILM POUR LE GENRE FOURNI
                    return [];
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
