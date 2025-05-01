<?php

namespace App\Controllers;

use App\Controllers\Controller as Controller;
use App\Entities\Selection as Selection;
use App\Models\SelectionModel as SelectionModel;
use Exception;

// ------------------------------------
// CLASSE CONTROLEUR DE LA PAGE SELECTIONS
// ------------------------------------
class SelectionController extends Controller
{

    // RENDU ACCEUIL SELECTIONS
    public function home()
    {
        $this->render("selection/homeSelection");
    }
}
