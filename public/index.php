<?php

//AFFICHAGE DES ERREURS PHP
error_reporting(E_ALL);
ini_set("display_errors", 1);

// // Assurez-vous que le cookie de session est sécurisé
// session_set_cookie_params([
//     'lifetime' => 0,      // La session expire à la fermeture du navigateur
//     'path' => '/',        // Path global pour le cookie de session
//     'domain' => 'votre-domaine.com', // Spécifiez votre domaine
//     'secure' => true,      // Assurez-vous d'utiliser HTTPS
//     'httponly' => true,    // Empêche l'accès via JavaScript
//     'samesite' => 'Strict' // Empêche l'envoi du cookie avec des requêtes cross-site
// ]);

// INITIALISATION DE LA SESSION
session_start();

// VERIFICATION DE LA CONNEXION DE L'UTILISATEUR
if (isset($_COOKIE["id_utilisateur"])) {
    if (!isset($_SESSION["user"])) {
        $_SESSION["user"] = [
            "id_utilisateur" => $_COOKIE["id_utilisateur"],
            "username" => $_COOKIE["username"],
            "statut" => $_COOKIE["statut"]
        ];
    }
}

// INCLUSION DE L'AUTOLOADER
require_once '../app/Autoloader.php';

// IMPORT DE CLASSES
use App\Autoloader;
use App\Core\Router;

// CHARGEMENT DE L'AUTOLOADER
App\Autoloader::register();

// INSTANCIATION D'UN OBJET "routeur"
$routeur = new Router();

// UTILISATION DE LA METHODE "routes" DE L'OBJET "routeur"
$routeur->routes();