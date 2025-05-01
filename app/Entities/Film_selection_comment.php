<?php

namespace App\Entities;

// ------------------------------------
// CLASSE ET BDD Film_selection_comment
// ------------------------------------
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

    /**
     * Get the value of id_comment
     */
    public function getId_comment()
    {
        return $this->id_comment;
    }

    /**
     * Set the value of id_comment
     *
     * @return  self
     */
    public function setId_comment($id_comment)
    {
        $this->id_comment = $id_comment;

        return $this;
    }

    /**
     * Get the value of content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */
    public function setContent($content)
    {
        $this->content = $content;

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
