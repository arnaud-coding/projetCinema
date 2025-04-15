<?php

// DEFINITION DE L'ESPACE DE NOM
namespace App\Controllers;

// IMPORT DE CLASSES
use App\Models\MessageModel;


/////////////////////////////////
// CLASSE CONTROLEUR PRINCIPAL //
/////////////////////////////////
abstract class Controller
{
    //////////////////////////////////////
    // METHODE POUR LE RENDU DANS VIEWS //
    //////////////////////////////////////
    public function render($view, $data = [])
    {
        extract($data); // Les clés du tableau deviennent des noms de variables.

        require_once "../app/Includes/header.php";
        require_once "../app/views/" . $view . ".php";
        require_once "../app/Includes/footer.php";
        //exit();
    }

    /////////////////////////////////////
    // METHODE POUR RECHARGER UNE PAGE //
    /////////////////////////////////////
    public function myHeader($controller, $action, $messageKey, $data = [])
    {
        // CONSTUCTION DE L'URL
        $location = "index.php?controller=" . $controller . "&action=" . $action;

        // AJOUT D'UN PARAMETRE
        if (isset($data)) {
            $location .= "&" . key($data) . "=" . current($data);
        }

        // AJOUT D'UN MESSAGE
        if (isset($messageKey)) {   
            $messageModel = new MessageModel();
            $message = $messageModel->getMessage($messageKey);

            // if (str_starts_with($messageKey, "success_")) {
            //     $location .= "&msgOK=" . $message;
            // } else {
            //     $location .= "&msgKO=" . $message;
            // }
        }
        
        header("location: " . $location);
        //exit();  
    }

    ////////////////////////////////////////
    // METHODE POUR GENERER UN TOKEN CSRF //
    ////////////////////////////////////////
    public function generateToken()
    {
        $token_expiration = time() + 900; // 15 minutes (900 secondes)
        $_SESSION["token"] = [
            "id" => bin2hex(random_bytes(32)),
            "token_expiration" => $token_expiration
        ];
    }
}