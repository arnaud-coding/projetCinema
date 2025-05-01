<?php

namespace App\Entities;

// -----------------------------------
// CLASSE DE L'ENTITE review DE LA BDD
//
// (Critiques d'un film)
// -----------------------------------
class Review
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

    public function getId_review()
    {
        return $this->id_review;
    }
    public function setId_review($id_review)
    {
        $this->id_review = $id_review;
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

    public function getRating()
    {
        return $this->rating;
    }
    public function setRating($rating)
    {
        $this->rating = $rating;
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

    public function getId_film()
    {
        return $this->id_film;
    }
    public function setId_film($id_film)
    {
        $this->id_film = $id_film;
        return $this;
    }
}
