<?php

namespace App\Controllers;

use App\Controllers\Controller as Controller;
use App\Core\CSRFTokenManager;
use App\Core\Validator;
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
            $message = "Erreur innatendue";
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
            "scripts" => ["type='module' src='js/addActorForm.js'"],
            "token" => $token
        ];

        $this->render("actor/addForm", $data);
    }

    // AJOUTER UN ACTEUR
    // -----------------
    public function add()
    {
        // Verification de la methode de requête
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $message = "Erreur : cette page doit être appelée via une requête POST";
            header("Location: index.php?controller=Film&action=home&msgKO=" . urlencode($message));
            exit();
        }

        // Récupération des données du formulaire
        $firstname = $_POST['firstname'] ?? null;
        $lastname = $_POST['lastname'] ?? null;
        $firstname = $_POST['firstname'] ?? null;
        $birth_date = $_POST['birth_date'] ?? null;
        $death_date = $_POST['death_date'] ?? null;
        $biography = $_POST['biography'] ?? null;
        $nationality = $_POST['nationality'] ?? null;

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
        if (!Validator::validateFiles($_FILES, ["picture"])) {
            echo json_encode([
                'success' => false,
                'message' => "Erreur lors de l'upload de l'image : peut être que l'image est trop volumineuse (poids max : 5 Mo)"
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
}
