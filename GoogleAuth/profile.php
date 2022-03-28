<?php
require('./config.php');

use RobThree\Auth\TwoFactorAuth;
$tfa = new TwoFactorAuth();
if(empty($_SESSION['tfa_secret'])){
    $_SESSION['tfa_secret'] = $tfa->createSecret();
}

$secret = $_SESSION['tfa_secret'];
if (empty($_SESSION['user_id'])) {
    header('location:http://localhost:8888/MSPRWEB/GoogleAuth/');
    exit();
}

if (!empty($_POST['tfa_code'])){
    if($tfa->verifyCode($secret,$_POST['tfa_code'])){
        $q = $db->prepare('UPDATE users SET secret = :secret WHERE id= :id');
        $q->bindValue('secret',$secret);
        $q->bindValue('id', $_SESSION['user_id']);
        $q->execute();
    } else{
        echo "Code invalide";
    }
}

$userReq = $db->prepare('SELECT * FROM users WHERE id=:id');
$userReq-> bindValue('id', $_SESSION['user_id']);
$userReq->execute();
$user = $userReq->fetch(PDO::FETCH_ASSOC);
?>
<h1>
    Votre profil
</h1>
<p>Bonjour <?php echo $user['nom']?> <?php echo $user['prenom']?></p>
<h2>Activation Double authentification</h2>
<?php if(!$user['secret']): ?>
    <p>Code secret : <?= $secret ?></p>
    <p>QR Code</p>
    <img src="<?= $tfa->getQRCodeImageAsDataUri('tuto',$secret)  ?>">
    <form method="POST">
        <input type="text" placeholder="Vérification Code" name="tfa_code">
        <button type="submit">valider</button>
    </form>
    <?php else: ?>
        <p>2FA activée</p>
    <?php endif ?>
<a href="http://localhost:8888/MSPRWEB/GoogleAuth/logout.php">Déconnexion</a>