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
    case 'voter':
      $cid = $_GET['cid'];
      $updown = $_GET['updown'];
      enregistrerVote($updown, $cid, $uid);      
    break;
  }
  header('Location: index.php');
}