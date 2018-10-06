<?php 
/**
* Template HTML principal   
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
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Module MVC : <?php echo $titreDocument ?></title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="lib/styles/styles.css">
    </head>
    <body>
        <h1>Module MVC</h1>
        
        <nav>
            <ul>
				<?php 
				if(!isset($_SESSION['user']))
				{
				?>
					<li><a href="index.php?page=liste">Liste des articles</a></li>
					<li><a href="index.php?page=connection">Connection</a></li>
                <?php 
				}
				else 
				{
				?>	
					<li><a href="index.php?page=liste">Liste des articles</a></li>
					<li><a href="index.php?page=unarticle">Voir un article</a></li>
					<li><a href="index.php?page=ajouter">Ajouter un article</a></li>
					<li><a href="index.php?page=modifier">Modifier un article</a></li>
					<li><a href="index.php?page=supprimer">Supprimer un article</a></li>
					<li><a href="index.php?page=deconnection">Déconnection</a></li>
				<?php 
				} 
				?>
            </ul>
        </nav>
     
        <section>
        <?php 
			// Affichage de l'utilisateur connecté/non connecté
			echo $user;
		?>
		<h2><?php echo $titreH2 ?></h2>
        <hr>
		<?php
			/**** Affichage de la Vue ciblée *****/
			echo $vue; 
		?>
        </section>
        
    </body>
</html>
    