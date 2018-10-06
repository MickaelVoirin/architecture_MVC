<?php 
/**
* Fichier Controleur de la table commentaire   
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
* Class \controleurs\Controleur_Commentaire extends \controleurs\Controleur_Maitre
* 
* Classe PHP contenant les méthodes Actions liées à la table commentaire 
* 
*/ 
class Controleur_Commentaire extends Controleur_Maitre
{
	
	/**
    * Méthode executée en Controleur Article - actionUnArticle 
    * Récupération des éléments commentaires selon un article
    * Pas d'affichage lié
    *
    * @return array[string => mixed]
    */
    public function commentairesElements($id_article, $userConnecte)
    {
		
		$msg_erreur = '';
		$listeHTML = '';
		$userCommentaire  = true;
		
		// Récupération et vérification des éléments en table
        $connectCommentaire = new \modeles\modele_commentaire();
        $commentaires = $connectCommentaire->selectToutCommentaires($id_article) ;
		
        if (!$commentaires && is_bool($commentaires)) 
		{
            $msg_erreur = 'Probleme avec la table commentaire, id_article : ' . $id_article . '<br>';
        } 
		
		// Si non connecte le fomrulaire ne s'affiche pas
		if($userConnecte == 0){
			$userCommentaire  = false;
		}
		
		// Récupération du format Html de toutes les entités ciblées (Cf. entité commentaire)
		if(empty($msg_erreur))
		{
			
			// Elements Login utilisateur - Controleur_User - action userElements
			$userElements = new Controleur_User();
			foreach($commentaires as $key => $value)
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
				// User connecté = auteur commentaire ?
				if($userConnecte == $elements['id_user'])
				{
					$userCommentaire = false;
				}
				
			}
			
		}   
		
		// Données retournées
		return [
			'msg_erreur' => $msg_erreur,
			'listeHTML' => $listeHTML,
			'userCommentaire' => $userCommentaire 
		];
            
        
    }
	
	/**
    * Méthode executée en Controleur Article - actionUnArticle 
    * Vérifiaction du formulaire des commentaires et insertion en base
    * 
    *
    * @return void | string
    */
    public function verifCommForm($post, $article, $session)
    {
		$msg_erreur = "";
		
		// Champs vides
			if (empty($post['sujet']) || empty($post['message'])) {
				$msg_erreur = "L'un des champs est vide";
			}
		
			// Commentaire déjà posté par l'utilisateur ?
			$commentaires = $this->commentairesElements($article->getId(), $session['user']['id']);
			
			if(!$commentaires['userCommentaire'])
			{
				$msg_erreur = "Vous avez déjà posté un commentaire!!!!";
			} 
			
			
			if(empty($msg_erreur))
			{
		
		// Preparation des données pour le constructeur des entités			
				$donneesForm = [
					'sujet' => $post['sujet'],
					'message' => $post['message'],
					'date_p' => date('Y-m-d H:i:s'),
					'id_article' => intval($article->getId()),
					'id_user' => intval($session['user']['id']),
				];
		// Objet Entité 
				$newCommentaire = new \entites\entite_commentaire($donneesForm);
				
		// Appel Modele et insertion en table de l'entité
				$connectCommentaire = new \modeles\modele_commentaire();
				$idInsert = $connectCommentaire->insererCommentaire($newCommentaire);
		
		// Aprèes ajout : l'id de l'entrée insérée en table est vérifié
		// Si false
				if (!$idInsert) 
				{
					$msg_erreur = 'Probleme avec l\'insertion du commentaire';
				}
		// Si ok, redirection
				else 
				{
					header('location:index.php?page=unarticle&article=' . $article->getId());
				}
			}
        
		return $msg_erreur;	
        
    }
	
	
}

?>