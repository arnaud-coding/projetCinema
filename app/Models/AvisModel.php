<?php

namespace App\Models;

use App\Core\DbConnect;
use App\Entities\Avis;
use PDO;
use PDOException;


// -------------------------------
// CLASSE MODEL DE L'ENTITE CLIENT
// -------------------------------
class AvisModel extends DbConnect
{
  // ---------------------------------------
  //  LIRE LES AVIS D'UN PRODUIT
  // ---------------------------------------
  public function readByProduit($id_produit)
  {
    try {
      // PREPARATION DE LA REQUETE SQL
      $this->request = $this->connection->prepare("SELECT
                                                      eco_avis.*,
                                                      eco_client.firstname AS firstname
                                                   FROM eco_avis
                                                   INNER JOIN eco_client ON
                                                      eco_client.id_client = eco_avis.id_client
                                                   WHERE id_produit = :id_produit");
      $this->request->bindValue(":id_produit", $id_produit, PDO::PARAM_INT);

      // EXECUTION DE LA REQUETE SQL
      $this->request->execute();

      // FORMATAGE DU RESULTAT DE LA REQUETE
      $avis = $this->request->fetchAll();

      // RETOUR DU RESULTAT
      return $avis;
    } catch (PDOException $e) {
      //echo $e->getMessage();
      //die;
      return false;
    }
  }

  // ----------------------------
  //  AJOUTER UN AVIS
  // ----------------------------
  public function add(Avis $avis)
  {
    try {
      // PREPARATION DE LA REQUETE SQL
      $this->request = $this->connection->prepare("INSERT INTO eco_avis
                                                   VALUES (null, :id_produit, :id_client, :commentaire, :note, :date_avis)");
      $this->request->bindValue(":id_produit", $avis->getId_produit(), PDO::PARAM_INT);
      $this->request->bindValue(":id_client", $avis->getId_client(), PDO::PARAM_INT);
      $this->request->bindValue(":commentaire", $avis->getCommentaire(), PDO::PARAM_STR);
      $this->request->bindValue(":note", $avis->getNote(), PDO::PARAM_INT);
      $this->request->bindValue(":date_avis", $avis->getDate_avis(), PDO::PARAM_STR);

      // EXECUTION DE LA REQUETE SQL ET RETOUR DE L'EXECUTION
      return $this->request->execute();
    } catch (PDOException $e) {
      return false;
    }
  }
}
