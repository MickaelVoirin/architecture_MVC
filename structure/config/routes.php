<?php 
/**
* Fichier de routes
* -> Corespondances avec URL
*
* PHP version 7
*
* @category   CRJP Formation
* @package    Formation
* @author     Mickael Voirin <crjpwork@gmail.com>
* @copyright  1997-2005 The PHP Group - CRJP Conseil +
* @license    http://www.php.net/license/3_01.txt  PHP License 3.01
* @version    2.0
*/

/**
* Tableau de routes
* @var array[ string => array[string] ]
*/

$routes = [
    'connection' => ['controleur_user', 'actionLogin'],
    'deconnection' => ['controleur_user', 'actionLogout'],
    'liste' => ['controleur_article', 'actionVoir'],
    'ajouter' => ['controleur_article', 'actionAjouter'],
    'modifier' => ['controleur_article', 'actionModifier'],
    'supprimer' => ['controleur_article', 'actionSuppr'],
    'unarticle' => ['controleur_article', 'actionUnArticle']
];



?>