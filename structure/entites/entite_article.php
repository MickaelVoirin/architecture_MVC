<?php 
/**
* Fichier Entites Article - correspond aux champs de la table article
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
* Classe PHP dont les objets sont destinés à recevoir ou à envoyer des informations aux entrées de la table article 
* 
*/
class Entite_Article
{
	/***** Propriétés *****/
    /**
	* Clé primaire (PK)
	* @var int $id
	*/
    private $id;
	
	/**
	* Nom de l'article
	* @var string $nom
	*/
    private $nom;
    
	/**
	* Description de l'article
	* @var string $description
	*/
	private $description;
	
	/**
	* Date de publication de l'article
	* @var string $date_p
	*/
    private $date_p;
    
	/**
	* Auteur (id) de l'article (FK)
	* @var int $id_user
	*/
	private $id_user;
    
	/**
	* Auteur (login) du commentaire
	* @var int $login
	*/
    private $login;
	
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
    * Recuperation du nom de l'objet en cours d'utilisation 
    *
    * @return string
    */
	public function getNom()
	{
		return $this->nom;
	}
	
	/**
    * Recuperation de la description de l'objet en cours d'utilisation 
    *
    * @return string
    */
	public function getDescription()
	{
		return $this->description;
	}
	
	/**
    * Recuperation de la date de publication de l'objet en cours d'utilisation 
    *
    * @return string
    */
	public function getDate_p()
	{
		return $this->date_p;
	}
	
	/**
    * Recuperation de l'auteur de l'objet en cours d'utilisation 
    *
    * @return int
    */
	public function getId_user()
	{
		return $this->id_user;
	}
	
	/**
    * Recuperation de l'auteur (Login) de l'objet en cours d'utilisation 
    *
    * @return string
    */
	public function getLogin()
	{
		return $this->login;
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
			return trigger_error('L\'id de l\'article doit être une entier positif');
		}
		$this->id = $newId;
	}
	
	/**
    * Vérification puis affectation d'une nouvelle information au nom de l'objet en cours d'utilisation 
    *
    * @return void
    */
	public function setNom($newNom)
	{
		if(!is_string($newNom))
		{
			return trigger_error('Le nom de l\'article doit être une chaine de caractère');
		}
		$this->nom = $newNom;
	}
	
	/**
    * Vérification puis affectation d'une nouvelle information à la description de l'objet en cours d'utilisation 
    *
    * @return void
    */
	public function setDescription($newDescription)
	{
		if(!is_string($newDescription))
		{
			return trigger_error('La description de l\'article doit être une chaine de caractère');
		}
		$this->description = $newDescription;
	}
	
	/**
    * Vérification puis affectation d'une nouvelle information à la date de publication de l'objet en cours d'utilisation 
    *
    * @return void
    */
	public function setDate_p($newDate_p)
	{
		if(!is_string($newDate_p))
		{
			return trigger_error('La date de publication de l\'article doit être une chaine de caractère');
		}
		$this->date_p = $newDate_p;
	}
	
	/**
    * Vérification puis affectation d'une nouvelle information à l'auteur de l'objet en cours d'utilisation 
    *
    * @return void
    */
	public function setId_user($newId_user)
	{
		if(!is_int($newId_user) && $newId_user >= 0)
		{
			return trigger_error('L\'id de l\'auteur lié à l\'article doit être une entier positif');
		}
		$this->id_user = $newId_user;
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
			return trigger_error('Le login de l\'auteur lié à l\'article doit être une chaine de caractère');
		}
		$this->login = $newLogin;
	}
	
	
	/***** Autres Méthodes *****/
	
	/**
    * Format HTML de l'entité avec tous ses éléments
    *
    * @return void
    */
	public function getHTML()
	{
		return '<article>
						<p><b>' . $this->getId() . ' - 
							<a href="index.php?page=unarticle&article='. $this->getId() .'">' . $this->getNom() .'</a>
						</b></p>
						<p>'. $this->getDescription() .'</p>
						<p>
						<i>Posté le : '. $this->getDate_p() .' - par ' . $this->getLogin() . '</i></p>
					</article>
					<hr>'; 
	}
}




?>