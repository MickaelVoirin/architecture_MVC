<?php 
/**
* Fichier Modèle d'accès à la table BDD : user   
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
* Class \modeles\Modele_User extends \modeles\Modele_Maitre
* 
* Classe PHP contenant les méthodes de requetes SQL liées à la table user 
* 
*/ 
class Modele_User extends Modele_Maitre
{
    /**
    * Requete SQL : 
	* Recherche -> UNE entrée dans la table 
	* Selon -> login et mdp 
    * 
    * @param array $post 
    *     Tableau comprenant les critères de recherche  
    * 
    * @return bool | \entites\Entite_user::object
    */
    function verifUser($post)
    {
        
        if ($this->connect) {
            
            $req = 'SELECT * FROM user WHERE login=:login AND mdp=:mdp';
            $stmt = $this->connect->prepare($req);
            $stmt->bindValue(':login', $post['login'], \PDO::PARAM_STR);
            $stmt->bindValue(':mdp', $post['mdp'], \PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt && $stmt->rowCount() == 1) {
                return $stmt->fetchObject('entites\Entite_user');
            }
        }
        return false;
    }
	
	/**
    * Requete SQL : 
	* Recherche -> TOUTES entrées dans la table 
	* Ordonnées par -> id desc
    * 
    * @return bool | array[ \entites\Entite_user::object ]
    */
    public function selectToutUser()
    {
        if ($this->connect) {
            $stmt = $this->connect->query('SELECT * FROM user ORDER BY id');
            if ($stmt && $stmt->rowCount() != 0) {
                return $stmt->fetchAll(\PDO::FETCH_CLASS, 'entites\Entite_user');
            }
        }
        return false;
    }
	
	
	/**
    * Requete SQL : 
	* Recherche -> UNE entrée dans la table 
	* Selon -> id 
    * 
    * @param string|int $id 
    *     ID correspondant à l'entrée dans la table  
    * 
    * @return bool | \entites\Entite_user::object
    */
    public function selectUnUser($id) 
    {
        if ($this->connect) {
            $stmt = $this->connect->prepare('SELECT * FROM user WHERE id=:id');
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt && $stmt->rowCount() == 1) {
                return $stmt->fetch(\PDO::FETCH_ASSOC);
            }
        }
        return false;
    }
	

}

?>