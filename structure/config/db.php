<?php 
/**
* Elements de connection à la base de données
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
* Dossier ../config 
* @namespace \config
*/
namespace config;

/**
* Class Db
* 
*/ 
class Db
{
	/**
	* Tableau de routes
	* @var array[string => string]
	*/
    protected $db = [
		'database' => 'mvc',
		'user' => 'root', 
		'password' => '', 
		'host' => 'localhost', 
		'charset' => 'utf8', 
	];
}

?>