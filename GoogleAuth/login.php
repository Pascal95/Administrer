<?php
require('./config.php');

use RobThree\Auth\TwoFactorAuth;

var attempt = 3; // Variable to count number of attempts.
// Below function Executes on click of login button.
function validate(){
    var username = document.getElementById("name").value;
    var password = document.getElementById("password").value;
    //var email = document.getElementById("email")
    if ( username == "elvisamal" && password == "test"){
        alert ("Logged");
        window.location = "board.php"; // Redirecting to other page.
        return false;
    }

    else{
        attempt --;// Decrementing by one.
        alert("Il vous reste "+attempt+" tentative de connexion;");
        // Disabling fields after 3 attempts.
    if( attempt == 0){
        document.getElementById("name").disabled = true;
        document.getElementById("password").disabled = true;
        document.getElementById("email").disabled = true;
        document.getElementById("submit").disabled = true;
        return false;
    }
    }
    }


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
