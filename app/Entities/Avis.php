<?php

// DEFINITION DE L'ESPACE DE NOM
namespace App\Entities;

// -------------------------
// CLASSE ET BDD UTILISATEUR
// -------------------------
class Avis
{
  private $id_avis;
  private $id_produit;
  private $id_client;
  private $commentaire;
  private $note;
  private $date_avis;

  // --------------------------
  // METHODES GETTER ET SETTER
  // --------------------------
  public function getId_avis()
  {
    return $this->id_avis;
  }

  public function setId_avis($id_avis)
  {
    $this->id_avis = $id_avis;

    return $this;
  }

  public function getId_produit()
  {
    return $this->id_produit;
  }

  public function setId_produit($id_produit)
  {
    $this->id_produit = $id_produit;

    return $this;
  }

  public function getId_client()
  {
    return $this->id_client;
  }

  public function setId_client($id_client)
  {
    $this->id_client = $id_client;

    return $this;
  }

  public function getCommentaire()
  {
    return $this->commentaire;
  }

  public function setCommentaire($commentaire)
  {
    $this->commentaire = $commentaire;

    return $this;
  }

  public function getNote()
  {
    return $this->note;
  }

  public function setNote($note)
  {
    $this->note = $note;

    return $this;
  }

  public function getDate_avis()
  {
    return $this->date_avis;
  }

  public function setDate_avis($date_avis)
  {
    $this->date_avis = $date_avis;

    return $this;
  }
}
