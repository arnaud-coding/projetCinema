<?php

namespace App\Controllers;

use App\Controllers\Controller as Controller;
use App\Models\FilmModel as FilmModel;
use App\Models\GenreModel as GenreModel;

class GenreController extends Controller
{
    // NAVIGUE VERS LA PAGE DETAILS GENRE
    // ----------------------
    public function details()
    {
        // RECUPERE ID FILM DEPUIS URL
        $id_genre = isset($_GET["id_genre"]) ? $_GET["id_genre"] : null;
        if (!$id_genre) {
            $message = "Erreur systeme: Contactez l'administrateur du système";
            header("Location: index.php?controller=Film&action=home&msgKO=" . urlencode($message));
            exit;
        }

        // RECUPERE DES FILMS SELON GENRE DONNE
        $genre = $this->getFilmsByGenre($id_genre);

        // ENVOI DONNEES FILM ET SCRIPTS JS A LA VUE
        $data = [
            "genre" => $genre
        ];
        // NAVIGATION VERS PAGE
        $this->render("genre/genreDetails", $data);
    }

    // RETOURNE LISTE DE FILMS POUR UN GENRE DONNE
    // --------------------
    public function getFilmsByGenre($id_genre)
    {

        if (!$id_genre) {
            // AUCUN GENRE FOURNI : REDIRECTION AVEC MESSAGE D'ERREUR
            $message = "Erreur innatendue.";
            header("Location: index.php?controller=Film&action=home&msgKO=" . urlencode($message));
            exit;
        }

        $genre = [];

        // VERIFIE QUE LE GENRE EXISTE EN BDD
        $genreModel = new GenreModel();
        $details = $genreModel->readByID($id_genre);
        if (!$details) {
            // ID GENRE FOURNI NE CORRESPONDANT A AUCUN GENRE DE LA BDD
            return [];
        }
        $genre["details"] = $details;

        // GENRE OK : LECTURE DES FILMS PAR GENRE
        $filmModel = new FilmModel();
        $films = $filmModel->readAllByGenre($id_genre);
        if (!$films) {
            // AUCUN FILM POUR LE GENRE FOURNI
            return [];
        }
        $genre["films"] = $films;

        // FILMS EXISTANTS : REDIRECTION VERS LA VUE POUR AFFICHER RESULTAT
        return $genre;
    }
}
