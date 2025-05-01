<?php

namespace App\Entities;


// ---------------------------------
// CLASSE MAIL //
// ---------------------------------
class Mail
{
    // ---------------------------------
    // ATTRIBUTS //
    // ---------------------------------
    private $lastname;
    private $firstname;
    private $email;
    private $token;
    private $num_commande;
    private $date_commande;
    private $montant_commande;
    private $adresse;
    private $code_postal;
    private $ville;

    // ---------------------------------
    // METHODES GETTER ET SETTER //
    // ---------------------------------

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

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

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function getNum_commande()
    {
        return $this->num_commande;
    }

    public function setNum_commande($num_commande)
    {
        $this->num_commande = $num_commande;

        return $this;
    }

    public function getDate_commande()
    {
        return $this->date_commande;
    }

    public function setDate_commande($date_commande)
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getMontant_commande()
    {
        return $this->montant_commande;
    }

    public function setMontant_commande($montant_commande)
    {
        $this->montant_commande = $montant_commande;

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

    public function getCode_postal()
    {
        return $this->code_postal;
    }

    public function setCode_postal($code_postal)
    {
        $this->code_postal = $code_postal;

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
}
