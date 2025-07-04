<?php

namespace App\Controllers;

use App\Controllers\Controller as Controller;
use App\Core\CSRFTokenManager as CSRFTokenManager;
use App\Core\Validator as Validator;
use App\Entities\Film as Film;
use App\Entities\Film_Genre as Film_Genre;
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


        $filmsByGenres = [];
        foreach ($genres as $name => $id) {

            $films = $this->getFilmsByGenre($id);    // renvoie un tableau de type D2 (cf exemple)
            $filmsByGenres[$name] = $films;       // ajoute le D2 au D1
        }

        // SCRIPTS JS
        $data = [
            "filmsByGenres" => $filmsByGenres,
            "scripts" => [
                "type='module' src='js/filmsByGenre.js'",
                "type='module' src='js/home.js'"
            ]
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
            $message = "Erreur inattendue";
            header("Location: index.php?controller=Film&action=home&msgKO=" . urlencode($message));
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
            header("Location: index.php?controller=Film&action=home&msgKO=" . urlencode($message));
            exit;
        }

        // RECUPERE DONNEES FILM
        $film = $this->getFilmDetails($id_film);

        // ENVOI DONNEES FILM ET SCRIPTS JS A LA VUE
        $data = [
            "film" => $film,
            "scripts" => [
                "type='module' src='js/reviews.js'",
                "type='module' src='js/delete.js'",
                "type='module' src='js/addToFilmModal.js'",
                "type='module' src='js/removeFromFilm.js'"
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
            $message = "Erreur inattendue";
            header("Location: index.php?controller=Film&action=home&msgKO=" . urlencode($message));
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

        // CALCUL NOTE MOYENNE DES CRITIQUES
        $totalRating = 0;
        $nbReviews = count($reviews);
        if ($nbReviews > 0) {
            foreach ($reviews as $review) {
                $totalRating += $review->rating;
            }
            $average_rating = $totalRating / $nbReviews;
            $film["average_rating"] = round($average_rating, 1);
        }

        return $film;
    }


    // NAVIGATION VERS FORMULAIRE D'AJOUT DE FILM
    // --------------------
    public function addForm()
    {
        $token = CSRFTokenManager::generateCSRFToken();

        // Recupere tous les genres
        $genreModel = new GenreModel();
        $genres = $genreModel->readAll();

        $data = [
            "scripts" => [
                "type='module' src='js/filmForm.js'",
                "type='module' src='js/addGenreToFilm.js'"
            ],
            "genres" => $genres,
            "token" => $token,
            "controllerMethod" => "add"
        ];

        $this->render("film/addFilmForm", $data);
    }

    // AJOUTER UN FILM
    // -----------------
    public function add()
    {
        // Verification de la methode de requête
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo json_encode([
                'success' => false,
                'message' => "Erreur : cette page doit être appelée via une requête POST"
            ]);
            exit();
        }

        // Récupération des données du formulaire
        $title = $_POST['title'] ?? null;
        $synopsis = $_POST['synopsis'] ?? null;
        $release_year = $_POST['release_year'] ?? null;
        $duration = $_POST['duration'] ?? null;
        $genres = $_POST['genres'] ?? [];
        $genresArray = [];
        foreach ($genres as $id_genre) {
            $genre = new Film_Genre();
            $genre->setId_genre($id_genre);
            $genresArray[] = $genre;
        }

        // Verification que le film ne soit pas deja en BDD
        $filmModel = new FilmModel();
        $film = $filmModel->readByTitleAndYear($title, intval($release_year));
        if ($film) {
            echo json_encode([
                'success' => false,
                'message' => "Le film '" . $title  . "' sorti en " . $release_year . " existe déja"
            ]);
            exit();
        }

        // GESTION DE L'UPLOAD
        if ($_FILES["picture"]["name"] !== "") {

            // Teste la validité du fichier uploadé (poids, extension et type MIME)
            if (!Validator::validateFiles($_FILES, ["picture"])) {
                echo json_encode([
                    'success' => false,
                    'message' => "Erreur lors de l'upload de l'image : le fichier est peut être trop volumineux (poids max : 5 Mo)"
                ]);
                exit();
            }

            // Destination du fichier
            $uploadDir = 'img/img_films/'; // S'assurer que ce dossier existe et est accessible en écriture
            $uploadName = $_FILES['picture']['name'];
            $uploadFile = $uploadDir . basename($uploadName);

            // Déplacer le fichier uploadé
            $success = move_uploaded_file($_FILES['picture']['tmp_name'], $uploadFile);
            if (!$success) {
                echo json_encode([
                    'success' => false,
                    'message' => "Erreur lors du déplacement de l'image vers sa destination"
                ]);
                exit();
            }
        } else {
            $uploadName = null;
        }

        // Hydratation de l'instance de l'entité Film avec les données du formulaire
        $film = new Film();
        $film->setTitle($title);
        $film->setSynopsis($synopsis);
        $film->setRelease_year(intval($release_year));
        $film->setDuration(intval($duration));
        $film->setPicture($uploadName);

        // Appel de la methode d'ajout de film dans la BDD
        $success = $filmModel->add($film, $genresArray);

        echo json_encode([
            'success' => $success,
            'message' => $success ? "Le film a été ajouté avec succès" : "Echec lors de l'ajout du film"
        ]);
        exit();
    }

    // NAVIGATION VERS FORMULAIRE DE MODIFICATION DE FILM
    // --------------------
    public function updateForm()
    {
        $id_film = isset($_GET["id_film"]) ? $_GET["id_film"] : "";

        // Récupère le film
        $filmModel = new FilmModel();
        $film = $filmModel->readByID($id_film);
        if (!$film) {
            $message = "Erreur inattendue : Contactez l'administrateur du système";
            header("Location: index.php?controller=Film&action=home&msgKO=" . urlencode($message));
        }

        // Récupère les genres associés au film
        $genreModel = new GenreModel();
        $filmGenres = $genreModel->getAllByFilmId($id_film);
        $filmGenres = array_map(fn($genre) => $genre->id_genre, $filmGenres);

        // Recupere tous les genres
        $genres = $genreModel->readAll();

        $token = CSRFTokenManager::generateCSRFToken();

        $data = [
            "scripts" => [
                "type='module' src='js/filmForm.js'",
                "type='module' src='js/addGenreToFilm.js'"
            ],
            "film" => $film,
            "genres" => $genres,
            "filmGenres" => $filmGenres,
            "token" => $token,
            "controllerMethod" => "update"
        ];

        $this->render("film/updateFilmForm", $data);
    }

    // MODIFIER UN FILM
    // -----------------
    public function update()
    {
        // Verification de la methode de requête
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo json_encode([
                'success' => false,
                'message' => "Erreur : cette page doit être appelée via une requête POST"
            ]);
            exit();
        }

        // Récupération des données du formulaire
        $id_film = $_POST['id_film'] ?? null;
        $title = $_POST['title'] ?? null;
        $synopsis = $_POST['synopsis'] ?? null;
        $release_year = $_POST['release_year'] ?? null;
        $duration = $_POST['duration'] ?? null;
        $genres = $_POST['genres'] ?? [];

        // GESTION DE L'UPLOAD
        if ($_FILES["picture"]["name"] !== "") {

            // Teste la validité du fichier uploadé (poids, extension et type MIME)
            if (!Validator::validateFiles($_FILES, ["picture"])) {
                echo json_encode([
                    'success' => false,
                    'message' => "Erreur lors de l'upload de l'image : le fichier est peut être trop volumineux (poids max : 5 Mo)"
                ]);
                exit();
            }

            // Destination du fichier
            $uploadDir = 'img/img_films/'; // S'assurer que ce dossier existe et est accessible en écriture
            $uploadName = $_FILES['picture']['name'];
            $uploadFile = $uploadDir . basename($uploadName);

            // Déplacer le fichier uploadé
            $success = move_uploaded_file($_FILES['picture']['tmp_name'], $uploadFile);
            if (!$success) {
                echo json_encode([
                    'success' => false,
                    'message' => "Erreur lors du déplacement de l'image vers sa destination"
                ]);
                exit();
            }
        } else {
            $uploadName = null;
        }

        // Hydratation de l'instance de l'entité Film avec les données du formulaire
        $film = new Film();
        $film->setId_film(intval($id_film));
        $film->setTitle($title);
        $film->setSynopsis($synopsis);
        $film->setRelease_year(intval($release_year));
        $film->setDuration(intval($duration));
        $film->setPicture($uploadName);

        // Appel de la methode de mise à jour de film dans la BDD
        $filmModel = new FilmModel();
        $success = $filmModel->update($film);

        if ($success === true) {
            // Suppression des précédentes associations entre le film et des genres et ajout des nouveaux
            $filmModel->RemoveAllGenresFromFilm(intval($id_film));
            foreach ($genres as $id_genre) {
                $filmModel->addGenreToFilm($id_film, $id_genre);
            }
        }

        echo json_encode([
            'success' => $success,
            'message' => $success ? "Le film a été mis à jour avec succès" : "Echec lors de la mise à jour du film"
        ]);
        exit();
    }

    // SUPPRIMER UN FILM
    // -----------------
    public function delete()
    {
        $id_film = isset($_GET["id_film"]) ? $_GET["id_film"] : "";

        // Récupération du réalisateur à supprimer
        $filmModel = new FilmModel();
        $film = $filmModel->readByID($id_film);
        if (!$film) {
            // Film non trouvé en BDD
            echo json_encode([
                "success" => false,
                "message" => "Erreur inattendue : veuillez contacter l'administrateur du sysème"
            ]);
            exit();
        }

        // Vérification que le film ne soit pas associé à des réalisateurs et/ou acteurs et/ou à des genres
        $actorModel = new ActorModel();
        $actors = $actorModel->getAllByFilmId($id_film);
        $directorModel = new DirectorModel();
        $directors = $directorModel->getAllByFilmId($id_film);
        $genreModel = new GenreModel();
        $genres = $genreModel->getAllByFilmId($id_film);
        if ($actors || $directors || $genres) {
            // Erreur : on demande à l'utilisateur d'aller supprimer les associations entre film et acteurs/réalisateurs,
            // et entre film et genres avant de supprimer le film
            echo json_encode([
                'success' => false,
                'message' => 'Veuillez retirer les genres au film et les acteurs/réalisateurs du casting de ce film avant de le supprimer'
            ]);
            exit();
        }

        // Suppression du film en BDD
        $success = $filmModel->delete($id_film);
        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Film supprimé avec succès' : 'Echec de la supression du film'
        ]);
        exit();
    }

    // AJOUTER UN ACTEUR A UN FILM
    // -----------------
    public function addActorToFilm()
    {
        $id_film = isset($_GET["id_film"]) ? $_GET["id_film"] : null;
        $id_actor = isset($_GET["id_actor"]) ? $_GET["id_actor"] : null;

        $filmModel = new FilmModel();
        $success = $filmModel->addActorToFilm($id_film, $id_actor);

        if ($success) {
            $actorModel = new ActorModel();
            $actor = $actorModel->readByID($id_actor);
            echo json_encode([
                'success' => $success,
                'message' => $success ? "L'acteur a été ajouté au casting du film avec succès" : "Echec lors de l'ajout de l'acteur au casting de ce film",
                'actor' => $actor
            ]);
            exit();
        }
    }

    // AJOUTER UN REALISATEUR A UN FILM
    // -----------------
    public function addDirectorToFilm()
    {
        $id_film = isset($_GET["id_film"]) ? $_GET["id_film"] : null;
        $id_director = isset($_GET["id_director"]) ? $_GET["id_director"] : null;

        $filmModel = new FilmModel();
        $success = $filmModel->addDirectorToFilm($id_film, $id_director);

        if ($success) {
            $directorModel = new directorModel();
            $director = $directorModel->readByID($id_director);
            echo json_encode([
                'success' => $success,
                'message' => $success ? "Le réalisateur a été ajouté au film avec succès" : "Echec lors de l'ajout de ce réalisateur à ce film",
                "director" => $director
            ]);
            exit();
        }
    }

    // RETIRER UN ACTEUR DU CASTING D'UN FILM (SUPPRIMER L'ASSOCIATION)
    // -----------------
    public function removeActorFromFilm()
    {
        $id_film = isset($_GET["id_film"]) ? $_GET["id_film"] : null;
        $id_actor = isset($_GET["id_actor"]) ? $_GET["id_actor"] : null;

        $filmModel = new FilmModel();
        $success = $filmModel->removeActorFromFilm($id_film, $id_actor);

        echo json_encode([
            'success' => $success,
            'message' => $success ? "L'acteur a été retiré du film avec succès" : "Echec de la suppression de cet acteur du casting de ce film"
        ]);
        exit();
    }

    // RETIRER UN REALISATEUR D'UN FILM (SUPPRIMER L'ASSOCIATION)
    // -----------------
    public function removeDirectorFromFilm()
    {
        $id_film = isset($_GET["id_film"]) ? $_GET["id_film"] : null;
        $id_director = isset($_GET["id_director"]) ? $_GET["id_director"] : null;

        $filmModel = new FilmModel();
        $success = $filmModel->removeDirectorFromFilm($id_film, $id_director);

        echo json_encode([
            'success' => $success,
            'message' => $success ? "Le réalisateur a été retiré du film avec succès" : "Echec de la suppression de ce réalisateur de la réalisation de ce film"
        ]);
        exit();
    }
}
