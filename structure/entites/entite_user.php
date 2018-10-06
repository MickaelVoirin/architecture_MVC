<?php 
/**
* Fichier Entites User - correspond aux champs de la table user
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
* Dossier ../entites 
* @namespace \entites
*/
namespace entites;

/**
* Class \entites\Entite_Article
* 
* Classe PHP dont les objets sont destinés à recevoir ou à envoyer des informations aux entrées de la table user 
* 
*/
class Entite_User
{
    /***** Propriétés *****/
    /**
	* Clé primaire (PK)
	* @var int $id
	*/
    private $id;
	
	/**
	* Login utilisateur
	* @var string $login
	*/
    private $login;
	
	/**
	* Mot de passe utilisateur
	* @var string $mdp
	*/
    private $mdp;
    
	/**
    * Méthode Constructeur executée à chaque instance de cette classe
    * 
    * Les setters sont executés si une instance est effectuée depuis un script 
    * Le constructeur n'execute rien si l'entité est créée depuis un Modèle. 
	*
    * @return void
    */
    public function __construct($donnees = [])
    {
		// Si le constructeur recoit les données sous forme de tableau
		if(!empty($donnees) && is_array($donnees))
		{
			// Pour chaque indice du tableau, une méthode Setters est executée avec la valeur associée.
			foreach($donnees as $key => $value)
			{
				$methodeSet = 'set' . ucfirst($key);
				$this->$methodeSet($value);
			}	
		}
	}
	
	/***** Getters / Accesseurs *****/
	
	/**
    * Recuperation de l'id de l'objet en cours d'utilisation 
    *
    * @return int
    */
	public function getId()
	{
		return $this->id;
	}
	
	/**
    * Recuperation du login de l'objet en cours d'utilisation 
    *
    * @return string
    */
	public function getLogin()
	{
		return $this->login;
	}
	
	/**
    * Recuperation du mot de passe de l'objet en cours d'utilisation 
    *
    * @return string
    */
	public function getMdp()
	{
		return $this->mdp;
	}
	
	/***** Setters / Mutateurs *****/
	
	/**
    * Vérification puis affectation d'une nouvelle information à l'id de l'objet en cours d'utilisation 
    *
    * @return void
    */
	public function setId($newId)
	{
		if(!is_int($newId) && $newId >= 0)
		{
			return trigger_error('L\'id de l\'utilisateur doit être une entier positif');
		}
		$this->id = $newId;
	}
	
	/**
    * Vérification puis affectation d'une nouvelle information au login de l'objet en cours d'utilisation 
    *
    * @return void
    */
	public function setLogin($newLogin)
	{
		if(!is_string($newLogin))
		{
			return trigger_error('Le login de l\'utilisateur doit être une chaine de caractère');
		}
		$this->login = $newLogin;
	}
	
	/**
    * Vérification puis affectation d'une nouvelle information au mot de passe de l'objet en cours d'utilisation 
    *
    * @return void
    */
	public function setMdp($newMdp)
	{
		if(!is_string($newMdp))
		{
			return trigger_error('Le mot de passe de l\'utilisateur doit être une chaine de caractère');
		}
		$this->mdp = $newMdp;
	}
	
}




?>