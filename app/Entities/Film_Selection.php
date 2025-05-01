<?php

namespace App\Entities;

// -------------------------------------------
// CLASSE DE L'ENTITE film_selection DE LA BDD
//
// (Table de jointure entre film et selection)
// -------------------------------------------
class Film_Selection
{
    private $id_film;
    private $id_selection;

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

    public function getId_selection()
    {
        return $this->id_selection;
    }
    public function setId_selection($id_selection)
    {
        $this->id_selection = $id_selection;
        return $this;
    }
}
