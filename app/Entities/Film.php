<?php

namespace App\Entities;

// ------------------
// CLASSE ET BDD Film
// ------------------
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
   * Get the value of release_year
   */
  public function getRelease_year()
  {
    return $this->release_year;
  }

  /**
   * Set the value of release_year
   *
   * @return  self
   */
  public function setRelease_year($release_year)
  {
    $this->release_year = $release_year;

    return $this;
  }

  /**
   * Get the value of duration
   */
  public function getDuration()
  {
    return $this->duration;
  }

  /**
   * Set the value of duration
   *
   * @return  self
   */
  public function setDuration($duration)
  {
    $this->duration = $duration;

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
