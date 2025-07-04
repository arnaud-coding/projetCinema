<?php

namespace App\Controllers;

// -------------------------
// CLASSE CONTROLEUR DE BASE
// Classe mère dont tous les controllers vont hériter
// -------------------------
abstract class Controller
{
    // -----------------------------------
    //  LE RENDU VERS LES VUES
    // -----------------------------------
    public function render($view, $data = [])
    {
        extract($data); // Les clés du tableau deviennent des noms de variables.

        require_once "../app/Includes/header.php";
        require_once "../app/views/" . $view . ".php";
        require_once "../app/Includes/footer.php";
        //exit();
    }

    // ----------------------------------
    // CONVERTIT DES MINUTES AU FORMAT H/m
    // exemple : converit "121" en "2 h 01 min"
    // ----------------------------------
    function convertMinutesToHours($minutesStr)
    {
        // Convertir la chaîne en entier
        $minutes = (int)$minutesStr;

        // Calcul des heures et minutes
        $hours = intdiv($minutes, 60);
        $remainingMinutes = $minutes % 60;

        // Formater les minutes avec un zéro devant si nécessaire
        $formattedMinutes = str_pad($remainingMinutes, 2, '0', STR_PAD_LEFT);

        // Retourner la chaîne formatée
        return "{$hours} h {$formattedMinutes} min";
    }
}
