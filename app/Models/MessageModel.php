<?php

// DEFINITION DE L'ESPACE DE NOM
namespace App\Models;


/////////////////////////////
// CLASSE MODEL DE MESSAGE //
/////////////////////////////
class MessageModel
{

    ///////////////////////////////////////
    // METHODE POUR RECUPERER UN MESSAGE //
    ///////////////////////////////////////
    public function getMessage($key)
    {
        $messages = [
            "success_validateOrder" => "Commande validée, vous allez recevoir un mail de confirmation.",
            "success_createEmprunt" => "L'emprunt est validé, merci de venir retirer votre livre à la bibliothèque !",
            "success_returnEmprunt" => "L'emprunt est cloturé !",
            "success_updateEmprunt" => "L'emprunt a été mis à jour !",
            "success_deleteEmprunt" => "L'emprunt a été supprimé !",
            "success_livreCreate" => "Le livre a été ajouté !",
            "success_livreUpdate" => "Le livre a été mis à jour !",
            "success_livreDelete" => "Le livre a été supprimé !",
            "success_login" => "Bienvenue sur votre espace personnel !",
            "success_logout" => "Vous êtes déconnecté. A bientôt !",
            "success_email" => "Un email de réinitialisation vous a été envoyé !",
            "success_createUserByUser" => "Votre compte est enregistré, vous pouvez à présent vous connecter !",
            "success_createUserByAdmin" => "L'utilisateur a été ajouté !",
            "success_updateUserByUser" => "Votre compte a été mis à jour !",
            "success_updateUserByAdmin" => "L'utilisateur a été mis à jour !",
            "success_updateMdp" => "Votre mot de passe a été mis à jour, vous pouvez à présent vous connecter !",
            "success_deleteUser" => "L'utilisateur a été supprimé !",
            "error_validateOrder" => "Echec de la validation de la commande !",
            "error_avis" => "Veuillez vous connecter pour laisser un avis !",
            "error_blank" => "Aucun élément trouvé !",
            "error_id" => "Une erreur s'est produite : ID !",
            "error_token" => "Une erreur s'est produite : Token !",
            "error_request" => "Une erreur s'est produite : Requete !",
            "error_rights" => "Vous n'avez pas les droits pour accéder à cette page !",
            "error_search" => "Merci de saisir un titre, un auteur ou un genre !",
            "error_isEmprunt" => "Le livre ne peut pas être supprimé tant qu'un emprunt est en cours !",
            "error_haveEmprunt" => "L'utilisateur ne peut pas être supprimé tant qu'un emprunt est en cours !",
            "error_limitEmprunt" => "L'emprunt est limité à 3 livres !",
            "error_input" => "Veuillez remplir tous les champs !",
            "error_inputEmail" => "Veuillez saisir un email !",
            "error_login" => "Identifiant ou mot de passe incorrect !",
            "error_email" => "Une erreur s'est produite lors de l'envoi du mail !",
            "error_noEmail" => "Votre email est inconnu, merci de créer un compte !",
            "error_userFound" => "Votre adresse e-mail est déjà enregistré, merci de vous connecter ou de réinitialiser votre mot de passe !",
            "error_adminFound" => "Un compte avec cette adresse e-mail est déjà enregistré !",
            "error_expire" => "Le lien a expiré, merci de refaire une demande !",
            "error_link" => "Le lien de réinitialisation est incorrect ou obselète !",
        ];

        return $messages[$key] ?? "Une erreur inconnue est survenue.";
    }
}
