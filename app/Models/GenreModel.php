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
}
