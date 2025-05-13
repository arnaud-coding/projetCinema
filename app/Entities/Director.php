<?php

namespace App\Entities;

// -------------------------------------
// CLASSE DE L'ENTITE director DE LA BDD
// -------------------------------------
class Director
{
    private $id_director;
    private $firstname;
    private $lastname;
    private $birth_deate;
    private $death_date;
    private $biography;
    private $nationality;
    private $picture;

    // -------------------
    //  GETTERS ET SETTERS
    // -------------------

    public function getId_director()
    {
        return $this->id_director;
    }
    public function setId_director($id_director)
    {
        $this->id_director = $id_director;
        return $this;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname()
    {
        return $this->lastname;
    }
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getBirth_deate()
    {
        return $this->birth_deate;
    }
    public function setBirth_deate($birth_deate)
    {
        $this->birth_deate = $birth_deate;
        return $this;
    }

    public function getDeath_date()
    {
        return $this->death_date;
    }
    public function setDeath_date($death_date)
    {
        $this->death_date = $death_date;
        return $this;
    }

    public function getBiography()
    {
        return $this->biography;
    }
    public function setBiography($biography): self
    {
        $this->biography = $biography;
        return $this;
    }

    public function getNationality()
    {
        return $this->nationality;
    }
    public function setNationality($nationality): self
    {
        $this->nationality = $nationality;
        return $this;
    }

    public function getPicture()
    {
        return $this->picture;
    }
    public function setPicture($picture)
    {
        $this->picture = $picture;
        return $this;
    }
}
