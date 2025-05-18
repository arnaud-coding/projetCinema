<?php

namespace App\Controllers;

use App\Controllers\Controller as Controller;
use App\Core\CSRFTokenManager as CSRFTokenManager;
use App\Core\Validator as Validator;
use App\Models\FilmModel as FilmModel;
use App\Models\DirectorModel as DirectorModel;
use App\Entities\Director as Director;

class DirectorController extends Controller
{

    // RENDU ACCEUIL REALISATEURS
    public function home()
    {
        $directorModel = new DirectorModel();
        $directors = $directorModel->readAll();

        // SCRIPTS JS
        $data = [
            "directors" => $directors
        ];

        $this->render("director/homeDirector", $data);
    }

    // NAVIGUE VERS LA PAGE DETAILS REALISATEUR
    // ----------------------
    public function details()
    {
        // RECUPERE ID FILM DEPUIS URL
        $id_director = isset($_GET["id_director"]) ? $_GET["id_director"] : null;
        if (!$id_director) {
            $message = "Erreur systeme: Contactez l'administrateur du système";
            header("Location: index.php?controller=Director&action=home&msgKO=" . urlencode($message));
            exit;
        }

        // RECUPERE DONNEES REALISATEUR
        $director = $this->getDirectorDetails($id_director);

        // ENVOI DONNEES FILM ET SCRIPTS JS A LA VUE
        $data = [
            "director" => $director
        ];
        // NAVIGATION VERS PAGE
        $this->render("director/directorDetails", $data);
    }

    // RETOURNE DETAILS D'UN FILM POUR UN REALISATEUR DONNE
    // --------------------
    private function getDirectorDetails($id_director)
    {
        if (!$id_director) {
            // AUCUN ACTEUR FOURNI : REDIRECTION AVEC MESSAGE D'ERREUR
            $message = "Erreur inattendue";
            header("Location: index.php?controller=Director&action=home&msgKO=" . urlencode($message));
            exit;
        }

        $director = [];

        // RECUPERE LE REALISATEUR EN BDD
        $directorModel = new DirectorModel();
        $details = $directorModel->readByID($id_director);
        if (!$details) {
            // RETOUR SI ACTEUR INEXISTANT
            return null;
        }
        $director['details'] = $details;

        // RECUPERE LES FILMS DU REALISATEUR EN BDD
        $filmModel = new FilmModel();
        $films = $filmModel->readAllByDirectorId($id_director);
        $director['films'] = $films;

        return $director;
    }

    // NAVIGATION VERS FORMULAIRE D'AJOUT DE REALISATEUR
    // --------------------
    public function addForm()
    {
        $token = CSRFTokenManager::generateCSRFToken();

        $data = [
            "scripts" => ["type='module' src='js/actorOrDirectorForm.js'"],
            "token" => $token,
            "entity" => "Director",
            "controllerMethod" => "add"
        ];

        $this->render("director/addDirectorForm", $data);
    }

    // AJOUTER UN REALISATEUR
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

        // Verification que le réalisateur ne soit pas deja en BDD
        $directorModel = new DirectorModel();
        $director = $directorModel->readByFullName($firstname, $lastname);
        if ($director) {
            echo json_encode([
                'success' => false,
                'message' => "Le réalisateur " . $firstname . " " . $lastname . " existe déja"
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
            $uploadDir = 'img/img_directors/'; // S'assurer que ce dossier existe et est accessible en écriture
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

        // Hydratation de l'instance de l'entité Director avec les données du formulaire
        $director = new Director();
        $director->setFirstname($firstname);
        $director->setLastname($lastname);
        $director->setBirth_deate($birth_date);
        $director->setDeath_date($death_date);
        $director->setBiography($biography);
        $director->setNationality($nationality);
        $director->setPicture($uploadName);

        // Appel de la methode d'ajout de réalisateur dans la BDD
        $success = $directorModel->add($director);

        echo json_encode([
            'success' => $success,
            'message' => $success ? "Le réalisateur a été ajouté avec succès" : "Echec lors de l'ajout du réalisateur"
        ]);
        exit();
    }

    // NAVIGATION VERS FORMULAIRE DE MODIFICATION DE REALISATEUR
    // --------------------
    public function updateForm()
    {
        $id_director = isset($_GET["id_director"]) ? $_GET["id_director"] : "";
        $directorModel = new DirectorModel();
        $director = $directorModel->readByID($id_director);
        if (!$director) {
            $message = "Erreur inattendue : Contactez l'administrateur du système";
            header("Location: index.php?controller=Film&action=home&msgKO=" . urlencode($message));
        }

        $token = CSRFTokenManager::generateCSRFToken();

        $data = [
            "scripts" => ["type='module' src='js/actorOrDirectorForm.js'"],
            "director" => $director,
            "token" => $token,
            "entity" => "Director",
            "controllerMethod" => "update"
        ];

        $this->render("director/updateDirectorForm", $data);
    }

    // MODIFIER UN REALISATEUR
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
        $id_director = $_POST['id_director'] ?? null;
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
            $uploadDir = 'img/img_directors/'; // S'assurer que ce dossier existe et est accessible en écriture
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


        // Hydratation de l'instance de l'entité Director avec les données du formulaire
        $director = new Director();
        $director->setId_director($id_director);
        $director->setFirstname($firstname);
        $director->setLastname($lastname);
        $director->setBirth_deate($birth_date);
        $director->setDeath_date($death_date);
        $director->setBiography($biography);
        $director->setNationality($nationality);
        $director->setPicture($uploadName);

        // Appel de la methode de modification de réalisateur dans la BDD
        $directorModel = new DirectorModel();
        $success = $directorModel->update($director);

        echo json_encode([
            'success' => $success,
            'message' => $success ? "Le réalisateur a été mis à jour avec succès" : "Echec lors de la mise à jour du réalisateur"
        ]);
        exit();
    }
}
