<?php

// DEFINITION DE L'ESPACE DE NOM
namespace App;


///////////////////////
// CLASSE AUTOLOADER //
///////////////////////
class Autoloader
{
    //////////////////////
    // METHODE REGISTER //
    //////////////////////
    static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']); // __CLASS__ renvoie le nom de la classe courante
    }

    //////////////////
    // METHODE LOAD //
    //////////////////
    static function autoload($class)
    {
        $class = str_replace(__NAMESPACE__ . '\\', '', $class); // On retire le namespace App, on obtient Controllers\HomeController
        $class = str_replace('\\', '/', $class); // On remplace les \ par des /, on obtient Controllers/HomeController
        // require __DIR__ . '/' . $class . '.php';
        if (file_exists(__DIR__ . '/' . $class . '.php')) { // On vérifie si le fichier app/Controllers/HomeController.php existe
            require __DIR__ . '/' . $class . '.php'; // On inclut le fichier
        }
    }
}