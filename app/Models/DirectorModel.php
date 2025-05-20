<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Entities\Director;
use App\Core\DbConnect;


// -----------------------------
// CLASSE MODEL DE L'ENTITE DIRECTOR
// -----------------------------
class DirectorModel extends DbConnect
{
    //  TROUVE UN REALISATEUR PAR SON NOM COMPLET
    // -----------------
    public function readByFullName($firstname, $lastname)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "SELECT
                    *
                 FROM
                     ppc_director
                 WHERE
                     LOWER(firstname) = LOWER(:firstname) AND LOWER(lastname) = LOWER(:lastname)"
            );
            $this->request->bindValue(":firstname", $firstname, PDO::PARAM_STR);
            $this->request->bindValue(":lastname", $lastname, PDO::PARAM_STR);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $director = $this->request->fetchAll();

            // RETOUR DU RESULTAT
            return $director;
        } catch (PDOException $e) {
            // return $e->errorInfo[1];
            return false;
        }
    }

    //  TROUVE UN REALISATEUR PA SON ID
    // -----------------
    public function readByID($id_director)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "SELECT
                    *,
                    CONCAT(firstname, ' ', lastname) AS name
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

    //  TORUVE TOUS LES REALISATEURS
    // -----------------
    public function readAll()
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "SELECT
                    id_director,
                    CONCAT(firstname, ' ', lastname) AS name,
                    picture
                 FROM ppc_director
                 ORDER BY lastname"
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


    //  TOUVE TOUS LES REALISATEUR ASSOCIES A UN FILM DONNE
    // -----------------
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

    //  AJOUTER UN REALISATEUR
    // -----------------
    public function add(Director $director)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "INSERT INTO
                    ppc_director
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
            $this->request->bindValue(":firstame", $director->getFirstname(), PDO::PARAM_STR);
            $this->request->bindValue(":lastname", $director->getLastname(), PDO::PARAM_STR);
            $this->request->bindValue(":birth_date", $director->getBirth_deate(), PDO::PARAM_STR);
            $this->request->bindValue(":death_date", $director->getDeath_date(), PDO::PARAM_STR);
            $this->request->bindValue(":biography", $director->getBiography(), PDO::PARAM_STR);
            $this->request->bindValue(":nationality", $director->getNationality(), PDO::PARAM_STR);
            $this->request->bindValue(":picture", $director->getPicture(), PDO::PARAM_STR);

            // EXECUTION DE LA REQUETE SQL ET RETOUR DE L'EXECUTION
            return $this->request->execute();
        } catch (PDOException $e) {
            // return $e->errorInfo[1];
            return false;
        }
    }

    //  METTRE A JOUR UN REALISATEUR
    // -----------------
    public function update(Director $director)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "UPDATE
                    ppc_director
                 SET
                    firstname = :firstame,
                    lastname = :lastname,
                    birth_date = :birth_date,
                    death_date = :death_date,
                    biography = :biography,
                    nationality = :nationality,
                    picture = :picture
                WHERE
                    id_director = :id_director"
            );
            $this->request->bindValue(":id_director", $director->getId_director(), PDO::PARAM_INT);
            $this->request->bindValue(":firstame", $director->getFirstname(), PDO::PARAM_STR);
            $this->request->bindValue(":lastname", $director->getLastname(), PDO::PARAM_STR);
            $this->request->bindValue(":birth_date", $director->getBirth_deate(), PDO::PARAM_STR);
            $this->request->bindValue(":death_date", $director->getDeath_date(), PDO::PARAM_STR);
            $this->request->bindValue(":biography", $director->getBiography(), PDO::PARAM_STR);
            $this->request->bindValue(":nationality", $director->getNationality(), PDO::PARAM_STR);
            $this->request->bindValue(":picture", $director->getPicture(), PDO::PARAM_STR);

            // EXECUTION DE LA REQUETE SQL ET RETOUR DE L'EXECUTION
            return $this->request->execute();
        } catch (PDOException $e) {
            // return $e->errorInfo[1];
            return false;
        }
    }

    // SUPPRIMER UN REALISATEUR
    // -----------------
    public function delete($id_director)
    {
        try {
            $this->request = $this->connection->prepare("DELETE FROM ppc_director WHERE id_director = :id_director");
            $this->request->bindValue(":id_director", $id_director, PDO::PARAM_INT);
            return $this->request->execute();
        } catch (PDOException $e) {
            // return $e->errorInfo[1];
            return false;
        }
    }
}
