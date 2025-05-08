<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Entities\Actor;
use App\Entities\Film;
use App\Core\DbConnect;


// -----------------------------
// CLASSE MODEL DE L'ENTITE ACTOR
// -----------------------------
class ActorModel extends DbConnect
{
    public function readByID($id_actor)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "SELECT
                    CONCAT(firstname, ' ', lastname) AS name,
                    birth_date,
                    death_date,
                    biography,
                    nationality,
                    picture
                 FROM
                     ppc_actor
                 WHERE
                     id_actor = :id_actor"
            );
            $this->request->bindValue(":id_actor", $id_actor, PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $actor = $this->request->fetch();

            // RETOUR DU RESULTAT
            return $actor;
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
                    CONCAT(a.firstname, ' ', a.lastname) AS name,
                    a.picture,
                    fa.id_film,
                    fa.id_actor
                 FROM
                    ppc_actor a
                 INNER JOIN
                    ppc_film_actor fa ON fa.id_actor = a.id_actor
                 WHERE
                    id_film = :id_film"
            );
            $this->request->bindValue(":id_film", $id_film, PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $actors = $this->request->fetchAll();

            // RETOUR DU RESULTAT
            return $actors;
        } catch (PDOException $e) {
            return $e->errorInfo[1];
        }
    }
}
