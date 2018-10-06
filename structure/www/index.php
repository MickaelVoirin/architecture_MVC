<?php
/**
* Fichier d'initialisation des pages affichées
* -> Fichiers mécanique de routage + injection de dépendance
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

/**** Autoload pour toutes les classes du site - namespaces pris en compte ! *****/
require 'vendor/autoloader.php' ;
$autoload = new Autoloader();
$autoload->splRegister();


/**** Mécanique de routage *****/

// Variables d'initialisation par défaut (Controleur, action, arguments) 
$control = '\controleurs\Controleur_article';
$action = 'actionVoir';
$arg = 0; 
$arg2 = null;

// Selon les elements de l'URL 
if ($_GET) {
    if (isset($_GET['page'])) 
	{
		
		// Fichier du tableau des routes 
        require '../config/routes.php';
		
		// Si correspondance entre URL et indices tableau des routes 
		if (array_key_exists($_GET['page'], $routes))
		{
			// Tableau de valeurs (0 => Controleur, 1 => Action) correspondant à l'indice
			$value = $routes[$_GET['page']];
			
			// Si la classe Controleur ciblée existe
			if (class_exists('\controleurs\\'.ucfirst($value[0])))
			{	
				// Variable Controleur modifiée
				$control = '\controleurs\\'.ucfirst($value[0]);
				
				// Si la méthode Action ciblée existe dans la classe Controleur ciblée
				if (method_exists($control, $value[1]))
				{
					// Variable Action modifiée
					$action = $value[1];
					
					/**** Mécanique : injection de dépendance (Cf. Controleur_article.php - actionUnArticle) *****/
					
					// Récupération d'information sur la méthode Action ciblée
					$reflectMethod = new ReflectionMethod($control, $action);
					// Récupération d'information sur les éventuels arguments de la méthode Action ciblée
					$arguments = $reflectMethod->getParameters();
					
					// Si des arguments existent
					if(!empty($arguments))
					{
						// On parcours le tableau d'objets (les arguments)
						foreach($arguments as $value)
						{
							// Si le nom de l'argument correspond à l'un des paramètres de l'URL (porteur de l'id)
							if (array_key_exists($value->name, $_GET))
							{	
								// Si le parametre de l'URL est une chaine de caractère contenant uniquement un entier
								if (is_numeric($_GET[$value->name]))
								{	
									// 2 exemples selon le type demandé de l'argument en cours
									switch($value->getType())
									{	
										// Autres eventuels types 
										case 'string' :
										case 'array, bool, autres' :
											break;
										// Type entier (INT) : 	
										case 'int' :	
											$arg = intval($_GET[$value->name]);
											break;
											
										/****  injection de dépendance : Instance d'objet spécifique demandé (ici avec Entité) *****/ 
										default :
											
											// Récupération du type de classe demandé pour l'objet ($value->getType()->__toString())
											// ++ Changement dans la chaine de caractère des noms des namespaces + classe par ceux de la classe Modele liée 
											$classe = str_replace('entites\entite', 'modeles\modele', $value->getType()->__toString());
											
											// Instance de la classe Modele liée
											$modele = new $classe();
											// Récupération de la l'Entitée ciblée avec la méthode du Modèle (nom générique) 
											$entite = $modele->selectUn(intval($_GET[$value->name]));
											
											// Si le retour du Modele est ok, Récuperation de l'argument
											if($entite){$arg2 = $entite;}
										
									}
										
								}
								
								
							} 
						}
					}
				}
			}
		
        }
    } 
}

/**** Mécanique de routage FIN *****/

// Instance du controleur et execution de l'action (selon eventuels arguments) 
$control = new $control(); 
$control->$action($arg, $arg2);

   

?>