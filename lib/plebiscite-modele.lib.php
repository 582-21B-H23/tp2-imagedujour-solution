<?php

/**
 * Plébiscite (aime) d'une image donnée par l'utilisateur connecté.
 * 
 * @param int $iid : identifiant de l'image.
 * @param int $uid : identifiant de l'utilisateur connecté.
 * 
 * @return int : identifiant du plébiscite ajouté.
 */
function aimer($iid, $uid) {
  $bd = ouvrirConnexion();
  $iid = (int)$iid;
  $uid = (int)$uid;
  $sql = "INSERT INTO plebiscite VALUES (NULL, $iid, $uid)";
  return creer($bd, $sql);
}

/**
 * Retrait du plébiscite d'une image donnée par l'utilisateur connecté.
 * 
 * @param int $iid : identifiant de l'image.
 * @param int $uid : identifiant de l'utilisateur connecté.
 * 
 * @return int|bool : 1 (succès) ou false (échec de la requête).
 */
function desaimer($iid, $uid) {
  $bd = ouvrirConnexion();
  $iid = (int)$iid;
  $uid = (int)$uid;
  return supprimer($bd, "DELETE FROM plebiscite WHERE image_id=$iid AND utilisateur_id=$uid");
}

/**
 * Obtient le décompte du nombre de plébiscite d'une image et son état
 * pour un utilisateur donné.
 *
 * @param int $iid : identifiant d'une image
 * @param int $uid : identifiant d'un utilisateur (0 si pas d'utilisateur)
 * 
 * @return array Tableau associatif contenant 'decompte' et 'etat' du
 * plébiscite.
 */
function obtenirEtatEtDecompte($iid, $uid=0) {
  $bd = ouvrirConnexion();
  $sql = "SELECT 
            COUNT(id) AS decompte,
            SUM(utilisateur_id=$uid) AS etat
          FROM plebiscite 
          WHERE image_id=$iid";
  return lireUn($bd, $sql);
}

