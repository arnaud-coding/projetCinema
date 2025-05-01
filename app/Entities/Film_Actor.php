<?php

namespace App\Entities;

// ---------------------------------------
// CLASSE DE L'ENTITE film_actor DE LA BDD
//
// (Table de jointure entre film et actor)
// ---------------------------------------
class Film_Actor
{
    private $id_film;
    private $id_actor;

    // -------------------
    //  GETTERS ET SETTERS
    // -------------------

    public function getId_film()
    {
        return $this->id_film;
    }
    public function setId_film($id_film)
    {
        $this->id_film = $id_film;
        return $this;
    }

    public function getId_actor()
    {
        return $this->id_actor;
    }
    public function setId_actor($id_actor)
    {
        $this->id_actor = $id_actor;
        return $this;
    }
}
