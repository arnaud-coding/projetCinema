<?php

// DEFINITION DE L'ESPACE DE NOM
namespace App\Models;

// IMPORT DE CLASSES
use App\Core\DbConnect;
use App\Entities\Client;
use PDO;
use PDOException;


// -------------------------------
// CLASSE MODEL DE L'ENTITE CLIENT
// -------------------------------
class ClientModel extends DbConnect
{
    // ---------------------------
    // METHODE POUR LIRE UN CLIENT
    // ---------------------------
    public function readByID(Client $readClient)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("SELECT * FROM eco_client WHERE id_client = :id_client");
            $this->request->bindValue(":id_client", $readClient->getId_client(), PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $client = $this->request->fetch();

            // RETOUR DU RESULTAT
            return $client;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            //die;
        }
    }

    // ---------------------------
    // METHODE POUR LIRE UN CLIENT
    // ---------------------------
    public function readByEmail(Client $readClient)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("SELECT * FROM eco_client WHERE email = :email");
            $this->request->bindValue(":email", $readClient->getEmail(), PDO::PARAM_STR);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $client = $this->request->fetch();

            // RETOUR DU RESULTAT
            return $client;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            //die;
        }
    }

    // ---------------------------
    // METHODE POUR LIRE UN CLIENT
    // ---------------------------
    public function readByToken(Client $readClient)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("SELECT * FROM eco_client WHERE token = :token");
            $this->request->bindValue(":token", $readClient->getToken(), PDO::PARAM_STR);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $client = $this->request->fetch();

            // RETOUR DU RESULTAT
            return $client;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            //die;
        }
    }

    // -----------------------------
    // METHODE POUR LIRE LES CLIENTS
    // -----------------------------
    public function readAll()
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("SELECT * FROM eco_client ORDER BY prenom ASC");

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE EN TABLEAU
            $clients = $this->request->fetchAll();

            // RETOUR DES RESULTATS
            return $clients;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            //die;
        }
    }

    // ----------------------------
    // METHODE POUR CREER UN CLIENT
    // ----------------------------
    public function create(Client $addClient)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("INSERT INTO eco_client (prenom, nom, email, mdp, adresse, cp, ville)
                                                         VALUES (:prenom, :nom, :email, :mdp, :adresse, :cp, :ville)");
            $this->request->bindValue(":prenom", $addClient->getPrenom(), PDO::PARAM_STR);
            $this->request->bindValue(":nom", $addClient->getNom(), PDO::PARAM_STR);
            $this->request->bindValue(":email", $addClient->getEmail(), PDO::PARAM_STR);
            $this->request->bindValue(":mdp", password_hash($addClient->getMdp(), PASSWORD_DEFAULT), PDO::PARAM_STR);
            $this->request->bindValue(":adresse", $addClient->getAdresse(), PDO::PARAM_STR);
            $this->request->bindValue(":cp", $addClient->getCp(), PDO::PARAM_INT);
            $this->request->bindValue(":ville", $addClient->getVille(), PDO::PARAM_STR);

            // EXECUTION DE LA REQUETE SQL ET RETOUR DE L'EXECUTION
            return $this->request->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                return "emailExistant";
            }
            //echo $e->getMessage();
            //die;
        }
    }
    /*
    // -------------------------------
    // METHODE POUR MODIFIER UN CLIENT
    // -------------------------------
    public function update(Client $majClient)
    {
        try {
            // CONSTRUCTION DE LA REQUETE EN FONCTION DU MDP
            $sql = "UPDATE eco_client SET
                prenom = :prenom,
                nom = :nom,
                email = :email,
                statut = :statut";

            if ($majClient->getMdp() != "") {
                $sql .= ", mdp = :mdp";
            }

            $sql .= " WHERE id_client = :id_client";

            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare($sql);
            $this->request->bindValue(":id_client", $majClient->getId_client(), PDO::PARAM_INT);
            $this->request->bindValue(":prenom", $majClient->getPrenom(), PDO::PARAM_STR);
            $this->request->bindValue(":nom", $majClient->getNom(), PDO::PARAM_STR);
            $this->request->bindValue(":email", $majClient->getEmail(), PDO::PARAM_STR);
            $this->request->bindValue(":statut", $majClient->getStatut(), PDO::PARAM_STR);

            if ($majClient->getMdp() != "") {
                $this->request->bindValue(":mdp", password_hash($majClient->getMdp(), PASSWORD_DEFAULT), PDO::PARAM_STR);
            }

            // EXECUTION DE LA REQUETE SQL
            $execution = $this->request->execute();

            // VERIFICATION DE L'UPDATE
            if ($execution && $this->request->rowCount() > 0) {
                return true;  // Suppression réussie
            } else {
                return false; // Aucun client trouvé ou erreur dans l'exécution
            }
        } catch (PDOException $e) {
            //echo $e->getMessage();
            //die;
        }
    }

    // ----------------------------
    // METHODE POUR MODIFIER UN MDP
    // ----------------------------
    public function updateToken(Client $majClient)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("UPDATE eco_client SET
                token = :token,
                token_expire = :token_expire
                WHERE email = :email");

            // PREPARATION DE LA REQUETE SQL
            $this->request->bindValue(":email", $majClient->getEmail(), PDO::PARAM_STR);
            $this->request->bindValue(":token", $majClient->getToken(), PDO::PARAM_STR);
            $this->request->bindValue(":token_expire", $majClient->getToken_expire(), PDO::PARAM_STR);

            // EXECUTION DE LA REQUETE SQL ET RETOUR DE L'EXECUTION
            return $this->request->execute();
        } catch (PDOException $e) {
            //echo $e->getMessage();
            //die;
        }
    }

    // ----------------------------
    // METHODE POUR MODIFIER UN MDP
    // ----------------------------
    public function updateMdp(Client $majClient)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("UPDATE eco_client SET
                mdp = :mdp,
                token = :token,
                token_expire = :token_expire
                WHERE email = :email");

            // PREPARATION DE LA REQUETE SQL
            $this->request->bindValue(":email", $majClient->getEmail(), PDO::PARAM_STR);
            $this->request->bindValue(":mdp", password_hash($majClient->getMdp(), PASSWORD_DEFAULT), PDO::PARAM_STR);
            $this->request->bindValue(":token", $majClient->getToken(), PDO::PARAM_STR);
            $this->request->bindValue(":token_expire", $majClient->getToken_expire(), PDO::PARAM_STR);

            // EXECUTION DE LA REQUETE SQL ET RETOUR DE L'EXECUTION
            return $this->request->execute();
        } catch (PDOException $e) {
            //echo $e->getMessage();
            //die;
        }
    }
        */
}
