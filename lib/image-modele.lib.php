<?php
/**
 * Obtient l'information d'une image du jour.
 * 
 * @param string $jour : jour de l'image dans le format aaaa-mm-jj.
 * 
 * @return array : tableau associatif contenant l'info de l'image.
 */
function imageDuJour($jour) {
  $bd = ouvrirConnexion();
  $sql = "SELECT * FROM image WHERE jour='$jour'";
  return lireUn($bd, $sql);
}

