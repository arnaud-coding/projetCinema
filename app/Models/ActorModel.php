<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Entities\Actor;
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

    public function readAll()
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "SELECT
                    id_actor,
                    CONCAT(firstname, ' ', lastname) AS name,
                    picture
                 FROM ppc_actor"
            );

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

    //  AJOUTER UN ACTEUR
    // -----------------
    public function add(Actor $actor)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "INSERT INTO
                    ppc_actor
                 VALUES
                    (null,
                     :firstame,
                     :lastname,
                     :birth_date,
                     :death_date,
                     :biography,
                     :nationality,
                     :picture)"
            );
            $this->request->bindValue(":firstame", $actor->getFirstname(), PDO::PARAM_STR);
            $this->request->bindValue(":lastname", $actor->getLastname(), PDO::PARAM_STR);
            $this->request->bindValue(":birth_date", $actor->getBirth_deate(), PDO::PARAM_STR);
            $this->request->bindValue(":death_date", $actor->getDeath_date(), PDO::PARAM_STR);
            $this->request->bindValue(":biography", $actor->getBiography(), PDO::PARAM_STR);
            $this->request->bindValue(":nationality", $actor->getNationality(), PDO::PARAM_STR);
            $this->request->bindValue(":picture", $actor->getPicture(), PDO::PARAM_STR);

            // EXECUTION DE LA REQUETE SQL ET RETOUR DE L'EXECUTION
            return $this->request->execute();
        } catch (PDOException $e) {
            // return $e->errorInfo[1];
            return false;
        }
    }
}
