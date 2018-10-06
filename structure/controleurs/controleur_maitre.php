<?php 
/**
* Fichier Maitre des Controleurs (Point central des données)
* Concentre toutes les fonctionnalités communes aux Controleurs   
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
* Class \controleurs\Controleur_Maitre
* 
* Classe PHP contenant les méthodes communes à toutes les classes Controleurs  
* 
*/       
class Controleur_Maitre
{
    /**
    * Méthode Constructeur executée à chaque instance des classes Constructeurs (Cf. index.php ou Controleurs) 
    * Permet l'initialisation des sessions serveurs pour une connection utilisateur (sur pages webs) 
    *
    * @return void
    */
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start(); 
        }
        
    }
    
    /**
    * Méthode executée en début d'actions Controleurs 
    * 
    * Autorise les utilisateurs à accéder aux pages selon l'etat de leur connection (SESSION)
    *
    * @return void
    */
	public function redirectionSession($page = '')
	{	
		// Pour toutes pages sauf connection : Si utilisateur non connecté, redirection vers login.php
		if(!isset($_SESSION['user']) && $page == ''){ 
			header('location:index.php?page=connection');
		}
		
		// Si page connection et utilisateur connecté, redirection vers liste des articles	
		if($page == 'connection' && isset($_SESSION['user'])){
			header('location:index.php?page=liste');
		}
		
	} 
	
	/**
    * Prepare la phrase d'affichage en HTML pour utilisateur connecté/non connecté 
    *
    * @return string
    */
	public function userHTML()
	{	
		$user = '<span class="rouge">Non connecté</span>';
		if(isset($_SESSION['user'])){ 
			$user = '<span class="vert">' . $_SESSION['user']['login'] . '</span>';
		}
		return '<p>Utilisateur : ' . $user . '</p>';	
	} 
	
	/**
    * Prepare la phrase d'affichage en HTML pour les erreurs 
    *
    * @return string
    */
	public function errorHTML($msg_erreur)
	{	
		if(!empty($msg_erreur)){
			return '<p class="rouge">' . $msg_erreur . '</p>';
		}
		return '';
	} 
	
	/**
    * Prepare la phrase d'affichage en HTML pour les messages de confirmation  
    *
    * @return string
    */
	public function confirmHTML($msg_confirm)
	{	
		if(!empty($msg_confirm)){
			return '<p class="vert">' . $msg_confirm . '</p>';
		}
		return '';
	} 
	
	/**** Template principal *****/
	
    /**
    * Méthode executée en fin d'actions Controleurs  
    * 
    * Permet d'inclure les fichiers de Vue (Affichage Html) avec le template principal du site. 
    *
    * @param string $control 
    *     Nom de la classe Controleur executant la méthode Render
    *     -> Pour le nom du dossier contenant le fichier de Vue à inclure
    *
    * @param string $action 
    * 	  Nom de la méthode Action executant la méthode Render
    *     -> Pour le nom du fichier de Vue à inclure 
    *
    * @param string $donnees 
    *     Tableau de données à envoyer au fichier de Vue  
    *
    * @return void
    */
    public function render($control, $action, $donnees)
    {
        // Récupération du nom du dossier
		$control = explode('controleurs\\', $control);
        $control = strtolower($control[1]);
		
		// Récupération du nom de l'action
		$action = explode('::', $action);
        $action = strtolower($action[1]);
		
		// Récupération des variables d'affichage (selon les indices du tableau $donnees)
        extract($donnees);
		
		// Mise en route de la mémoire Tampon
        ob_start();
		// Récupération de la Vue dans la mémoire Tampon
        include '../vues/'.$control.'/'.$action.'.php';
		// Récupération de la mémoire Tampon sous forme de chaine de caractère
		$vue = ob_get_clean();
		
		// Manipulation de la chaine de caractère récupérée
        $emoji = [
        ':)' => '&#x1F601',
        ':D' => '&#x1F602',
        ':(' => '&#x1F612',
        ':X' => '&#x1F613',
        '&#x1F601)' => '&#x1F61D',
        '&#x1F612(' => '&#x1F621'
        ];
        foreach ($emoji as $key => $value) {
            $vue = str_replace($key, $value, $vue);
        }
		
		// Données pour le template
		$user = $this->userHTML();
		
		// Affichage du template principal avec utilisation de la chaine de caractère récupérée (Cf. template.php)
        include '../vues/template.php';
    }
} 
?>