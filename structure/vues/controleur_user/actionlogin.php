<?php 
/**
* Vue page Connection => controleur_user - actionLogin()
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
<!-- Formulaire de modification -->
<form method="post" action="">
	<p>
		<label for="login">Votre email :</label> 
		<input type="text" name="login" id="login">
	</p>
	<p>
		<label for="mdp">Votre mdp :</label> 
		<input type="password" name="mdp" id="mdp">
	</p>
	<p>
		<input type="submit" name="connection" id="connection">
	</p>
</form>
           
    