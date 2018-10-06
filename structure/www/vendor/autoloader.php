<?php 
/**
* Autoloader
* -> Permet de charger automatiquement toutes les classes PHP de l'architecture
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
* Class Autoloader
*
* Classe PHP contenant les méthodes permettant le concept d'autoload
* 2 méthodes
*
*/ 

class Autoloader
{
    /**
    * Méthode Executée avant tout en index.php 
    *
    * Permet l'execution automatique de la seconde méthode
    *
    * @return void
    */
    public function splRegister()
    {
        spl_autoload_register([__CLASS__,'autoload']);
    }

    /**
    * Méthode executée automatiquement 
    * 
    * Permet d'inclure les fichiers de classe en tenant compte de leurs namespaces
    *
    * @param string $classe 
    *     Chemin complet (namepsace + nom) de la classe à instancier automatiquement
    *
    * @return void
    */
    function autoload($classe)
    {
        $classe = str_replace('\\', '/', $classe);
        include_once '../'.strtolower($classe).'.php';
    }
}



?>