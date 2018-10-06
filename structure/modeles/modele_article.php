<?php 
/**
* Fichier Modèle d'accès à la table BDD : article
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
* Class \modeles\Modele_Article extends \modeles\Modele_Maitre
* 
* Classe PHP contenant les méthodes de requetes SQL liées à la table article 
* 
*/ 
class Modele_Article extends Modele_Maitre
{

    /**
    * Requete SQL : 
	* Recherche -> TOUTES entrées dans la table 
	* Ordonnées par -> id desc
    * 
    * @return bool | array[ \entites\Entite_article::object ]
    */
    public function selectToutArticle()
    {
        if ($this->connect) {
            $stmt = $this->connect->query('SELECT * FROM article ORDER BY id DESC');
            if ($stmt && $stmt->rowCount() != 0) {
                return $stmt->fetchAll(\PDO::FETCH_CLASS, 'entites\Entite_article');
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
    * @return bool | \entites\Entite_article::object
    */
    public function selectUnArticle($id) 
    {
        if ($this->connect) {
            $stmt = $this->connect->prepare('SELECT * FROM article WHERE id=:id');
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt && $stmt->rowCount() == 1) {
                return $stmt->fetchObject('entites\Entite_article');
            }
        }
        return false;
    }
	
	/**
    * MEME OBJECTIF QUE LA METHODE PRECEDENTE
	* -> pour index.php, optimisable en fichier Maitre
	*
    * @return bool | \entites\Entite_article::object
    */
	public function selectUn($id) 
    {
        return $this->selectUnArticle($id);
    }

    
    /**
    * Requete SQL : 
	* Insertion -> UNE entrée dans la table 
	* Necessite -> nom, description, date_p, id_user 
    * 
    * @param \entites\Entite_article:object $obj 
    *     Objet comprenant toutes les informations pour insérer une entrée dans la table. 
    *  
    * @return bool
    */
    public function insererArticle($obj)
    {     
        if ($this->connect) {
            $req = 'INSERT INTO article(nom, description, date_p, id_user)
            VALUES(:nom,:description,:date_p,:id_user)';
            $stmt = $this->connect->prepare($req);
            $stmt->bindValue(':nom', $obj->getNom(), \PDO::PARAM_STR);
            $stmt->bindValue(':description', $obj->getDescription(), \PDO::PARAM_STR);
            $stmt->bindValue(':date_p', $obj->getDate_p(), \PDO::PARAM_STR);
            $stmt->bindValue(':id_user', $obj->getId_user(), \PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt && $stmt->rowCount() == 1) {
				return $this->connect->lastInsertId();
            }
        }
        return false;
    }

    /**
    * Requete SQL : 
	* Modification -> UNE entrée dans la table 
	* Necessite -> id, nom, description, date_p, id_user 
    * 
    * @param \entites\Entite_article:object $obj 
    *     Objet comprenant toutes les informations pour modifier une entrée dans la table. 
    *  
    * @return bool
    */
    public function modifArticle($obj)
    {
        if ($this->connect) {
            $req = 'UPDATE article SET 
                    nom=:nom, 
                    description=:description, 
                    date_p=:date_p, 
                    id_user=:id_user 
                    WHERE id=:id';
            $stmt = $this->connect->prepare($req); 
            $stmt->bindValue(':id', $obj->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':nom', $obj->getNom(), \PDO::PARAM_STR);
            $stmt->bindValue(':description', $obj->getDescription(), \PDO::PARAM_STR);
            $stmt->bindValue(':date_p', $obj->getDate_p(), \PDO::PARAM_STR);
            $stmt->bindValue(':id_user', $obj->getId_user(), \PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt && $stmt->rowCount() == 1) {
                return true;
            } 
        }
        return false;
    }

    /**
    * Requete SQL : 
	* Suppression -> UNE entrée dans la table 
	* Necessite -> id
    * 
    * @param int|string $id 
    *     Identifiant de l'entrée à supprimer dans la table 
    *  
    * @return bool
    */
    public function supprArticle($id)
    {
        if ($this->connect) {
            $stmt = $this->connect->prepare('DELETE FROM article WHERE id=:id'); 
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);            
            $stmt->execute();
            if ($stmt && $stmt->rowCount() == 1) {
                return true;
            }
        }
        return false;
    }
} 


?>