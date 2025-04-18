<?php

// DEFINITION DE L'ESPACE DE NOM
namespace App\Controllers;

// IMPORT DE CLASSES
use App\Controllers\Controller as Controller;


// ---------------------------------
// CLASSE CONTROLEUR DE LA PAGE HOME
// ---------------------------------
class HomeController extends Controller
{

    // ---------------------------------
    // METHODE POUR AFFICHER LA PAGE HOME //
    // ---------------------------------
    public function home()
    {
        $this->render("home/home");
    }
}
