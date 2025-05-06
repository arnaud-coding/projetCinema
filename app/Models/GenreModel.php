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
    // ---------------
    //  LIRE UN GENRE
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
            return $e->errorInfo[1];
        }
    }

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
            return $e->errorInfo[1];
        }
    }
}
