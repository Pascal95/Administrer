<?php
require('./config.php');
 
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nom = $_POST['nom'];
    $prenom =$_POST['prenom'];
 
    $q = $db->prepare('INSERT INTO users (email, password,nom,prenom) VALUES (:email, :password,:nom,:prenom)');
    $q->bindValue('email', $email);
    $q->bindValue('password', $password);
    $q->bindValue('nom', $nom);
    $q->bindValue('prenom', $prenom);
    $res = $q->execute();
    
}
?>
<p>Inscription bien effectué pour vous connecter <a href="http://localhost:8888/MSPRWEB/GoogleAuth/index.php">cliquez ici</a></p>