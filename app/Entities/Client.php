<?php

// DEFINITION DE L'ESPACE DE NOM
namespace App\Entities;

// -------------------------
// CLASSE ET BDD UTILISATEUR
// -------------------------
class Client
{

    // ATTRIBUTS //
    private $id_client;
    private $prenom;
    private $nom;
    private $email;
    private $mdp;
    private $adresse;
    private $cp;
    private $ville;
    private $token;
    private $token_expiration;

    // --------------------------
    // METHODES GETTER ET SETTER
    // --------------------------
    public function getId_client()
    {
        return $this->id_client;
    }


    public function setId_client($id_client)
    {
        $this->id_client = $id_client;

        return $this;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getMdp()
    {
        return $this->mdp;
    }

    public function setMdp($mdp)
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }


    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCp()
    {
        return $this->cp;
    }

    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille()
    {
        return $this->ville;
    }

    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function getToken_expiration()
    {
        return $this->token_expiration;
    }

    public function setToken_expiration($token_expiration)
    {
        $this->token_expiration = $token_expiration;

        return $this;
    }
}
