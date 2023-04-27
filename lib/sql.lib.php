<?php
/**
 * Librairie de code pour manipulation des données MySQL
 * (utilisant la librairie MySQLi de PHP)
 */

// ATTENTION : ne changez RIEN à la prochaine instruction ! Placez plutôt
// votre fichier de configuration de la BD à l'emplacement indiqué à
// la racine même de votre dossier de solution (même si ce n'est pas une  
// bonne pratique) : ce chemin doit être le même dans toutes les remises  
// de TP pour faciliter mes tests lors de la correction. 
require_once('config-temp/21b-h23-idj.cfg.php');

function ouvrirConnexion() 
{
  $cnx = mysqli_connect(BD_HOTE, BD_UTIL, BD_MDP, BD_NOM);
  mysqli_set_charset($cnx, BD_CHARSET);
  return $cnx;
}

function soumettreRequete($cnx, $req) 
{
  return mysqli_query($cnx, $req);
}

/**
 * Exécute une requête SQL de type SELECT
 *
 * @param  MySQLi $cnx : identifiant de connexion MySQLi obtenu préalablement
 * @param  string $req : requête SQL SELECT
 * @param  int $mode : constante pour indiquer si on veut un tableau 
 *              associatif (par défaut) ou autre
 * @see https://www.php.net/manual/en/mysqli-result.fetch-all.php
 * 
 * @return array|bool : tableau de tableaux (par défaut associatifs) ou false.
 */
function lire($cnx, $req, $mode=MYSQLI_ASSOC) 
{
  $resultat = soumettreRequete($cnx, $req);
  if($resultat) {
    return mysqli_fetch_all($resultat, $mode);
  }
  return false;
}

/**
 * Effectue une requête SELECT et retourne un seul enregistrement
 *
 * @param  MySQLi $cnx : identifiant de connexion MySQLi obtenu préalablement
 * @param string $req Requête SQL de type SELECT
 * @return array|bool tableau associatif représentant l'enregistrement retourné
 */
function lireUn($cnx, $req) 
{
  $resultat = soumettreRequete($cnx, $req);
  if($resultat) {
    return mysqli_fetch_assoc($resultat);
  }
  return false;
}

/**
 * Effectue une requête INSERT
 *
 * @param  MySQLi $cnx : identifiant de connexion MySQLi obtenu préalablement
 * @param string $req Requête SQL de type INSERT
 * @return int|bool Identifiant de l'enregistrement ajouté, ou false
*/
function creer($cnx, $req) 
{
  $resultat = soumettreRequete($cnx, $req);
  if($resultat) {
    return mysqli_insert_id($cnx);
  }
}

/**
 * Effectue une requête UPDATE
 *
 * @param  MySQLi $cnx : identifiant de connexion MySQLi obtenu préalablement
 * @param string $req Requête SQL de type UPDATE
 * @return int Le nombre d'enregistrements modifiés
 */
function modifier($cnx, $req) 
{
  $resultat = soumettreRequete($cnx, $req);
  if($resultat) {
    return mysqli_affected_rows($cnx);
  }
  return false;
}

/**
 * Effectue une requête DELETE
 *
 * @param  MySQLi $cnx : identifiant de connexion MySQLi obtenu préalablement
 * @param string $req Requête SQL de type DELETE
 * @return int Le nombre d'enregistrements supprimés
 */
function supprimer($cnx, $req) 
{
  return modifier($cnx, $req);
}