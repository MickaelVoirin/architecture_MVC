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
class Entite_Commentaire
{
    /***** Propriétés *****/
    /**
	* Clé primaire (PK)
	* @var int $id
	*/
    private $id;
	
	/**
	* Sujet du commentaire
	* @var string $sujet
	*/
    private $sujet;
	
	/**
	* message du commentaire
	* @var string $message
	*/
    private $message;
	
	/**
	* Date de publication du commentaire
	* @var string $date_p
	*/
    private $date_p;
	
	/**
	* Article commenté (FK)
	* @var int $id_article
	*/
    private $id_article;
	
	/**
	* Auteur (id) du commentaire (FK)
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
    * Recuperation du sujet de l'objet en cours d'utilisation 
    *
    * @return string
    */
	public function getSujet()
	{
		return $this->sujet;
	}
	
	/**
    * Recuperation du message de l'objet en cours d'utilisation 
    *
    * @return string
    */
	public function getMessage()
	{
		return $this->message;
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
    * Recuperation de l'article lié à l'objet en cours d'utilisation 
    *
    * @return int
    */
	public function getId_article()
	{
		return $this->id_article;
	}
	
	/**
    * Recuperation de l'auteur (ID) de l'objet en cours d'utilisation 
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
			return trigger_error('L\'id du commentaire doit être une entier positif');
		}
		$this->id = $newId;
	}
	
	/**
    * Vérification puis affectation d'une nouvelle information au sujet de l'objet en cours d'utilisation 
    *
    * @return void
    */
	public function setSujet($newSujet)
	{
		if(!is_string($newSujet))
		{
			return trigger_error('Le sujet du commentaire doit être une chaine de caractère');
		}
		$this->sujet = $newSujet;
	}
	
	/**
    * Vérification puis affectation d'une nouvelle information au message de l'objet en cours d'utilisation 
    *
    * @return void
    */
	public function setMessage($newMessage)
	{
		if(!is_string($newMessage))
		{
			return trigger_error('Le message du commentaire doit être une chaine de caractère');
		}
		$this->message = $newMessage;
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
			return trigger_error('La date de publication du commentaire doit être une chaine de caractère');
		}
		$this->date_p = $newDate_p;
	}
	
	/**
    * Vérification puis affectation d'une nouvelle information à l'article lié à l'objet en cours d'utilisation 
    *
    * @return void
    */
	public function setId_article($newId_article)
	{
		if(!is_int($newId_article) && $newId_article >= 0)
		{
			return trigger_error('L\'id de l\'article au commentaire doit être une entier positif');
		}
		$this->id_article = $newId_article;
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
			return trigger_error('L\'id de l\'auteur lié au commentaire doit être une entier positif');
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
			return trigger_error('Le login du commentaire doit être une chaine de caractère');
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
		return '<article class="commentaires">
						<p><b>Auteur</b> : '.$this->getLogin().'</p>
						<p><b>Posté le</b> : '.$this->getDate_p().'</p>
						<p><b>Sujet</b> : '.$this->getSujet().'<p><b>Message</b> : '.$this->getMessage().'</p>
					</article>
					';
	}
}


?>