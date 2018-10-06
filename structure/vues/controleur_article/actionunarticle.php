<?php 
/**
* Vue page Connection => controleur_article - actionUnArticle()
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
?>
		
<!-- Formulaire Choix article -->
<h3>Choisir un article</h3>
<form action="" method="post">
	<p>
		<?php echo $select; ?>
	</p>
	<p>
		<input type="submit" name="selectionner" id="selectionner">
	 </p>
</form>
<hr>
<!-- Fiche article -->
<?php 
echo $articleHTML;
?>
<div <?php echo $afficheArticle; ?>>
	
<!-- Commentaires associés -->
	<div <?php echo $afficheCommentaires; ?>>
		<h3>Commentaires sur l'article : </h3>
			<?php 
				echo $listeCommentairesHTML;
			?>
	</div>

<!-- Formulaire nouveau Commentaire -->
	<div <?php echo $afficheFormCommentaires; ?>>
		<?php echo $msg_erreur_2; ?>
		<h3>Soumettre un commentaire : </h3>
		<form action="index.php?page=unarticle&article=<?php echo $idArticle; ?>" method="post">
			<p>
				<label for="sujet">Sujet :</label> 
				<input type="text" name="sujet" id="sujet" value="<?php echo $valeurSujet; ?>">
			</p>
			<p>
				<label for="message">Message :</label> 
				<textarea id="message" name="message"><?php echo $valeurMessage; ?></textarea>
			</p>
			<p>
				<input type="submit" name="commenter" value="Poster le commentaire">
			</p>
		</form>
	</div>
</div>
        
        
    