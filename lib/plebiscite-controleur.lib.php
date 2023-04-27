<?php
session_start();

if(isset($_GET['op'])) {
  if(!isset($_SESSION['utilisateur'])) {
    header('Location: index.php?msg=e1020');
  }
  
  $uid = $_SESSION['utilisateur']['id'];
  
  require_once('lib/sql.lib.php');
  require('lib/'.$module.'-modele.lib.php');

  switch($_GET['op']) {
    case 'plebisciter':
      $iid = $_GET['iid'];
      $etat = $_GET['etat'];
      if(!$etat) {
        aimer($iid, $uid);
      }
      else {
        desaimer($iid, $uid);
      }
      header('Location: index.php');
    break;
  }
}