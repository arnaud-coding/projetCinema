<?php

// DEFINITION DE L'ESPACE DE NOM
namespace App\Entities;

// ----------------------
// CLASSE ET BDD Director
// ----------------------
class Director
{
    private $id_director;
    private $firstname;
    private $lastname;
    private $birth_deate;
    private $death_date;
    private $picture;

    // -------------------
    //  GETTERS ET SETTERS
    // -------------------

    /**
     * Get the value of id_director
     */
    public function getId_director()
    {
        return $this->id_director;
    }

    /**
     * Set the value of id_director
     *
     * @return  self
     */
    public function setId_director($id_director)
    {
        $this->id_director = $id_director;

        return $this;
    }

    /**
     * Get the value of firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of birth_deate
     */
    public function getBirth_deate()
    {
        return $this->birth_deate;
    }

    /**
     * Set the value of birth_deate
     *
     * @return  self
     */
    public function setBirth_deate($birth_deate)
    {
        $this->birth_deate = $birth_deate;

        return $this;
    }

    /**
     * Get the value of death_date
     */
    public function getDeath_date()
    {
        return $this->death_date;
    }

    /**
     * Set the value of death_date
     *
     * @return  self
     */
    public function setDeath_date($death_date)
    {
        $this->death_date = $death_date;

        return $this;
    }

    /**
     * Get the value of picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @return  self
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }
}
