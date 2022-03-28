<?php
require('./config.php');

use RobThree\Auth\TwoFactorAuth;


$tfaCode = $_POST['tfa_code'];
$id = $_SESSION['user_id'];
$q = $db->prepare('SELECT * FROM users WHERE id = :id');
$q->bindValue('id', $id);
$q->execute();
$user = $q->fetch(PDO::FETCH_ASSOC);

$tfa = new TwoFactorAuth();

if ($tfa->verifyCode($user['secret'],$tfaCode)){
    header('location:http://localhost:8888/MSPRWEB/GoogleAuth/profile.php');
    exit();
}
else{
    echo "Code 2FA invalide";
}
?>