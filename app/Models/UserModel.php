<?php

// DEFINITION DE L'ESPACE DE NOM
namespace App\Models;

// IMPORT DE CLASSES
use PDO;
use PDOException;
use App\Entities\User;
use App\Core\DbConnect;


// -----------------------------
// CLASSE MODEL DE L'ENTITE USER
// -----------------------------
class UserModel extends DbConnect
{
    // -------------------------
    // METHODE POUR LIRE UN USER
    // -------------------------
    public function readByID(User $user)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("SELECT * FROM ppc_user WHERE id_user = :id_user");
            $this->request->bindValue(":id_user", $user->getId_user(), PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $user = $this->request->fetch();

            // RETOUR DU RESULTAT
            return $user;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // --------------------------------
    // METHODE POUR LIRE UN UTILISATEUR
    // --------------------------------
    public function readByEmail(User $user)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("SELECT * FROM ppc_user WHERE email = :email");
            $this->request->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $user = $this->request->fetch();

            // RETOUR DU RESULTAT
            return $user;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // ---------------------------------
    // METHODE POUR LIRE UN UTILISATTEUR
    // ---------------------------------
    public function readByToken(User $user)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("SELECT * FROM ppc_user WHERE token = :token");
            $this->request->bindValue(":token", $user->getToken(), PDO::PARAM_STR);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $user = $this->request->fetch();

            // RETOUR DU RESULTAT
            return $user;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // ----------------------------------
    // METHODE POUR LIRE LES UTILISATEURS
    // ----------------------------------
    public function readAll()
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("SELECT * FROM ppc_user ORDER BY lastname ASC");

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE EN TABLEAU
            $users = $this->request->fetchAll();

            // RETOUR DES RESULTATS
            return $users;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // ---------------------------------
    // METHODE POUR CREER UN UTILISATEUR
    // ---------------------------------
    public function create(User $user)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("INSERT INTO ppc_user (email, pseudo, password, type)
                                                         VALUES (:email, :pseudo, :password, :type)");
            $this->request->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
            $this->request->bindValue(":pseudo", $user->getPseudo(), PDO::PARAM_STR);
            $this->request->bindValue(":password", password_hash($user->getPassword(), PASSWORD_DEFAULT), PDO::PARAM_STR);
            $this->request->bindValue(":type", $user->getType(), PDO::PARAM_STR);

            // EXECUTION DE LA REQUETE SQL ET RETOUR DE L'EXECUTION
            return $this->request->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                return "emailExistant";
            }
            // die($e->getMessage());
        }
    }
    // ------------------------------------
    // METHODE POUR MODIFIER UN UTILISATEUR
    // ------------------------------------
    public function update(User $majUtilisateur)
    {
        try {
            // CONSTRUCTION DE LA REQUETE EN FONCTION DU PASSWORD
            $sql = "UPDATE com_utilisateur SET
                prenom = :prenom,
                nom = :nom,
                email = :email,
                statut = :statut";

            if ($majUtilisateur->getPassword() != "") {
                $sql .= ", password = :password";
            }

            $sql .= " WHERE id_utilisateur = :id_utilisateur";

            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare($sql);
            $this->request->bindValue(":id_utilisateur", $majUtilisateur->getId_utilisateur(), PDO::PARAM_INT);
            $this->request->bindValue(":prenom", $majUtilisateur->getPrenom(), PDO::PARAM_STR);
            $this->request->bindValue(":nom", $majUtilisateur->getNom(), PDO::PARAM_STR);
            $this->request->bindValue(":email", $majUtilisateur->getEmail(), PDO::PARAM_STR);
            $this->request->bindValue(":statut", $majUtilisateur->getStatut(), PDO::PARAM_STR);

            if ($majUtilisateur->getPassword() != "") {
                $this->request->bindValue(":password", password_hash($majUtilisateur->getPassword(), PASSWORD_DEFAULT), PDO::PARAM_STR);
            }

            // EXECUTION DE LA REQUETE SQL
            $execution = $this->request->execute();

            // VERIFICATION DE L'UPDATE
            if ($execution && $this->request->rowCount() > 0) {
                return true;  // MAJ réussie
            } else {
                return false; // Aucun utilisateur trouvé ou erreur dans l'exécution
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }

    // ----------------------------
    // METHODE POUR MODIFIER UN MDP
    // ----------------------------
    public function updateToken(User $majUser)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("UPDATE ppc_user SET
                token = :token,
                token_expire = :token_expire
                WHERE email = :email");

            // PREPARATION DE LA REQUETE SQL
            $this->request->bindValue(":email", $majUser->getEmail(), PDO::PARAM_STR);
            $this->request->bindValue(":token", $majUser->getToken(), PDO::PARAM_STR);
            $this->request->bindValue(":token_expire", $majUser->getToken_expire(), PDO::PARAM_STR);

            // EXECUTION DE LA REQUETE SQL ET RETOUR DE L'EXECUTION
            return $this->request->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // ----------------------------
    // METHODE POUR MODIFIER UN MDP
    // ----------------------------
    public function updatePassword(User $majUser)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("UPDATE ppc_user SET
                password = :password,
                token = :token,
                token_expire = :token_expire
                WHERE email = :email");

            // PREPARATION DE LA REQUETE SQL
            $this->request->bindValue(":email", $majUser->getEmail(), PDO::PARAM_STR);
            $this->request->bindValue(":password", password_hash($majUser->getPassword(), PASSWORD_DEFAULT), PDO::PARAM_STR);
            $this->request->bindValue(":token", $majUser->getToken(), PDO::PARAM_STR);
            $this->request->bindValue(":token_expire", $majUser->getToken_expire(), PDO::PARAM_STR);

            // EXECUTION DE LA REQUETE SQL ET RETOUR DE L'EXECUTION
            return $this->request->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
