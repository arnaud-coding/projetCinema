<?php

namespace App\Models;

use App\Core\DbConnect;
use App\Entities\Review;
use PDO;
use PDOException;

class ReviewModel extends DbConnect
{
    //  LIRE UNE CRITIQUE PAR SON ID
    // -------------------
    public function readByID($id_review)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "SELECT
                    r.*,
                    u.pseudo
                 FROM
                    ppc_review r
                 INNER JOIN
                    ppc_user u ON u.id_user = r.id_user
                 WHERE
                    r.id_review = :id_review"
            );
            $this->request->bindValue(":id_review", $id_review, PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $review = $this->request->fetch();

            // RETOUR DU RESULTAT
            return $review;
        } catch (PDOException $e) {
            return $e->errorInfo[1];
        }
    }

    //  TROUVE SI UN UTILISATEUR A DEJA PUBLIE UNE CRITIQUE SUR UN FILM DONNE
    // -------------------
    public function readByUserIdAndFilmId($id_user, $id_film)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "SELECT
                    *
                 FROM
                    ppc_review
                 WHERE
                    id_film = :id_film AND id_user = :id_user"
            );
            $this->request->bindValue(":id_user", $id_user, PDO::PARAM_INT);
            $this->request->bindValue(":id_film", $id_film, PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $review = $this->request->fetch();

            // RETOUR DU RESULTAT
            return $review;
        } catch (PDOException $e) {
            return $e->errorInfo[1];
        }
    }

    //  LIRE LES CRITIQUES D'UN FILM
    // -------------------
    public function readAllByFilmId($id_film)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "SELECT
                    r.*,
                    u.pseudo
                 FROM
                    ppc_review r
                 INNER JOIN
                    ppc_user u ON u.id_user = r.id_user
                 WHERE
                    r.id_film = :id_film"
            );
            $this->request->bindValue(":id_film", $id_film, PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $reviews = $this->request->fetchAll();

            // RETOUR DU RESULTAT
            return $reviews;
        } catch (PDOException $e) {
            return $e->errorInfo[1];
        }
    }

    //  AJOUTER UN AVIS
    // -----------------
    public function add(Review $review)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare(
                "INSERT INTO
                    ppc_review
                 VALUES
                    (null,
                     :content,
                     :rating,
                     :publication_date,
                     :id_user,
                     :id_film)"
            );
            $this->request->bindValue(":content", $review->getContent(), PDO::PARAM_STR);
            $this->request->bindValue(":rating", $review->getRating(), PDO::PARAM_INT);
            $this->request->bindValue(":publication_date", $review->getPublication_date(), PDO::PARAM_STR);
            $this->request->bindValue(":id_user", $review->getId_user(), PDO::PARAM_INT);
            $this->request->bindValue(":id_film", $review->getId_film(), PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL ET RETOUR DE L'EXECUTION
            return $this->request->execute();
        } catch (PDOException $e) {
            // return $e->errorInfo[1];
            return false;
        }
    }

    //  SUPPRIMER UNE CRITIQUE
    // -------------------
    public function delete($id_review)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("DELETE FROM ppc_review WHERE id_review = :id_review");
            $this->request->bindValue(":id_review", $id_review, PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL ET DE L'EXECUTION
            return $this->request->execute();
        } catch (PDOException $e) {
            // return $e->errorInfo[1];
            return false;
        }
    }
}
