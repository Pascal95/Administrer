<?php
/* Ce script ne comportera que la fonction pour la vérification
 * Cette fonction servira aussi pour faire l'authentification 
 */

function VerificationQuotas($CheminFichierQuotas, $Quotas = 20){

    /* On va vérifier qu'aucun des deux champs n'est vide */
    if (!empty($_POST['Login']) && !empty($_POST['Mdp'])){
    
        $LoginH = md5(trim($_POST['Login'])); //On hashe notre Login en ayant enlevé les espaces et les caractères bizarres en début et fin de chaine
        $MdpH   = md5(trim($_POST['Mdp'])); // On lui applique le même traitement
        
        /* Connexion à la base de données */
        $Conex = mysql_connect('localhost', 'root', '');
        mysql_select_db('BruteForceFichier',$Conex);
        
        /* On va pouvoir faire une requête pour vérifier la correspondance de nos informations */
        $Sql          = mysql_query('SELECT IdMembre, MotDePasse FROM Membres WHERE LoginHasher="'.$LoginH.'"');
        
        /* Si on n'a qu'un seul résultat et pas d'erreur Sql, on peut donc continuer */
        if(mysql_num_rows($Sql) == 1 && !mysql_error()){
                    
            $LesInformations = mysql_fetch_array($Sql);
            $SqlResultMdp    = $LesInformations['MotDePasse'];
            $SqlResultId     = $LesInformations['IdMembre'];
            
            /* Tout d'abord on va ouvrir notre fichier de quotas pour voir si la personne ne l'a pas dépassé 
             * SI c'est le membre d'id 1 et que $CheminFichierQuotas = "BruteForce"
             * $CheminFichierQuotas.'/'.$SqlResultId.'.Bf' vaudra : 
             * 'BruteForce/1.Bf'                                                      
             */
            
            /* D'abord on va s'assurer que le fichier existe si ce n'est pas le cas 
             * on va le créer avec la valeur 0 pour les tentatives 
             */             
            if(!file_exists($CheminFichierQuotas.'/'.$SqlResultId.'.Bf')){
                WriteQuotasFile($CheminFichierQuotas,0,$SqlResultId);
            }
            /* S'il existe, on va vérifier que la personne n'est pas hors quota */
            else{

                /* On récupère nos informations */
                $FichierQuotas = fopen($CheminFichierQuotas.'/'.$SqlResultId.'.Bf', 'r+');
                $InformationQuotas = fgets($FichierQuotas,4096);
                fclose($FichierQuotas);            
         
                /* On sépare nos valeurs */
                $InformationQuotas = explode('-SEPARATEUR-',$InformationQuotas);
            
                /* Si ce n'est pas la date d'aujourd'hui on remet le compteur à 0 et on affecte nous-même les valeurs */
                if($InformationQuotas[1] != date('y-m-d')){
                    WriteQuotasFile($CheminFichierQuotas,0,$SqlResultId);
                    $InformationQuotas[0] = 0;
                }
            

                    
                /* On regarde si le quota n'est pas atteint on pourra donc vérifier nos informations */
                if($Quotas > $InformationQuotas[0]){
                    /* Donc maintenant on peut vérifier si c'est le bon mot de passe ou non */
                    if($SqlResultMdp == $MdpH)
                        return TRUE;
                    else{
                        /* On va donc ajouter +1 notre valeur de quota et réécrire notre fichier */
                        WriteQuotasFile($CheminFichierQuotas,($InformationQuotas[0]+1),$SqlResultId);
                    }
                }
                else
                    return FALSE;
            }
        }
        else
            return FALSE;
    }
    else
        return FALSE;

}

/* Cette fonction nous permettra d'écrire dans notre fichier de log pour les quotas 
 * Le seul argument correspond au quota atteint par la personne
 */
function WriteQuotasFile($CheminFichierQuotas,$QuotasAtteint,$SqlResultId){
    $FichierQuotas = fopen($CheminFichierQuotas.'/'.$SqlResultId.'.Bf', 'w+');
    /* On écrit donc dans notre fichier */
    fwrite($FichierQuotas,$QuotasAtteint.'-SEPARATEUR-'.date('y-m-d'));
    fclose($FichierQuotas);
}
?>