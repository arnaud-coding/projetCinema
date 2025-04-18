<?php

// DEFINITION DE L'ESPACE DE NOM
namespace App\Entities;

// ---------------------------------
// CLASSE ET BDD User_film_selection
// ---------------------------------
class User_film_selection
{
    private $id_selection;
    private $title;
    private $publication_date;
    private $id_user;

    // -------------------
    //  GETTERS ET SETTERS
    // -------------------

    /**
     * Get the value of id_selection
     */
    public function getId_selection()
    {
        return $this->id_selection;
    }

    /**
     * Set the value of id_selection
     *
     * @return  self
     */
    public function setId_selection($id_selection)
    {
        $this->id_selection = $id_selection;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of publication_date
     */
    public function getPublication_date()
    {
        return $this->publication_date;
    }

    /**
     * Set the value of publication_date
     *
     * @return  self
     */
    public function setPublication_date($publication_date)
    {
        $this->publication_date = $publication_date;

        return $this;
    }

    /**
     * Get the value of id_user
     */
    public function getId_user()
    {
        return $this->id_user;
    }

    /**
     * Set the value of id_user
     *
     * @return  self
     */
    public function setId_user($id_user)
    {
        $this->id_user = $id_user;

        return $this;
    }
}
