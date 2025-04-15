<?php

// DEFINITION DE L'ESPACE DE NOM
namespace App\Models;

// IMPORT DE CLASSES
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Entities\Mail as Mail;

require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
// require "PHPMailer/src/SMTP.php";


// --------------------
// CLASSE MODEL DE MAIL
// --------------------
class MailModel
{
    // -------------------------------------------------
    // METHODE POUR ENVOYER UN MAIL DE REINITIAILISATION
    // -------------------------------------------------
    public function mdpForget(Mail $majMdpMail)
    {
        try {
            // INSTANCIATION D'UN OBJET PHP MAILER (true pour l'activation des exceptions)
            $mail = new PHPMailer(true);

            // PARAMETRE DU MAIL
            $mail->isHTML(true); // Email en format HTML
            $mail->CharSet = "UTF-8"; // Définit l'encodage en UTF-8

            // ADRESSE DE L'EXPEDITEUR
            $mail->setFrom("support@cefii-developpements.fr", "Support CEFII");

            // ADRESSE DU DESTINATAIRE
            $mail->addAddress($majMdpMail->getEmail());

            // SUJET DE MAIL
            $mail->Subject = "Ma Bibliothèque - Réinitialisation de votre mot de passe";

            // IMAGE DANS LE CORPS DU MAIL
            $mail->AddEmbeddedImage("../public/images/mail/font.jpg", "font");

            // CORPS DU MAIL
            $prenomNom = $majMdpMail->getPrenom() . " " . $majMdpMail->getNom();
            $token = $majMdpMail->getToken();
            ob_start();
            include "../views/email/mailNewMDP.php";
            $html = ob_get_clean();

            $mail->Body = $html;

            // ENVOI DU MAIL
            return $mail->send();
        } catch (Exception $e) {
            //echo $mail->ErrorInfo;
            //die;
            return false;
        }
    }

    // ------------------------------------------------------------------------------------------
    // METHODE POUR ENVOYER UN MAIL DE CONFIRMATION AU CLIENT LORSQU'IL CLIENT PASSE UNE COMMANDE
    // ------------------------------------------------------------------------------------------
    public function validatedOrder(Mail $validatedOrderMail)
    {
        try {
            // INSTANCIATION D'UN OBJET PHP MAILER (true pour l'activation des exceptions)
            $mail = new PHPMailer(true);

            // PARAMETRE DU MAIL
            $mail->isHTML(true); // Email en format HTML
            $mail->CharSet = "UTF-8"; // Définit l'encodage en UTF-8

            // PARAMETRE DU SERVEUR SMTP
            // $mail->isSMTP(); // Utilisation du serveur SMTP
            // $mail->Host = "sandbox.smtp.mailtrap.io"; // Hôte SMTP de MailTrap
            // $mail->SMTPAuth = true; // Activation de l'authentification SMTP
            // $mail->Username = "93c4b5511a4b39"; // Votre nom d'utilisateur MailTrap
            // $mail->Password = "9085b8386fbeca"; // Votre mot de passe MailTrap
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Sécurisation via STARTTLS
            // $mail->Port = 2525; // Port SMTP (vous pouvez utiliser 25, 465, 587 ou 2525)


            // ADRESSE DE L'EXPEDITEUR
            $mail->setFrom("support@cefii-developpements.fr", "Support CEFII");

            // ADRESSE DU DESTINATAIRE
            $mail->addAddress($validatedOrderMail->getEmail());

            // SUJET DE MAIL
            $mail->Subject = "CEFiiMarket - Votre commande est en cours de préparation";

            // IMAGE DANS LE CORPS DU MAIL
            $mail->AddEmbeddedImage("../public/images/mail/font.jpg", "font");

            // CORPS DU MAIL
            $prenomNom = $validatedOrderMail->getPrenom() . " " . $validatedOrderMail->getNom();
            $num_commande = $validatedOrderMail->getNum_commande();
            $date_commande = $validatedOrderMail->getDate_commande();
            $montant_commande = $validatedOrderMail->getMontant_commande();
            $adresse_livraison = $validatedOrderMail->getAdresse() . ", " . $validatedOrderMail->getCode_postal() . ", " . $validatedOrderMail->getVille();
            ob_start();
            include "../app/views/email/mailValidatedOrder.php";
            $html = ob_get_clean();

            $mail->Body = $html;

            // ENVOI DU MAIL
            return $mail->send();
        } catch (Exception $e) {
            //echo $mail->ErrorInfo;
            //die;
            return false;
        }
    }
}
