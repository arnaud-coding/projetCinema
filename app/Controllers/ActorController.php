<?php

namespace App\Controllers;

use App\Controllers\Controller as Controller;
use App\Core\CSRFTokenManager as CSRFTokenManager;
use App\Core\Validator as Validator;
use App\Models\ActorModel as ActorModel;
use App\Entities\Actor as Actor;
use App\Models\FilmModel as FilmModel;

class ActorController extends Controller
{

    // RENDU ACCEUIL ACTEURS
    // ----------------------
    public function home()
    {
        $actorModel = new ActorModel();
        $actors = $actorModel->readAll();

        // SCRIPTS JS
        $data = [
            "actors" => $actors
        ];

        // NAVIGATION VERS PAGE
        $this->render("actor/homeActor", $data);
    }

    // NAVIGUE VERS LA PAGE DETAILS FILM
    // ----------------------
    public function details()
    {
        // RECUPERE ID FILM DEPUIS URL
        $id_actor = isset($_GET["id_actor"]) ? $_GET["id_actor"] : null;
        if (!$id_actor) {
            $message = "Erreur systeme: Contactez l'administrateur du système";
            header("Location: index.php?controller=Actor&action=home&msgKO=" . urlencode($message));
            exit;
        }

        // RECUPERE DONNEES ACTEUR
        $actor = $this->getActorDetails($id_actor);

        // ENVOI DONNEES FILM ET SCRIPTS JS A LA VUE
        $data = [
            "scripts" => ["type='module' src='js/delete.js'"],
            "actor" => $actor
        ];
        // NAVIGATION VERS PAGE
        $this->render("actor/actorDetails", $data);
    }

    // RETOURNE DETAILS D'UN FILM POUR UN FILM DONNE
    // --------------------
    private function getActorDetails($id_actor)
    {
        if (!$id_actor) {
            // AUCUN ACTEUR FOURNI : REDIRECTION AVEC MESSAGE D'ERREUR
            $message = "Erreur inattendue";
            header("Location: index.php?controller=Actor&action=home&msgKO=" . urlencode($message));
            exit;
        }

        $actor = [];

        // RECUPERE L'ACTEUR EN BDD
        $actorModel = new ActorModel();
        $details = $actorModel->readByID($id_actor);
        if (!$details) {
            // RETOUR SI ACTEUR INEXISTANT
            return null;
        }
        $actor['details'] = $details;

        // RECUPERE LES FILMS DE L'ACTEUR EN BDD
        $filmModel = new FilmModel();
        $films = $filmModel->readAllByActorId($id_actor);
        $actor['films'] = $films;

        return $actor;
    }

    // NAVIGATION VERS FORMULAIRE D'AJOUT D'ACTEUR
    // --------------------
    public function addForm()
    {
        $token = CSRFTokenManager::generateCSRFToken();

        $data = [
            "scripts" => ["type='module' src='js/actorOrDirectorForm.js'"],
            "token" => $token,
            "entity" => "Actor",
            "controllerMethod" => "add"
        ];

        $this->render("actor/addActorForm", $data);
    }

    // AJOUTER UN ACTEUR
    // -----------------
    public function add()
    {
        // Verification de la methode de requête
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo json_encode([
                'success' => false,
                'message' => "Erreur : cette page doit être appelée via une requête POST"
            ]);
            exit();
        }

        // Récupération des données du formulaire
        $firstname = $_POST['firstname'] ?? null;
        $lastname = $_POST['lastname'] ?? null;
        $firstname = $_POST['firstname'] ?? null;
        $birth_date = $_POST['birth_date'] ?? null;
        $death_date = $_POST['death_date'] === "" ? null : $_POST['death_date'];
        $biography = $_POST['biography'] === "" ? null : $_POST['biography'];
        $nationality = $_POST['nationality'] === "" ? null : $_POST['nationality'];

