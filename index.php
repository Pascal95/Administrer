<?php
                        
/* Ici on inclut notre Script où se trouve la fonction */
require_once('AntiBruteForceFichier.php');

/* Ce sera notre page d'index pour notre exemple.
 * Dans cette page se trouve le formulaire de connexion et les traitements de ce dernier y compris l'anti brute force
 *  
 */

if(VerificationQuotas('C:/wamp/www/TutoBruteForce/ParFichier/BruteForce')){

    echo 'Vous êtes bien identifié.';

}
else{
    /* 
     * Formulaire de connexion 
     * Avec juste un champ pour le login et un autre pour le mot de passe
     *      
     */
    
    echo '
        <form action="" method="post">
        <label for="Log">Login : </label><input type="text" name="Login" value="" size="40" id="Log"/><br />
        <label for="Mdp">Mot de passe : </label><input type="password" name="Mdp" value="" size="40" id="Mdp"/><br />
        <input type="submit" name="Send" value="Connexion" />
        </form>';
}
?>