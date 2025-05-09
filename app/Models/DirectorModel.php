<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Entities\Director;
use App\Entities\Film;
use App\Core\DbConnect;


// -----------------------------
// CLASSE MODEL DE L'ENTITE DIRECTOR
// -----------------------------
class DirectorModel extends DbConnect
{
    // ---------------
    //  LIRE UN DIRECTOR PAR SON ID
    // ---------------
    public function readByID($id_director)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "SELECT
                    id_director,
                    CONCAT(firstname, ' ', lastname) AS name,
                    birth_date,
                    death_date,
                    biography,
                    nationality,
                    picture
                FROM
                    ppc_director
                WHERE
                    id_director = :id_director"
            );
            $this->request->bindValue(":id_director", $id_director, PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $director = $this->request->fetch();

            // RETOUR DU RESULTAT
            return $director;
        } catch (PDOException $e) {
            return $e->errorInfo[1];
        }
    }

    public function readAll()
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "SELECT
                    id_director,
                    CONCAT(firstname, ' ', lastname) AS name,
                    picture
                 FROM ppc_director"
            );

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $directors = $this->request->fetchAll();

            // RETOUR DU RESULTAT
            return $directors;
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
                    CONCAT(d.firstname, ' ', d.lastname) AS name,
                    d.picture,
                    fd.id_film,
                    fd.id_director
                 FROM
                    ppc_director d
                 INNER JOIN
                    ppc_film_director fd ON fd.id_director = d.id_director
                 WHERE
                    id_film = :id_film"
            );
            $this->request->bindValue(":id_film", $id_film, PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $directors = $this->request->fetchAll();

            // RETOUR DU RESULTAT
            return $directors;
        } catch (PDOException $e) {
            return $e->errorInfo[1];
        }
    }
}