        // Verification que l'acteur ne soit pas deja en BDD
        $actorModel = new ActorModel();
        $actor = $actorModel->readByFullName($firstname, $lastname);
        if ($actor) {
            echo json_encode([
                'success' => false,
                'message' => "L'acteur " . $firstname . " " . $lastname . " existe déja"
            ]);
            exit();
        }

        // GESTION DE L'UPLOAD
        if ($_FILES["picture"]["name"] !== "") {

            if (!Validator::validateFiles($_FILES, ["picture"])) {
                echo json_encode([
                    'success' => false,
                    'message' => "Erreur lors de l'upload de l'image : le fichier est peut être trop volumineux (poids max : 5 Mo)"
                ]);
                exit();
            }

            // Destination du fichier
            $uploadDir = 'img/img_actors/'; // S'assurer que ce dossier existe et est accessible en écriture
            $uploadName = $_FILES['picture']['name'];
            $uploadFile = $uploadDir . basename($uploadName);

            // Déplacer le fichier uploadé
            $success = move_uploaded_file($_FILES['picture']['tmp_name'], $uploadFile);
            if (!$success) {
                echo json_encode([
                    'success' => false,
                    'message' => "Erreur lors du déplacement de l'image vers sa destination"
                ]);
                exit();
            }
        } else {
            $uploadName = null;
        }

        // Hydratation de l'instance de l'entité Actor avec les données du formulaire
        $actor = new Actor();
        $actor->setFirstname($firstname);
        $actor->setLastname($lastname);
        $actor->setBirth_deate($birth_date);
        $actor->setDeath_date($death_date);
        $actor->setBiography($biography);
        $actor->setNationality($nationality);
        $actor->setPicture($uploadName);

        // Appel de la methode d'ajout d'acteur dans la BDD
        $success = $actorModel->add($actor);

