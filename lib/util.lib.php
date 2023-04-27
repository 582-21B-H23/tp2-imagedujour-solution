<?php

const MSG_UI = [
    'e1000'     =>  [
        'type'  =>  'succes',
        'texte' =>  "Content de te voir &#x1F603;"
    ],
    'e1010'     =>  [
        'type'  =>  'info',
        'texte' =>  "Bye... reviens-nous vite &#x1F625;"
    ],
    'e1020'     =>  [
        'type'  =>  'avertissement',
        'texte' =>  "Cette action requiert d'être connecté &#x1F64F;"
    ],
    'e1030'     =>  [
        'type'  =>  'erreur',
        'texte' =>  "Hum bien essayé, mais non ! &#x1F621;"
    ],
    'e2000'     =>  [
        'type'  =>  'succes',
        'texte' =>  "Merci pour ton commentaire &#x1F64F;"
    ],
    'e2010'     =>  [
        'type'  =>  'info',
        'texte' =>  "OK, commentaire supprimé &#x1F60C;"
    ]
];

/**
 * Retourne une date formatée pour l'affichage.
 *
 * @param string $date Une date dans le format "2023-04-03"
 * @return string La même date formatée suivant le modèle suivant : "Lundi, 3 avril 2023"
 */
function dateFormatee($date) 
{
    // Il faut configurer l'extension dans php.ini
    $formatteur = datefmt_create(
                        'fr_CA', 
                        IntlDateFormatter::FULL,
                        IntlDateFormatter::FULL,
                        "America/Toronto", 
                        IntlDateFormatter::GREGORIAN,
                        "EEEE, d MMM YYYY");
    return ucfirst(datefmt_format($formatteur, strtotime($date)));
}

/**
 * Retourne toutes les valeurs requises pour la gestion des jours.
 */
function gererJours() {
    $formatDate = 'Y-m-d';
    $jourMax = date_format(date_create(), $formatDate); // Aujourd'hui
    // Pour la prochaine valeur, on peut aussi chercher dans la BD, 
    // mais ça me semble peu pertinent.
    // Peut être chercher de la BD et stocker dans un témoin HTTP ? 
    // Ou encore mieux, stocker dans une variable de configuration ?
    // Je vais tout simplement le coder statiquement ici ;-)
    $jourMin = "2023-02-18"; 
    $jour = isset($_SESSION['jour']) ? $_SESSION['jour'] : $jourMax;
    $jourFr = dateFormatee($jour);
    $jourObj = date_create($jour);
    if($jourMin < $jour) {
        $precObj = date_sub(clone $jourObj, date_interval_create_from_date_string("1 day"));
        $prec = date_format($precObj, $formatDate);
    }
    if($jourMax > $jour) {
        $suivObj = date_add(clone $jourObj, date_interval_create_from_date_string("1 day"));
        $suiv = date_format($suivObj, $formatDate);
    }

    return [
        'jourMax'   =>  $jourMax,
        'jourMin'   =>  $jourMin,
        'jour'      =>  $jour,
        'jourFr'    =>  $jourFr,
        'prec'      =>  $prec ?? null,
        'suiv'      =>  $suiv ?? null 
    ];
    
}