<?php

//AFFICHAGE DES ERREURS PHP
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Assurez-vous que le cookie de session est sécurisé
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

// TODO
// VERIFICATION DE LA CONNEXION DE L'UTILISATEUR
// if (isset($_COOKIE["id_user"])) {
//     if (!isset($_SESSION["user"])) {
//         $_SESSION["user"] = [
//             "id_user" => $_COOKIE["id_user"],
//             "user_name" => $_COOKIE["user_name"],
//             "user_type" => $_COOKIE["user_type"]
//         ];
//     }
// }

// INCLUSION DE L'AUTOLOADER
require_once '../app/Autoloader.php';

use App\Autoloader;
use App\Core\Router;

// CHARGEMENT DE L'AUTOLOADER
// App\Autoloader::register();
$autoloader = new Autoloader();
$autoloader->register();

// INSTANCIATION D'UN OBJET "routeur" ET UTILISATION DE SA METHODE routes()
// App\Core\Router::routes();
$routeur = new Router();
$routeur->routes();
