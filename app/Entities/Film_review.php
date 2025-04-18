<?php

// DEFINITION DE L'ESPACE DE NOM
namespace App\Entities;

// -------------------------
// CLASSE ET BDD Film_review
// -------------------------
class Film_review
{
    private $id_review;
    private $content;
    private $rating;
    private $publication_date;
    private $id_user;
    private $id_film;

    // -------------------
    //  GETTERS ET SETTERS
    // -------------------

    /**
     * Get the value of id_review
     */
    public function getId_review()
    {
        return $this->id_review;
    }

    /**
     * Set the value of id_review
     *
     * @return  self
     */
    public function setId_review($id_review)
    {
        $this->id_review = $id_review;

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
     * Get the value of rating
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set the value of rating
     *
     * @return  self
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

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


    /**
     * Get the value of id_film
     */
    public function getId_film()
    {
        return $this->id_film;
    }

    /**
     * Set the value of id_film
     *
     * @return  self
     */
    public function setId_film($id_film)
    {
        $this->id_film = $id_film;

        return $this;
    }
}
