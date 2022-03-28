<?php
require('./config.php');

use RobThree\Auth\TwoFactorAuth;


if (!empty($_POST['email']) && !empty($_POST['password'])){
    var_dump($_POST);

    $email = $_POST['email'] ;
    $password = $_POST['password'];
    //$tfaCode = $_POST['tfa_code'];
    $adIP = hash('ripemd160', $_SERVER['REMOTE_ADDR']);


    $q = $db->prepare('SELECT * FROM users WHERE email = :email');
    $q->bindValue('email', $email);
    $q->execute();
    $user = $q->fetch(PDO::FETCH_ASSOC);

    var_dump($user);


    if ($user){
        $passwordHash = $user['password'];
        //verifie si l'adresse ip est la meme qu'a la derniere connexion
        if(!empty($user['ip']) && $adIP != $user['ip']){
            echo "<script>alert(\"Attention lors de votre derniere connexion l'adresse IP n'était pas la meme si ce n'était pas vous nous vous conseillons de changer de mot de passe.\")</script>";
        }
        //update de la valeur de ip si il est différent ou vide
        if(empty($user['ip']) || $user['ip'] != $adIP){
            $q = $db->prepare('UPDATE users SET ip = :adIP WHERE id = :id');
            $q-> bindValue('adIP',$adIP);
            $q-> bindValue('id', $user['id']);
            $q->execute();
        }
        //verification du mot de passe
        if (password_verify($password,$passwordHash)){

            //$tfa = new TwoFactorAuth();
            if (!$user['secret']){
                $_SESSION['user_id'] = $user['id'];
                header('location:http://localhost:8888/MSPRWEB/GoogleAuth/profile.php');
                exit();

            }else{
                $_SESSION['user_id'] = $user['id'];
                header('location:http://localhost:8888/MSPRWEB/GoogleAuth/code2FA.php');
                exit();
            }
        }else{
            echo "Login ou mot de passe invalide";
        }
    }
}
?>