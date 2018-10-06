<?php 
/**
* Vue page Connection => controleur_article - actionSuppr()
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
<!-- Formulaire Suppression -->
<form method="post" action="?page=supprimer" <?php echo $afficheForm; ?>>  
	<p>
		<?php echo $select; ?>
	</p>
	<p>
		<input type="submit" name="supprimer" id="supprimer">
	 </p>
        
</form>        
    