<?php

namespace App\Controllers;

use App\Controllers\Controller as Controller;
use App\Entities\Film as Film;
use App\Models\FilmModel as FilmModel;
use Exception;

// ----------------------------------
// CLASSE CONTROLEUR DE LA PAGE FILMS
// ----------------------------------
class FilmController extends Controller
{

    // RENDU ACCEUIL FILMS
    public function home()
    {
        $this->render("film/homeFilm");
    }
}
