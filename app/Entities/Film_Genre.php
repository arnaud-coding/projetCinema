<?php

namespace App\Entities;

// ---------------------------------------
// CLASSE DE L'ENTITE film_genre DE LA BDD
//
// (Table de jointure entre film et genre)
// ---------------------------------------
class Film_Genre
{
    private $id_film;
    private $id_genre;

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


    public function getId_genre()
    {
        return $this->id_genre;
    }
    public function setId_genre($id_genre)
    {
        $this->id_genre = $id_genre;
        return $this;
    }
}
