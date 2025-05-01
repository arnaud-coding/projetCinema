<?php

namespace App\Entities;

// ---------------------------------
// CLASSE DE L'ENTITE User_film_selection
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

    public function getId_selection()
    {
        return $this->id_selection;
    }
    public function setId_selection($id_selection)
    {
        $this->id_selection = $id_selection;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getPublication_date()
    {
        return $this->publication_date;
    }
    public function setPublication_date($publication_date)
    {
        $this->publication_date = $publication_date;
        return $this;
    }

    public function getId_user()
    {
        return $this->id_user;
    }
    public function setId_user($id_user)
    {
        $this->id_user = $id_user;
        return $this;
    }
}
