<?php 
/**
* Fichier Controleur de la table article   
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
* Dossier ../controleurs 
* @namespace \controleurs
*/
namespace controleurs;

/**
* Class \controleurs\Controlleur_Article extends \controleurs\Controleur_Maitre
* 
* Classe PHP contenant les méthodes Actions liées à la table article 
* 
*/ 
class Controleur_Article extends Controleur_Maitre
{

    /**
    * Méthode Action de la page 'liste'
	* -> Afficher TOUT les articles
	* 
    * Récupération des données avec la classe Modele des articles (BDD)
    * Traitement et envoie des données à la Vue
    *
    * @return void
    */
    public function actionVoir()
    {
		
		// Variables par defaut
		$msg_erreur = '';
		$listeHTML = '';
		
		// Récupération et vérification des éléments en table
        $connectArticle = new \modeles\modele_article();
        $articles = $connectArticle->selectToutArticle();
        if (!$articles) {
            $msg_erreur = 'Probleme avec la table article';
        }   
        
		// Récupération du format Html de toutes les entités ciblées (Cf. entité article)
		if(empty($msg_erreur))
		{
			
			// Elements Login utilisateur - Controleur_User - action userElements
			$userElements = new Controleur_User();
			
			foreach($articles as $key => $value)
			{
				$elements = $userElements->userElements($value->getId_user());
				if($elements['msg_erreur']){
					$msg_erreur = $elements['msg_erreur'];
				}
				else{
					$value->setId_user($elements['id_user']);
					$value->setLogin($elements['login']);
					
					// Format HTML de l'entité en cours de boucle
					$listeHTML .= $value->getHTML();
				}
			}
		
		}
		
		// Données à envoyer au fichier de Vue
        
		// Données page 
		$donneesPage = [
			'titreDocument' => 'Liste des articles',
			'titreH2' => 'Tout les articles'
		];
		
		// Données principales
        $donnees = [
            'msg_erreur' => $this->errorHTML($msg_erreur),
			'listeHTML' => $listeHTML
        ];
		
		// Toutes données
		$donnees = array_merge($donnees, $donneesPage);
		
		// Affichage de la Vue avec le template principal
        $this->render(__CLASS__, __METHOD__, $donnees);
     
    }

	
    /**
    * Méthode Action de la page 'ajouter'
	* -> ajouter UN article
	*
	* Injection de dépendance, la fiche de l'article est chargée.
	*
    * @param int $id 
    *     Cas 1 : ID correspondant à l'entrée ciblée dans la table  
    *	
    * @param \entites\Entite_user::object $article 
    *     Cas 2 (Injection de dépendance) : Entitée ciblée avec toutes ses données  
    *
    * @return void
    */
    public function actionAjouter(int $id = 0, \entites\entite_Article $article = null)
    {
		
		// Session utilisateur
		$this->redirectionSession();
		
		
        $msg_erreur = "";
        $msg_confirm = "";
		
		
		// Traitement Formulaire
		if ($_POST) {
			
			// Vérifications
			if (isset($_POST['ajouter'])) {
				if (empty($_POST['nom']) || empty($_POST['description'])) {
					$msg_erreur = "L'un des champs est vide";
				} else {
			
			// Preparation des données pour le constructeur des entités			
					$donneesForm = [
						'nom' => $_POST['nom'],
						'description' => $_POST['description'],
						'date_p' => date('Y-m-d'),
						'id_user' => intval($_SESSION['user']['id']),
					];
			// Objet Entité 
					$newArticle = new \entites\entite_article($donneesForm);
					
			// Appel Modele et insertion en table de l'entité
					$connectArticle = new \modeles\modele_article();
					$idInsert = $connectArticle->insererArticle($newArticle);
			
			// Aprèes ajout : l'id de l'entrée insérée en table est vérifié
			// Si false
					if (!$idInsert) 
					{
						$msg_erreur = 'Probleme avec l\'insertion';
					}
			// Si ok, redirection
					else 
					{
						header('location:index.php?page=ajouter&article=' . $idInsert);
					}
				}
			}
		}
        
		
		// Affichage de l'élément ajouté (en cas d'injection de dépendance)
		$articleHTML = '';
		if($article != null)
		{
			// Element Auteur (login) - cf Controleur user, action userElements
			$userElements = new Controleur_User();
			$elements = $userElements->userElements($_SESSION['user']['id']);
			if($elements['msg_erreur']){
				$msg_erreur = $elements['msg_erreur'];
			}
			else{
				$article->setLogin($elements['login']);
			}
			// Fiche HTML de l'entité
			$articleHTML = $article->getHTML();
			$msg_confirm = 'L\'article à bien été ajouté';
		}
		
		
		// Valeurs des champs en cas de POST 
		$valueNom = '';
		$valueDescription = '';
		if($_POST && isset($_POST['nom']) && isset($_POST['description']))
		{
			$valueNom = $_POST['nom'];
			$valueDescription = $_POST['description'];
		}
		
		
		// Données à envoyer au fichier de Vue
        
		// Données page 
		$donneesPage = [
			'titreDocument' => 'Ajouter un article',
			'titreH2' => 'Ajouter un article'
		];
		
		// Données principales
        $donnees = [
            'msg_erreur' => $this->errorHTML($msg_erreur),
            'msg_confirm' => $this->confirmHTML($msg_confirm),
            'article' => $articleHTML,
            'valeurNom' => $valueNom,
            'valeurDescription' => $valueDescription
        ];
		
		// Toutes données
		$donnees = array_merge($donnees, $donneesPage);
		
		// Affichage de la Vue avec le template principal
        $this->render(__CLASS__, __METHOD__, $donnees); 

    }

	
    /**
    * Méthode Action de la page 'modifier'
	* -> modifier UN article à la fois
	* 
    * Traitement des formulaires de modification d'articles  avec la classe Modele des articles (BDD)
    * Traitement et envoie des données à la Vue
    *
    * @return void
    */
    public function actionModifier(int $id = 0, \entites\entite_Article $article = null)
    {
		// Session utilisateur
		$this->redirectionSession();
		
		$msg_erreur = "";
		$msg_erreur_2 = "";
        $msg_confirm = "";
        
		// Connection à la table article
		$connectArticle = new \modeles\modele_article();
		$articles = $connectArticle->selectToutArticle();
        if (!$articles) {
            $msg_erreur = 'Probleme avec la table article';
        }   
        
		// Affichage champs <select> en formulaire
		$select = '<label for="liste">Choisir l\'article à modifier : </label>
					<select name="liste" id="liste">
					<option value="0">Selectionner l\'article</option>';
		foreach($articles as $key => $value)
		{
			$selected = '';
			if($article != null && $article->getId() == $value->getId())
			{
				$selected = ' selected ';
			}
			$select .= '<option value="' . $value->getId() . '" ' . $selected . '>' . $value->getNom() . '</option>';
		}
		$select .= '</select>';
        
		// Traitement formulaires - 1 : Selection de l'article 
		if($_POST)
		{
			if(isset($_POST['selectionner'])){
				if(isset($_POST['liste']) && $_POST['liste'] > 0) 
				{
					header('location:index.php?page=modifier&article=' . $_POST['liste']);
				}
				else
				{
					$msg_erreur = 'Selectionner un article!'; 
				}
			}
		}
		
		// Traitement formulaires - 2 : Modification de l'article 
		if($_POST)
		{
			
			// Vérifications
			if(isset($_POST['modifier']) && $article != null && isset($_POST['id']) && $_POST['id'] > 0)
			{
				
				if (empty($_POST['nom']) || empty($_POST['description'])) {
					$msg_erreur_2 = "L'un des champs est vide";
				} else {
			
			// Preparation des données pour le constructeur des entités			
					$donneesForm = [
						'id' => intval($_POST['id']),
						'nom' => $_POST['nom'],
						'description' => $_POST['description'],
						'date_p' => date('Y-m-d'),
						'id_user' => intval($_SESSION['user']['id']),
					];
			// Objet Entité 
					$article = new \entites\entite_article($donneesForm);
			// Elements utilisateurs

			
			// Appel Modele et insertion en table de l'entité
					$connectArticle = new \modeles\modele_article();
					$modif = $connectArticle->modifArticle($article);
			
			// Aprèes ajout : l'id de l'entrée insérée en table est vérifié
			// Si false
					if (!$modif) 
					{
						$msg_erreur_2 = 'Probleme avec la modification';
					}
			// Si ok, redirection
					else 
					{
						header('location:index.php?page=modifier&article=' . $_POST['id']);
					}
				}
			}
			
		}
		
		
		// Affichage de l'élément a modifier + élément formulaire de modification (en cas d'injection de dépendance / Post du premier formulaire)
		$articleHTML = '';
		$valueNom = '';
		$valueDescription = '';
		$valueId = '';
		$afficheArticle = 'style="display:none"';
		if($article != null)
		{
			// Element Auteur (login) - cf Controleur user, action userElements
			$userElements = new Controleur_User();
			$elements = $userElements->userElements($article->getId_user());
			if($elements['msg_erreur']){
				$msg_erreur = $elements['msg_erreur'];
			}
			else{
				$article->setLogin($elements['login']);
			}
			
			// Fiche HTML de l'entité
			$articleHTML = $article->getHTML();
			
			// Elements pour le formulaire
			$valueNom = $article->getNom();
			$valueDescription = $article->getDescription();
			$valueId = $article->getId();
			$afficheArticle = 'style="display:block"';
		}
		
		
		// Valeurs des champs conservé en cas de POST 2 mais avec une erreur
		if($_POST && isset($_POST['modifier']) && !empty($msg_erreur_2))
		{
			$valueNom = $_POST['nom'];
			$valueDescription = $_POST['description'];
		} 
		
		
		// Données à envoyer au fichier de Vue
        
		// Données page 
		$donneesPage = [
			'titreDocument' => 'Modifier un article',
			'titreH2' => 'Modifier un article'
		];
		
        $donnees = [
            'msg_erreur' => $this->errorHTML($msg_erreur),
            'msg_erreur_2' => $this->errorHTML($msg_erreur_2),
            'msg_confirm' => $this->confirmHTML($msg_confirm),
            'select' => $select,
            'articleHTML' => $articleHTML,
			'valeurNom' => $valueNom,
            'valeurDescription' => $valueDescription,
            'valeurId' => $valueId,
            'afficheArticle' => $afficheArticle
        ];
		
		// Toutes données
		$donnees = array_merge($donnees, $donneesPage);
		
		// Affichage de la Vue avec le template principal
        $this->render(__CLASS__, __METHOD__, $donnees);
    }

	
    /**
    * Méthode Action de la page 'supprimer'
	* -> supprimer UN article à la fois
	* 
    * Traitement des formulaires de suppression d'articles avec la classe Modele des articles (BDD)
    * Traitement et envoie des données à la Vue
    *
    * @return void
    */
    public function actionSuppr()
    {
		
		// Session utilisateur
		$this->redirectionSession();
		
        $msg_erreur = "";
        $msg_confirm = "";
        
		// Connection à la table article
		$connectArticle = new \modeles\modele_article();
		$articles = $connectArticle->selectToutArticle();
        if (!$articles) {
            $msg_erreur = 'Probleme avec la table article';
        }   
        
		// Affichage champs <select> en formulaire
		$select = '<label for="liste">Choisir l\'article à supprimer : </label>
					<select name="liste" id="liste">
					<option value="0">Selectionner l\'article</option>';
		foreach($articles as $key => $value)
		{
			$select .= '<option value="' . $value->getId() . '">' . $value->getNom() . '</option>';
		}
		$select .= '</select>';
		

		// Traitement formulaire
		$afficheForm = 'block';
		if($_POST)
		{
			if(isset($_POST['supprimer']) && isset($_POST['liste']) && $_POST['liste'] > 0) {
				$delete = $connectArticle->supprArticle($_POST['liste']);   				
				if (!$delete) 
				{
					$msg_erreur = 'Probleme avec la supression en BDD'; 
				} else 
				{	
					// Si ok, confirmation et actualisation de la page (2sec)
					$msg_confirm = 'Element supprimé (id = '. $_POST['liste'] .')'; 
					$afficheForm = 'none';
					header('refresh:2');
				}
			} else
			{
				$msg_erreur = 'Selectionner un article!'; 
			}
		}
		$afficheForm = 'style="display:' . $afficheForm . '"';

		
		// Données à envoyer au fichier de Vue
        
		// Données page 
		$donneesPage = [
			'titreDocument' => 'Supprimer un article',
			'titreH2' => 'Supprimer un article'
		];
		
		// Données principales
        $donnees = [
            'msg_erreur' => $this->errorHTML($msg_erreur),
            'msg_confirm' => $this->confirmHTML($msg_confirm),
            'select' => $select,
            'afficheForm' => $afficheForm
        ];
		
		// Toutes données
		$donnees = array_merge($donnees, $donneesPage);
		
		// Affichage de la Vue avec le template principal
        $this->render(__CLASS__, __METHOD__, $donnees);  

    }

