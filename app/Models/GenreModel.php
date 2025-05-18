<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Entities\Genre;
use App\Core\DbConnect;


// -----------------------------
// CLASSE MODEL DE L'ENTITE GENRE
// -----------------------------
class GenreModel extends DbConnect
{
    //  TROUVE UN GENRE PAR SON ID
    // ---------------
    public function readByID($id_genre)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("SELECT * FROM ppc_genre WHERE id_genre = :id_genre");
            $this->request->bindValue(":id_genre", $id_genre, PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $genre = $this->request->fetch();

            // RETOUR DU RESULTAT
            return $genre;
        } catch (PDOException $e) {
            // return $e->errorInfo[1];
            return false;
        }
    }

    //  TROUVE TOUS LES GENRES ASSOCIES A UN FILM DONNE
    // ---------------
    public function getAllByFilmId($id_film)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "SELECT
                    g.name,
                    fg.id_film,
                    fg.id_genre
                 FROM
                    ppc_genre g
                 INNER JOIN
                    ppc_film_genre fg ON fg.id_genre = g.id_genre
                 WHERE
                    id_film = :id_film"
            );
            $this->request->bindValue(":id_film", $id_film, PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $genres = $this->request->fetchAll();

            // RETOUR DU RESULTAT
            return $genres;
        } catch (PDOException $e) {
            // return $e->errorInfo[1];
            return false;
        }
    }

    // AJOUTER UN GENRE
    // -----------------
    public function add(Genre $genre)
    {
        try {
            $this->request = $this->connection->prepare("INSERT INTO ppc_genre VALUES (null, :name)");
            $this->request->bindValue(":id_genre", $genre->getId_genre(), PDO::PARAM_INT);
            $this->request->bindValue(":name", $genre->getName(), PDO::PARAM_STR);
        } catch (PDOException $e) {
            // return $e->errorInfo[1];
            return false;
        }
    }

    // MODIFIER UN GENRE
    // -----------------
    public function update(Genre $genre)
    {
        try {
            $this->request = $this->connection->prepare(
                "UPDATE
                    ppc_genre
                 SET
                    name = :name
                 WHERE
                    id_genre = :id_genre"
            );
            $this->request->bindValue(":id_genre", $genre->getId_genre(), PDO::PARAM_INT);
            $this->request->bindValue(":name", $genre->getName(), PDO::PARAM_STR);
        } catch (PDOException $e) {
            // return $e->errorInfo[1];
            return false;
        }
    }

    // SUPPRIMER UN GENRE
    // -----------------
    public function delete($id_genre)
    {
        try {
            $this->request = $this->connection->prepare("DELETE FROM ppc_genre WHERE id_genre = :id_genre");
            $this->request->bindValue(":id_genre", $id_genre, PDO::PARAM_INT);
            return $this->request->execute();
        } catch (PDOException $e) {
            // return $e->errorInfo[1];
            return false;
        }
    }
}
