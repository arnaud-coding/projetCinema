<?php

namespace App\Entities;

// ----------------------------------
// CLASSE DE L'ENTITE genre DE LA BDD
// ----------------------------------
class Genre
{
    private $id_genre;
    private $name;

    // -------------------
    //  GETTERS ET SETTERS
    // -------------------

    public function getId_genre()
    {
        return $this->id_genre;
    }
    public function setId_genre($id_genre)
    {
        $this->id_genre = $id_genre;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
