<?php 
/**
* Fichier Controleur de la table user   
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
* Class \controleurs\Controleur_User extends \controleurs\Controleur_Maitre
* 
* Classe PHP contenant les méthodes Actions liées à la table user 
* Méthodes éxecutées en index.php (ou autre controleurs)
*/ 
class Controleur_User extends Controleur_Maitre
{
    /**
    * Méthode Action de la page 'connection'
    * Traitement du formulaire de connection utilisateurs
    *
    * @return void
    */
    public function actionLogin()
    {
		// Session utilisateur
		$this->redirectionSession('connection');
		
		// Traitement Formulaire
        $msg_erreur = "";
        $msg_valide = "";
        if ($_POST) {
            if (isset($_POST['connection'])) {
                if (empty($_POST['login']) || empty($_POST['mdp'])) {
                    $msg_erreur = "L'un des champs est vide";
                } else {
                    $connectUser = new \modeles\modele_user();
                    $utilisateur = $connectUser->verifUser($_POST);
                    if (!$utilisateur) {
                        $msg_erreur = "Pas de correspondances";
                    } else {
                        $_SESSION['user'] = [
                            'id' => $utilisateur->getId(),
                            'login' => $utilisateur->getLogin()
                        ];
						header('location:index.php?page=liste');
                    }                
                }
            }
        }
		
		// Données à envoyer au fichier de Vue
        
		// Données page 
		$donneesPage = [
			'titreDocument' => 'Connection',
			'titreH2' => 'Se connecter'
		];
		
		// Données principales
		$donnees = [
           'msg_erreur' => $this->errorHTML($msg_erreur),
           'msg_valide' => $msg_valide
        ];
		
		// Toutes données
		$donnees = array_merge($donnees, $donneesPage);
		
		// Affichage de la Vue avec le template principal
        $this->render(__CLASS__, __METHOD__, $donnees);
      
    }
    
    /**
    * Méthode Action de la page 'deconnection'
    * Traitement du lien de déconnection utilisateurs
    * Pas d'affichage lié
    *
    * @return void
    */
    public function actionLogout()
    {
        
		// Deconnection utilisateur
		session_destroy();
		header('location:index.php?page=connection');
            
        
    }
	
	
	/**
    * Méthode executée en Controleur Article - actionVoir 
    * Récupération des éléments User pour transfert à aux objets articles
    * Pas d'affichage lié
    *
    * @return void
    */
    public function userElements($id)
    {
		
		$msg_erreur = '';
		
		// Récupération et vérification des éléments en table
        $connectUser = new \modeles\modele_user();
        $user = $connectUser->selectUnUser($id) ;
        if (!$user) {
            $msg_erreur = 'Probleme avec la table user, id : ' . $id . '<br>';
        }   
		
		// Données retournées
		return [
			'msg_erreur' => $msg_erreur,
			'id_user' => intval($user['id']),
			'login' => $user['login'],
		];
            
        
    }
    
}

?>