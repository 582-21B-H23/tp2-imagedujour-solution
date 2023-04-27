<?php
session_start();
date_default_timezone_set("America/Toronto");
$formatDate = 'Y-m-d';
$jourCourant = date_create();

$util = (isset($_SESSION['utilisateur'])) ? $_SESSION['utilisateur'] : false;

require_once('lib/sql.lib.php');
require('lib/'.$module.'-modele.lib.php');

// Pour générer notre "vue" nous avons besoin d'accéder aux données de 
// commentaires et de plébiscites en plus des données de l'image, d'où 
// l'ajout des modèles correspondant.
require('lib/plebiscite-modele.lib.php');
require('lib/commentaire-modele.lib.php');


if(isset($_GET['op'])) {
  switch($_GET['op']) {
    case 'afficher':
      $jourCourant = isset($_GET['jour']) ? date_create($_GET['jour']) : date_create();
      // Stocker le jour en session
      $_SESSION['jour'] = date_format($jourCourant, $formatDate);
      break;
  }
}

// Par paresse, j'utilise https://www.php.net/manual/en/function.extract.php
// Mais une meilleure approche serait d'utiliser le tableau résultant, ou 
// encore la syntaxe de list() ou de décomposition de tableau associatif 
// (disponible PHP > 7.1). Pour un survol de toutes ces méthodes : 
// https://www.excellarate.com/blogs/destructuring-assignments-in-php7/
extract(gererJours());

$image = imageDuJour($jour);
$plebiscite = obtenirEtatEtDecompte($image['id'], $util?$util['id']:0);
$commentaires = toutAvecVotes($image['id']);