        echo json_encode([
            'success' => $success,
            'message' => $success ? "L'acteur a été ajouté avec succès" : "Echec lors de l'ajout de l'acteur"
        ]);
        exit();
    }

    // NAVIGATION VERS FORMULAIRE DE MODIFICATION D'ACTEUR
    // --------------------
    public function updateForm()
    {
        $id_actor = isset($_GET["id_actor"]) ? $_GET["id_actor"] : "";
        $actorModel = new ActorModel();
        $actor = $actorModel->readByID($id_actor);
        if (!$actor) {
            $message = "Erreur inattendue : Contactez l'administrateur du système";
            header("Location: index.php?controller=Film&action=home&msgKO=" . urlencode($message));
        }

        $token = CSRFTokenManager::generateCSRFToken();

        $data = [
            "scripts" => ["type='module' src='js/actorOrDirectorForm.js'"],
            "actor" => $actor,
            "token" => $token,
            "entity" => "Actor",
            "controllerMethod" => "update"
        ];

        $this->render("actor/updateActorForm", $data);
    }

    // MODIFIER UN ACTEUR
    // -----------------
    public function update()
    {
        // Verification de la methode de requête
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo json_encode([
                'success' => false,
                'message' => "Erreur : cette page doit être appelée via une requête POST"
            ]);
            exit();
        }

        // Récupération des données du formulaire
        $id_actor = $_POST['id_actor'] ?? null;
        $firstname = $_POST['firstname'] ?? null;
        $lastname = $_POST['lastname'] ?? null;
        $firstname = $_POST['firstname'] ?? null;
        $birth_date = $_POST['birth_date'] ?? null;
        $death_date = $_POST['death_date'] === "" ? null : $_POST['death_date'];
        $biography = $_POST['biography'] === "" ? null : $_POST['biography'];
        $nationality = $_POST['nationality'] === "" ? null : $_POST['nationality'];

        // GESTION DE L'UPLOAD
        if ($_FILES["picture"]["name"] !== "") {

            if (!Validator::validateFiles($_FILES, ["picture"])) {
                echo json_encode([
                    'success' => false,
                    'message' => "Erreur lors de l'upload de l'image : le fichier est peut être trop volumineux (poids max : 5 Mo)"
                ]);
                exit();
            }

            // Destination du fichier
            $uploadDir = 'img/img_actors/'; // S'assurer que ce dossier existe et est accessible en écriture
            $uploadName = $_FILES['picture']['name'];
            $uploadFile = $uploadDir . basename($uploadName);

            // Déplacer le fichier uploadé
            $success = move_uploaded_file($_FILES['picture']['tmp_name'], $uploadFile);
            if (!$success) {
                echo json_encode([
                    'success' => false,
                    'message' => "Erreur lors du déplacement de l'image vers sa destination"
                ]);
                exit();
            }
        } else {
            $uploadName = null;
        }


        // Hydratation de l'instance de l'entité Actor avec les données du formulaire
        $actor = new Actor();
        $actor->setId_actor($id_actor);
        $actor->setFirstname($firstname);
        $actor->setLastname($lastname);
        $actor->setBirth_deate($birth_date);
        $actor->setDeath_date($death_date);
        $actor->setBiography($biography);
        $actor->setNationality($nationality);
        $actor->setPicture($uploadName);

        // Appel de la methode de modification d'acteur dans la BDD
        $actorModel = new ActorModel();
        $success = $actorModel->update($actor);

        echo json_encode([
            'success' => $success,
            'message' => $success ? "L'acteur a été mis à jour avec succès" : "Echec lors de la mise à jour de l'acteur"
        ]);
        exit();
    }

    // SUPPRIMER UN ACTEUR
    // -----------------
    public function delete()
    {
        $id_actor = isset($_GET["id_actor"]) ? $_GET["id_actor"] : null;

        // Récupération de l'acteur à supprimer
        $actorModel = new ActorModel();
        $actor = $actorModel->readByID($id_actor);
        if (!$actor) {
            // Acteur non trouvé en BDD
            echo json_encode([
                "success" => false,
                "message" => "Erreur inattendue : veuillez contacter l'administrateur du sysème"
            ]);
        }

        // Recherche si l'acteur est associé à des films
        $filmModel = new FilmModel();
        $films = $filmModel->readAllByActorId($id_actor);
        if ($films) {
            // formattage des titres pour affichange dans le message d'erreur
            $titles = "";
            $count = count($films);
            if ($count === 1) {
                $titles .= '"' . $films[0]->title . '" ; ';
            } else {
                for ($i = 0; $i < $count - 1; $i++) {
                    // affichage du 1er à l'avant dernier titre de film
                    $titles .= '"' . $films[$i]->title . '", ';
                }
                for ($i = $count - 1; $i < $count; $i++) {
                    // affichage du dernier film
                    $titles .= 'et "' . $films[$i]->title . '" ; ';
                }
            }

            // L'acteur est associé à des films : on demande à l'utilisateur d'aller le retirer du casting de ces films avant de le supprimer
            echo json_encode([
                "success" => false,
                "message" => "L'acteur est associé au(x) film(s) " . $titles . " veuillez le retirer du casting de ce(s) films avant de le supprimer"
            ]);
            exit();
        }

        // Suppression de l'acteur dans la BDD
        $success = $actorModel->delete($id_actor);
        echo json_encode([
            "success" => $success,
            "message" => $success ? "L'acteur a été supprimé avec succès" : "Echec de la suppression de l'acteur ; veuillez contacter l'administrateur du système"
        ]);
        exit();
    }

    // RECHERCHER UN ACTEUR (pour barre de recherche)
    // -----------------
    public function search()
    {
        $query = isset($_GET["query"]) ? trim($_GET["query"]) : "";

        $actorModel = new ActorModel();
        $actors = $actorModel->search($query);

        if (!$actors) {
            echo json_encode(['error' => 'Erreur de la base de données']);
        }

        echo json_encode($actors);
        exit();
    }
}
