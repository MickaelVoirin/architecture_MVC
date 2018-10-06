<?php 
/**
* Vue page Connection => controleur_article - actionAjouter()
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

echo $msg_erreur;
echo $msg_confirm;
echo $article;
?>  
<!-- Formulaire d'ajout -->
<form method="post" action="?page=ajouter">
	 <p>
		 <label for="nom">Nom :</label> 
		 <input type="text" name="nom" id="nom" value="<?php echo $valeurNom; ?>">
	 </p>
	 <p>
		 <label for="description">Description :</label><br> 
		 <textarea name="description" id="description"><?php echo $valeurDescription; ?></textarea>
	 </p>
	 <p>
		<input type="submit" name="ajouter" id="ajouter">
	 </p>
</form>

