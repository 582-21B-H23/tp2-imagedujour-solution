<?php
session_start();

if(isset($_GET['op'])) {
  require('lib/sql.lib.php');
  require_once('lib/sql.lib.php');
  require('lib/'.$module.'-modele.lib.php');
  
  switch($_GET['op']) {
    case 'connexion':
      $util = unParPseudo($_POST['pseudo']);
      if($util) {
        if(password_verify($_POST['mdp'], $util['mdp'])) {
          $_SESSION['utilisateur'] = $util;
          $codeErreur = 'e1000';
        }
        else {
          $codeErreur = 'e1030';
        }
      }
      else {
        $codeErreur = 'e1030';
      }
      header("Location: index.php".((isset($codeErreur)) ? "?msg=$codeErreur" : ""));
      break;
    case 'deconnexion': 
      unset($_SESSION['utilisateur']);
      header("Location: index.php?msg=e1010");
      break;
    case 'nouveau':
      // Pas demandé dans cette évaluation
      break;
    
    case 'confirmer':
      // Pas demandé dans cette évaluation
      break;
    
    case 'mdp_oublie':
      // Pas demandé dans cette évaluation
      break; 
  }
}