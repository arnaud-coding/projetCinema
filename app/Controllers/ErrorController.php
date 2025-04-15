<?php

// DEFINITION DE L'ESPACE DE NOM
namespace App\Controllers;

// IMPORT DE CLASSES
use App\Controllers\Controller as Controller;


/////////////////////////////
// CLASSE CONTROLEUR ERROR //
/////////////////////////////
class ErrorController extends Controller
{
    ////////////////////////////////////////
    // METHODE POUR AFFICHER L'ERREUR 404 //
    ////////////////////////////////////////
    public function error404()
    {
        $this->render("errors/404");
    }
}