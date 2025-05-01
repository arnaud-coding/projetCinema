<?php

namespace App\Entities;

// ---------------------------------------------------
// CLASSE DE L'ENTITE film_selection_comment DE LA BDD
// ---------------------------------------------------
class Film_selection_comment
{
    private $id_comment;
    private $content;
    private $publication_date;
    private $id_selection;
    private $id_user;

    // -------------------
    //  GETTERS ET SETTERS
    // -------------------

    public function getId_comment()
    {
        return $this->id_comment;
    }
    public function setId_comment($id_comment)
    {
        $this->id_comment = $id_comment;
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }
    public function setContent($content)
    {
        $this->content = $content;
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

    public function getId_selection()
    {
        return $this->id_selection;
    }
    public function setId_selection($id_selection)
    {
        $this->id_selection = $id_selection;
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
