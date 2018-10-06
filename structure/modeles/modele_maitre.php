<?php 
/**
* Fichier Maitre des Modèles (Accès BDD)
* Concentre toutes les fonctionnalités communes aux Modèles   
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
* Dossier ../modeles 
* @namespace \modeles
*/
namespace modeles;

/**
* Class \modeles\Modele_Maitre extends \config\Db
* 
* Classe PHP contenant les méthodes communes à toutes les classes Modeles  
* -> Ici : une seule méthode, le constructeur
* 
*/ 
class Modele_Maitre extends \config\Db
{
    /**
	* Instance de PDO
	* @var null | \PDO::object
	*/
    protected $connect = null;
    
    /**
    * Méthode Constructeur executée à chaque instance des classes Modeles (Cf. Controleurs) 
    * Permet la connection automatique à la BDD lors de chaque initialisation de Modele
    * La propriété $connect reçoit l'instance de la classe PDO 
    *
    * @return void
    */
    public function __construct()
    {
        
        $serveur = 'mysql:dbname='.$this->db['database'].';host='.$this->db['host'].';charset='.$this->db['charset'];
        
        try {
            $this->connect = new \PDO($serveur, $this->db['user'], $this->db['password']);
        } catch (\PDOException $e) {
            echo 'Probleme avec la connectionj en BDD : <br>"' . $e->getMessage() . '"';
        }
         
         
    }

}

?>