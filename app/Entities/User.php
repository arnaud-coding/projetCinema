<?php

namespace App\Entities;

// ------------------
// CLASSE ET BDD User
// ------------------
class User
{

    // ATTRIBUTS //
    private $id_user;
    private $email;
    private $pseudo;
    private $password;
    private $type;
    private $token;
    private $token_expire;

    // -------------------
    //  GETTERS ET SETTERS
    // -------------------

    public function getId_user()
    {
        return $this->id_user;
    }

    public function setId_user($id_user)
    {
        $this->id_user = $id_user;

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

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

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

    public function getToken_expire()
    {
        return $this->token_expire;
    }

    public function setToken_expire($token_expire)
    {
        $this->token_expire = $token_expire;

        return $this;
    }
}
