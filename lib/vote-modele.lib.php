<?php
/**
 * Ajuste le vote sur un commentaire pour un utilisateur donné. 
 * 
 * @param int $updown : valeur du vote (-1 ou 1).
 * @param int $cid : identifiant du commentaire sur lequel on vote.
 * @param int $uid : identifiant de l'utilisateur qui vote.
 * 
 * @return int|bool : identifiant du vote jouté, ou :  
 *                    1 si le vote est modifié ou supprimé, ou :
 *                    false (échec de la requête).
 */
function enregistrerVote($updown, $cid, $uid) {
  $bd = ouvrirConnexion();
  $updown = (int)$updown;
  $cid = (int)$cid;
  $uid = (int)$uid;
  $res = lireUn($bd, "SELECT id, updown FROM vote WHERE commentaire_id=$cid AND utilisateur_id=$uid");
  
  if($res) {
    $etatUpdown = $res['updown'];
    if($updown == $etatUpdown) {
      supprimer($bd, "DELETE FROM vote WHERE id=".$res['id']);
    }
    else {
      modifier($bd, "UPDATE vote SET updown=$updown WHERE id=".$res['id']);
    }
  }
  else {
    $sql = "INSERT INTO vote VALUES (NULL, $updown, $cid, $uid)";
    return creer($bd, $sql);
  }
}