    /**
    * Méthode Action de la page 'unarticle'
	* -> Afficher UN article
	* 
    * Récupération des données avec la classe Modele des articles (BDD)
    * Traitement et envoie des données à la Vue
	*
    * @param int $id 
    *     Cas 1 : ID correspondant à l'entrée ciblée dans la table  
    *
    * @param \entites\Entite_article::object $article 
    *     Cas 2 (Injection de dépendance) : Entitée ciblée avec toutes ses données  
    *
    * @return void
    */
    public function actionUnArticle(int $id = 0, \entites\entite_Article $article = null) 
    {
	
        
        $msg_erreur = "";
        $msg_erreur_2 = "";
		
		
        // Traitement du formulaire de choix des articles
		// Cas de l'argument 1 pris en compte
		if (($_POST && isset($_POST['selectionner'])) || $id > 0) {
            if (isset($_POST['selectionner'])) 
			{
                $id = $_POST['liste'];
            } 
			// Récupération et vérification de l'élément en table
            $connectArticle = new \modeles\modele_article();
            $article = $connectArticle->selectUnArticle($id);
            if (!$article) 
			{
                $msg_erreur = 'Mauvais id pour l\'article';
            } 
        } 
		
		
		
		// Traitement Formulaire insertion commentaire / depend del'utilisateur et de l'article
		
		// Si utilisateur non connecté
		if($_POST && isset($_POST['commenter']) && !isset($_SESSION['user']))
		{
			$msg_erreur = "Il faut etre connecté pour poster un commentaire!!!!";
		} 
		
		$valueSujet = '';
		$valueMessage = '';
		if ($_POST && isset($_POST['commenter']) && isset($_SESSION['user']['id']) && $article != null) {
			
			$commentairesForm = new controleur_commentaire();
			$verifForm = $commentairesForm->verifCommForm($_POST, $article, $_SESSION);
			
			if(!empty($verifForm)){
				$msg_erreur_2 = $verifForm;
			}
			
			// Valeurs des champs conservé en cas d'erreur
			if(!empty($msg_erreur_2))
			{
				$valueSujet = $_POST['sujet'];
				$valueMessage = $_POST['message'];
			} 
			
		}
		
		// Champs select
		
		// Connection à la table article pour tout les noms d'articles
		$connectArticle = new \modeles\modele_article();
		$articles = $connectArticle->selectToutArticle();
        if (!$articles) {
            $msg_erreur = 'Probleme avec la table article';
        }   

		// Affichage champs <select> en formulaire
		$select = '<label for="liste">Choisir l\'article à visionner : </label>
					<select name="liste" id="liste">
					<option value="0">Selectionner l\'article</option>';
		
		foreach($articles as $key => $value)
		{
			$selected = '';
			if($article != null && $article->getId() == $value->getId())
			{
				$selected = ' selected ';
			}
			$select .= '<option value="' . $value->getId() . '" ' . $selected . '>' . $value->getNom() . '</option>';
		}
		$select .= '</select>';
		
		
		
		// Affichage de TOUT les éléments (en cas d'injection de dépendance ou post - $article)
		$articleHTML = "";
		$listeCommentairesHTML = "";
		$afficheArticle = 'none';
		$afficheCommentaires = 'none';
		$userCommentaire = true;
		$valueId = 0;
		if($article != null)
		{
				
			$valueId = $article->getId();
			// Element Auteur (login) - cf Controleur user, action userElements
			$userElements = new Controleur_User();
			$elements = $userElements->userElements($article->getId_user());
			if($elements['msg_erreur']){
				$msg_erreur = $elements['msg_erreur'];
			}
			else{
				$article->setLogin($elements['login']);
			}
			
			// Fiche HTML de l'entité
			$articleHTML = $article->getHTML();
			// Affichage TOUT elements article
			$afficheArticle = 'block';
			
			// Récupération et vérification des commentaires liés selon l'utilisateur connecté
			$idUserConnecte = 0;
			if(isset($_SESSION['user']['id'])){
				$idUserConnecte = $_SESSION['user']['id'];
			}
			$commentairesElements = new controleur_commentaire();
			$commentaires = $commentairesElements->commentairesElements($article->getId(), $idUserConnecte);
			
			if(!empty($commentaires['msg_erreur'])){
				$msg_erreur = $commentaires['msg_erreur'];
			}
			else if(!empty($commentaires['listeHTML']))
			{
				$listeCommentairesHTML = $commentaires['listeHTML'];
				$afficheCommentaires = 'block';
			}
			$userCommentaire = $commentaires['userCommentaire'];
		}
		$afficheArticle = 'style="display:' . $afficheArticle . '"';
		$afficheCommentaires = 'style="display:' . $afficheCommentaires . '"';
	
		
		// Affichage du formulaire de commentaires selon user connecté
		$afficheFormCommentaires = 'block';
		if(!$userCommentaire)
		{
			$afficheFormCommentaires = 'none';
		}
		$afficheFormCommentaires = 'style="display:' . $afficheFormCommentaires . '"';
		
		// Données à envoyer au fichier de Vue
        
		// Données page 
		$donneesPage = [
			'titreDocument' => 'Voir un article',
			'titreH2' => 'Voir un article'
		];
		
		// Données principales
        $donnees = [
            'msg_erreur' => $this->errorHTML($msg_erreur),
            'msg_erreur_2' => $this->errorHTML($msg_erreur_2),
            'select' => $select,
            'articleHTML' => $articleHTML,
            'listeCommentairesHTML' => $listeCommentairesHTML,
            'afficheArticle'=> $afficheArticle,
            'afficheCommentaires'=> $afficheCommentaires,
            'afficheFormCommentaires'=> $afficheFormCommentaires,
            'valeurSujet'=> $valueSujet,
            'valeurMessage'=> $valueMessage,
            'idArticle'=> $valueId
        ];
		
		// Toutes données
        $donnees = array_merge($donnees, $donneesPage);
        
		// Affichage de la Vue avec le template principal
		$this->render(__CLASS__, __METHOD__, $donnees); 
		
    }

}



?>