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

    // ---------------
    //  LIRE DES FILMS ET TOUTES DONNEES RELIES A CHAQUE FILM, PAR GENRE DE FILM
    // ---------------
    public function readAllInfosByGenre($id_genre) // PAS UTILISE
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "SELECT
                    f.*,
                    GROUP_CONCAT(DISTINCT g.name ORDER BY g.name SEPARATOR ', ') AS genres,
                    GROUP_CONCAT(DISTINCT CONCAT(d.firstname, ' ', d.lastname) ORDER BY d.lastname, d.firstname SEPARATOR ', ') AS directors,
                    GROUP_CONCAT(DISTINCT CONCAT(a.firstname, ' ', a.lastname) ORDER BY a.lastname, a.firstname SEPARATOR ', ') AS actors
                FROM ppc_film f
                LEFT JOIN ppc_film_genre fg ON f.id_film = fg.id_film
                LEFT JOIN ppc_genre g ON fg.id_genre = g.id_genre
                LEFT JOIN ppc_film_director fd ON f.id_film = fd.id_film
                LEFT JOIN ppc_director d ON fd.id_director = d.id_director
                LEFT JOIN ppc_film_actor fa ON f.id_film = fa.id_film
                LEFT JOIN ppc_actor a ON fa.id_actor = a.id_actor
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
}
