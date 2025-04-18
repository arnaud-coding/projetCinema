<?php

// DEFINITION DE L'ESPACE DE NOM
namespace App\Entities;

// -------------------
// CLASSE ET BDD Genre
// -------------------
class Genre
{
    private $id_genre;
    private $name;

    // -------------------
    //  GETTERS ET SETTERS
    // -------------------

    /**
     * Get the value of id_genre
     */
    public function getId_genre()
    {
        return $this->id_genre;
    }

    /**
     * Set the value of id_genre
     *
     * @return  self
     */
    public function setId_genre($id_genre)
    {
        $this->id_genre = $id_genre;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
