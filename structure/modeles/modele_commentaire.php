<?php 
/**
* Fichier Modèle d'accès à la table BDD : commentaire
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
* Class \modeles\Modele_Commentaire extends \modeles\Modele_Maitre
* 
* Classe PHP contenant les méthodes de requetes SQL liées à la table commentaire 
* 
*/ 
class Modele_Commentaire extends Modele_Maitre
{
    /**
    * Requete SQL : 
	* Recherche -> UNE entrée dans la table 
	* Selon -> id 
    * 
    * @param string|int $id 
    *     ID correspondant à l'entrée dans la table  
    * 
    * @return bool | \entites\Entite_commentaire::object
    */
    public function selectToutCommentaires($id_article) 
    {
        if ($this->connect) {
            $stmt = $this->connect->prepare('SELECT * FROM commentaire WHERE id_article=:id_article ORDER BY id DESC');
            $stmt->bindValue(':id_article', $id_article, \PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt && !isset($stmt->errorInfo()[2]) && $stmt->rowCount() >= 0) {
                return $stmt->fetchAll(\PDO::FETCH_CLASS, '\entites\Entite_commentaire');
            }
        }
        return false;
    }
	
	
    /**
    * Requete SQL : 
	* Insertion -> UNE entrée dans la table 
	* Necessite -> sujet, message, date_p, id_article, id_user 
    * 
    * @param \entites\Entite_commentaire:object $obj 
    *     Objet comprenant toutes les informations pour insérer une entrée dans la table. 
    *  
    * @return bool
    */
    public function insererCommentaire($obj)
    {
        
        if ($this->connect) {
            $req = 'INSERT INTO commentaire
            (sujet, message, date_p, id_article, id_user) 
            VALUES(:sujet, :message, :date_p, :id_article, :id_user)';
            $stmt = $this->connect->prepare($req);
            $stmt->bindValue(':sujet', $obj->getSujet(), \PDO::PARAM_STR);
            $stmt->bindValue(':message', $obj->getMessage(), \PDO::PARAM_STR);
            $stmt->bindValue(':date_p', $obj->getDate_p(), \PDO::PARAM_STR);
            $stmt->bindValue(':id_article', $obj->getId_article(), \PDO::PARAM_INT);
            $stmt->bindValue(':id_user', $obj->getId_user(), \PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt && $stmt->rowCount() == 1) {
				return $this->connect->lastInsertId();
            }
        }
        return false;
        
    }

}

?>