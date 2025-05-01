<?php

namespace App\Controllers;

use App\Controllers\Controller as Controller;
use App\Entities\Actor as Actor;
use App\Models\ActorModel as ActorModel;
use Exception;

// ------------------------------------
// CLASSE CONTROLEUR DE LA PAGE ACTEURS
// ------------------------------------
class ActorController extends Controller
{

    // RENDU ACCEUIL ACTEURS
    public function home()
    {
        $this->render("actor/homeActor");
    }
}
