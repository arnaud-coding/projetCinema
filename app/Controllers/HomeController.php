<?php

namespace App\Controllers;

use App\Controllers\Controller as Controller;


// ---------------------------------
// CLASSE CONTROLEUR DE LA PAGE HOME
// ---------------------------------
class HomeController extends Controller
{

    // ----------------------
    //  AFFICHER LA PAGE HOME
    // ----------------------
    /**
     * affiche la page home
     */
    public function home()
    {
        $data = [
            "scripts" => ["type='module' src='js/home.js'"]
        ];

        $this->render("home/home", $data);
    }
}
