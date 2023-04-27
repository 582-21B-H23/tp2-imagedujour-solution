<?php
/**
 * Ajoute un commentaire à une image par un utilisateur. 
 * 
 * @param string $texte : texte du commentaire.
 * @param int $iid : identifiant de l'image.
 * @param int $uid : identifiant de l'utilisateur connecté.
 * 
 * @return int : identifiant du nouveau commentaire.
 */
function ajouterCommentaire($texte, $iid, $uid) {
  $bd = ouvrirConnexion();
  $texte = mysqli_real_escape_string($bd, $texte);
  $iid = (int)$iid;
  $uid = (int)$uid;
  $sql = "INSERT INTO commentaire VALUES (NULL, '$texte', NOW(), $iid, $uid)";
  return creer($bd, $sql);
}

/**
 * Retire un commentaire d'un utilisateur pour une image. 
 * 
 * @param int $cid : identifiant du commentaire.
 * @param int $uid : identifiant de l'utilisateur connecté.
 * 
 * @return int|bool : 1 ou flase.
 */
function enleverCommentaire($cid, $uid) {
  $bd = ouvrirConnexion();
  $cid = (int)$cid;
  $uid = (int)$uid;
  $sql = "DELETE FROM commentaire WHERE id=$cid AND utilisateur_id=$uid";
  return supprimer($bd, $sql);
}

/**
 * Obtient tous les commentaires pour une image donnée incluant le 
 * décompte des votes approbateurs et désapprobateurs et le taux de vote.
 
 * @param int $iid : identifiant d'une image.
 * 
 * @return array Tableau de tableaux contenant l'info des commentaires.
 */
function toutAvecVotes($iid) {
  $bd = ouvrirConnexion();
  $sql = "SELECT 
            c.*,
            u.pseudo,
            SUM(CASE WHEN v.updown=1 THEN 1 ELSE 0 END) AS approbateurs, 
            SUM(CASE WHEN v.updown=-1 THEN 1 ELSE 0 END) AS desapprobateurs,
            -- On doit éviter la division par 0 lors du calcul du taux :
            COALESCE(
              ROUND(
                SUM(CASE WHEN v.updown=1 THEN 1 ELSE 0 END)/
                  (SUM(CASE WHEN v.updown=-1 THEN 1 ELSE 0 END)+SUM(CASE WHEN v.updown=1 THEN 1 ELSE 0 END))
                , 2
              ), 
            1) AS taux
          FROM commentaire AS c 
            JOIN utilisateur AS u ON c.utilisateur_id = u.id
            LEFT JOIN vote AS v ON c.id = v.commentaire_id 
            JOIN image AS i ON c.image_id = i.id 
          WHERE i.id = $iid 
          GROUP by c.id
          ORDER BY taux DESC, c.dateajout DESC";
  return lire($bd, $sql);
}