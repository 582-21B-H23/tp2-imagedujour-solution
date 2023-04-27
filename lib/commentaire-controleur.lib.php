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
    case 'ajouter':
      $iid = $_GET['iid'];
      $texte = $_POST['texte'];
      $res = ajouterCommentaire($texte, $iid, $uid);
      if($res) {
        $codeMsg = 'e2000';
      }
    break;
    case 'supprimer':
      $cid = $_GET['cid'];
      $res = enleverCommentaire($cid, $uid);
      if($res) {
        $codeMsg = 'e2010';
      }
    break;
  }
  header("Location: index.php?msg=$codeMsg");
}