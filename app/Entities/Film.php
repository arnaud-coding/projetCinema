<?php

namespace App\Entities;

// ---------------------------------
// CLASSE DE L'ENTITE Film DE LA BDD
// ---------------------------------
class Film
{
  private $id_film;
  private $title;
  private $release_year;
  private $duration;
  private $picture;

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

  public function getTitle()
  {
    return $this->title;
  }
  public function setTitle($title)
  {
    $this->title = $title;
    return $this;
  }

  public function getRelease_year()
  {
    return $this->release_year;
  }
  public function setRelease_year($release_year)
  {
    $this->release_year = $release_year;
    return $this;
  }

  public function getDuration()
  {
    return $this->duration;
  }
  public function setDuration($duration)
  {
    $this->duration = $duration;
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
