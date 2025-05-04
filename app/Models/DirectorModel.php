<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Entities\Director;
use App\Entities\Film;
use App\Core\DbConnect;


// -----------------------------
// CLASSE MODEL DE L'ENTITE DIRECTOR
// -----------------------------
class DirectorModel extends DbConnect
{
    // ---------------
    //  LIRE UN DIRECTOR PAR SON ID
    // ---------------
    public function readByID($id_director)
    {
        try {
            // PREPARATION DE LA REQUETE SQL
            $this->request = $this->connection->prepare("SELECT * FROM ppc_director WHERE id_director = :id_director");
            $this->request->bindValue(":id_director", $id_director, PDO::PARAM_INT);

            // EXECUTION DE LA REQUETE SQL
            $this->request->execute();

            // FORMATAGE DU RESULTAT DE LA REQUETE
            $director = $this->request->fetch();

            // RETOUR DU RESULTAT
            return $director;
        } catch (PDOException $e) {
            return $e->errorInfo[1];
        }
    }
    public function getAllByFilmId()
    {
        return ["director"];
    }
}
