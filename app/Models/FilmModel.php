<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Entities\Film;
use App\Core\DbConnect;


// -----------------------------
// CLASSE MODEL DE L'ENTITE FILM
// -----------------------------
class FilmModel extends DbConnect
{
    // ---------------
    //  LIRE UN FILM PAR SON ID
    // ---------------
    public function readByID($id_film)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("SELECT * FROM ppc_film WHERE id_film = :id_film");
            $this->request->bindValue(":id_film", $id_film, PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $film = $this->request->fetch();

            // RETOUR DU RESULTAT
            return $film;
        } catch (PDOException $e) {
            return $e->errorInfo[1];
        }
    }

    // ---------------
    //  LIRE LES FILMS D'UN ACTEUR
    // ---------------
    public function readAllByActorId($id_actor)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "SELECT f.*
                 FROM ppc_film f
                 INNER JOIN ppc_film_actor fa ON f.id_film = fa.id_film
                 WHERE fa.id_actor = :id_actor"
            );
            $this->request->bindValue(":id_actor", $id_actor, PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $films = $this->request->fetchAll();

            // RETOUR DU RESULTAT
            return $films;
        } catch (PDOException $e) {
            return $e->errorInfo[1];
        }
    }

    // ---------------
    //  LIRE LES FILMS D'UN REALISATEUR
    // ---------------
    public function readAllByDirectorId($id_director)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "SELECT f.*
                 FROM ppc_film f
                 INNER JOIN ppc_film_director fd ON f.id_film = fd.id_film
                 WHERE fd.id_director = :id_director"
            );
            $this->request->bindValue(":id_director", $id_director, PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $films = $this->request->fetchAll();

            // RETOUR DU RESULTAT
            return $films;
        } catch (PDOException $e) {
            return $e->errorInfo[1];
        }
    }

    // ---------------
    //  LIRE DES FILM PAR GENRE
    // ---------------
    public function readAllByGenre($id_genre)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "SELECT
                    f.*,
                    GROUP_CONCAT(DISTINCT g.name ORDER BY g.name SEPARATOR ', ') AS genres,
                    ROUND(AVG(r.rating), 1) AS average_rating
                FROM ppc_film f
                INNER JOIN ppc_film_genre fg ON f.id_film = fg.id_film
                INNER JOIN ppc_genre g ON fg.id_genre = g.id_genre
                LEFT JOIN ppc_review r ON f.id_film = r.id_film
                WHERE f.id_film IN (
                    SELECT id_film
                    FROM ppc_film_genre
                    WHERE id_genre = :id_genre
                )
                GROUP BY f.id_film;"
            );
            $this->request->bindValue(":id_genre", $id_genre, PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $films = $this->request->fetchAll();

            // RETOUR DU RESULTAT
            return $films;
        } catch (PDOException $e) {
            return $e->errorInfo[1];
        }
    }

    // TROUVE SI UN FILM EXISTE DEJA DANS LA BDD
    // ---------------
    public function readByTitleAndYear($title, $release_year)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "SELECT
                    *
                 FROM
                     ppc_film
                 WHERE
                     LOWER(title) = LOWER(:title) AND release_year = :release_year"
            );
            $this->request->bindValue(":title", $title, PDO::PARAM_STR);
            $this->request->bindValue(":release_year", $release_year, PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $film = $this->request->fetch();

            // RETOUR DU RESULTAT
            return $film;
        } catch (PDOException $e) {
            // return $e->errorInfo[1];
            return false;
        }
    }

    //  AJOUTER UN FILM
    // -----------------
    public function add(Film $film)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "INSERT INTO
                    ppc_film
                 VALUES
                    (null,
                     :title,
                     :synopsis,
                     :release_year,
                     :duration,
                     :picture)"
            );
            $this->request->bindValue(":title", $film->getTitle(), PDO::PARAM_STR);
            $this->request->bindValue(":synopsis", $film->getSynopsis(), PDO::PARAM_STR);
            $this->request->bindValue(":release_year", $film->getRelease_year(), PDO::PARAM_INT);
            $this->request->bindValue(":duration", $film->getDuration(), PDO::PARAM_INT);
            $this->request->bindValue(":picture", $film->getPicture(), PDO::PARAM_STR);

            // EXECUTION DE LA REQUETE SQL ET RETOUR DE L'EXECUTION
            return $this->request->execute();
        } catch (PDOException $e) {
            // return $e->errorInfo[1];
            return false;
        }
    }

    //  MODIFIER UN FILM
    // -----------------
    public function update(Film $film)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "UPDATE
                    ppc_film
                 SET
                    title = :title,
                    synopsis = :synopsis,
                    release_year = :release_year,
                    duration = :duration,
                    picture = :picture
                 WHERE
                    id_film = :id_film"
            );
            $this->request->bindValue(":id_film", $film->getId_film(), PDO::PARAM_INT);
            $this->request->bindValue(":title", $film->getTitle(), PDO::PARAM_STR);
            $this->request->bindValue(":synopsis", $film->getSynopsis(), PDO::PARAM_STR);
            $this->request->bindValue(":release_year", $film->getRelease_year(), PDO::PARAM_INT);
            $this->request->bindValue(":duration", $film->getDuration(), PDO::PARAM_INT);
            $this->request->bindValue(":picture", $film->getPicture(), PDO::PARAM_STR);

            // EXECUTION DE LA REQUETE SQL ET RETOUR DE L'EXECUTION
            return $this->request->execute();
        } catch (PDOException $e) {
            // return $e->errorInfo[1];
            return false;
        }
    }
}
