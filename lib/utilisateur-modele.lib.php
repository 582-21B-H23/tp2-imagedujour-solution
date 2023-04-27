<?php
/**
 * Obtient l'info d'un utilisateur.
 * 
 * @param string $pseudo : "pseudo" de l'utilisateur.
 * 
 * @return array : tableau associatif contenant l'info de l'utilisateur.
 */
function unParPseudo($pseudo) 
{
  $bd = ouvrirConnexion();
  $pseudo = mysqli_real_escape_string($bd, $pseudo);
  $sql = "SELECT * FROM utilisateur WHERE pseudo = '$pseudo'";
  return lireUn($bd, $sql);
}