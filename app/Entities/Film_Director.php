<?php

namespace App\Entities;

// ---------------------------------------
// CLASSE DE L'ENTITE film_director DE LA BDD
//
// (Table de jointure entre film et director)
// ---------------------------------------
class Film_Director
{
    private $id_film;
    private $id_director;

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

    public function getId_director()
    {
        return $this->id_director;
    }
    public function setId_director($id_director)
    {
        $this->id_director = $id_director;
        return $this;
    }
}
