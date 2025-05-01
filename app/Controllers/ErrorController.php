<?php

namespace App\Controllers;

// IMPORT DE CLASSES
use App\Controllers\Controller as Controller;


// -----------------------
// CLASSE CONTROLEUR ERROR
// -----------------------
class ErrorController extends Controller
{
    // -----------------------
    //  AFFICHER L'ERREUR 404
    // -----------------------
    public function error404()
    {
        $this->render("errors/404");
    }
}
