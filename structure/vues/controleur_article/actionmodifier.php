<?php 
/**
* Vue page Connection => controleur_article - actionModifier()
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
?>  
<!-- Formulaire Choix article -->
<form method="post" action="?page=modifier">  
	<p>
		<?php echo $select; ?>
	</p>
	<p>
		<input type="submit" name="selectionner" id="selectionner">
	 </p>
        
</form>  
<hr>
<!-- Selon article -->
<div <?php echo $afficheArticle; ?>>
	<!-- Fiche article -->
	<h3>Fiche : </h3>
	<?php echo $articleHTML; ?>
	<!-- Formulaire de modification -->
	<h3>Modifier les éléments : </h3>
	<?php echo $msg_erreur_2; ?>  
	<form method="post" action="">  
		<p>
			 <label for="nom">Nom :</label> 
			 <input type="text" name="nom" id="nom" value="<?php echo $valeurNom; ?>" >
		 </p>
		 <p>
			 <label for="description">Description :</label><br> 
			 <textarea name="description" id="description" ><?php echo $valeurDescription; ?></textarea>
		 </p>
		 <p>
			 <label for="id">Description :</label><br> 
			 <input type="hidden" name="id" id="id" value="<?php echo $valeurId; ?>">
		 </p>
		<p>
			<input type="submit" name="modifier" id="modifier">
		 </p>
			
	</form>  
</div>