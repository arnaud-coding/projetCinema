<?php

namespace App\Controllers;

use App\Controllers\Controller as Controller;
use App\Entities\Director as Director;
use App\Models\DirectorModel as DirectorModel;
use Exception;

// ------------------------------------
// CLASSE CONTROLEUR DE LA PAGE REALISATEURS
// ------------------------------------
class DirectorController extends Controller
{

    // RENDU ACCEUIL REALISATEURS
    public function home()
    {
        $this->render("director/homeDirector");
    }
}
