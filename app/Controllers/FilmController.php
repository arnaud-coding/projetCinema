<?php

namespace App\Controllers;

use App\Controllers\Controller as Controller;
use App\Models\FilmModel as FilmModel;
use App\Models\GenreModel as GenreModel;
use App\Models\ActorModel as ActorModel;
use App\Models\DirectorModel as DirectorModel;
use App\Models\ReviewModel as ReviewModel;

class FilmController extends Controller
{
    // NAVIGUE VERS ACCEUIL FILMS
    // --------------------
    public function home()
    {

        $genres = [
            "Science-fiction" => 7,
            "Action" => 1,
            "Drame" => 5,
            "Horreur" => 6,
            "Thriller" => 9,
            "Crime" => 19
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

            $films = $this->getFilmsByGenre($id);    // renvoie un tableau de type D2 (cf exemple)
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


    // RETOURNE LISTE DE FILMS POUR UN GENRE DONNE
    // --------------------
    private function getFilmsByGenre($id_genre)
    {

        if (!$id_genre) {
            // AUCUN GENRE FOURNI : REDIRECTION AVEC MESSAGE D'ERREUR
            $message = "Erreur innatendue";
            header("Location: index.php?controller=Film&action=home&message=" . urlencode($message));
            exit;
        }

        // VERIFIE QUE LE GENRE EXISTE EN BDD
        $genreModel = new GenreModel();
        $genre = $genreModel->readByID($id_genre);
        if (!$genre) {
            // ID GENRE FOURNI NE CORRESPONDANT A AUCUN GENRE DE LA BDD
            return [];
        }

        // GENRE OK : LECTURE DES FILMS PAR GENRE
        $filmModel = new FilmModel();
        $filmsByGenre = $filmModel->readAllByGenre($id_genre);
        if (!$filmsByGenre) {
            // AUCUN FILM POUR LE GENRE FOURNI
            return [];
        }

        // CONVERSION DES MINUTES EN HEURES/MINUTES
        foreach ($filmsByGenre as $film) {
            $film->duration = $this->convertMinutesToHours($film->duration);
        }

        // FILMS EXISTANTS : RETOUR DU RESULTAT
        return $filmsByGenre;
    }

    // NAVIGUE VERS LA PAGE DETAILS FILM
    // --------------------
    public function details()
    {
        // RECUPERE ID FILM DEPUIS URL
        $id_film = isset($_GET["id_film"]) ? $_GET["id_film"] : null;
        if (!$id_film) {
            $message = "Erreur systeme: Contactez l'administrateur du système";
            header("Location: index.php?controller=Film&action=home&message=" . urlencode($message));
            exit;
        }

        // RECUPERE DONNEES FILM
        $film = $this->getFilmDetails($id_film);

        // ENVOI DONNEES FILM ET SCRIPTS JS A LA VUE
        $data = [
            "film" => $film,
            "scripts" => [
                "type='module' src='../public/js/reviews.js'",
                "type='module' src='../public/js/deleteReview.js'"
            ]
        ];
        // NAVIGATION VERS PAGE
        $this->render("film/filmDetails", $data);
    }

    // RETOURNE DETAILS D'UN FILM POUR UN FILM DONNE
    // --------------------
    private function getFilmDetails($id_film)
    {
        if (!$id_film) {
            // AUCUN FILM FOURNI : REDIRECTION AVEC MESSAGE D'ERREUR
            $message = "Erreur innatendue";
            header("Location: index.php?controller=Film&action=home&message=" . urlencode($message));
            exit;
        }

        $film = [];

        // RECUPERE LE FILM
        $filmModel = new FilmModel();
        $details = $filmModel->readByID($id_film);
        if (!$details) {
            // RETOUR SI FILM INEXISTANT
            return null;
        }
        $film['details'] = $details;

        // CONVERSION DES MINUTES EN HEURES/MINUTES
        $film['details']->duration = $this->convertMinutesToHours($film['details']->duration);

        // RECUPERE LE(S) GENRE(S)
        $genreModel = new GenreModel();
        $genres = $genreModel->getAllByFilmId($id_film);
        $film["genres"] = $genres;

        // RECUPERE LES ACTEURS DU FILM
        $actorModel = new ActorModel();
        $actors = $actorModel->getAllByFilmId($id_film);
        $film['actors'] = $actors;

        // RECUPERE LES REALISATEURS DU FILM
        $directorModel = new DirectorModel();
        $directors = $directorModel->getAllByFilmId($id_film);
        $film['directors'] = $directors;

        // RECUPERE LES CRITIQUES DU FILM
        $reviewModel = new ReviewModel();
        $reviews = $reviewModel->readAllByFilmId($id_film);
        $film['reviews'] = $reviews;

        return $film;
    }
}
