<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- importer le fichier de style -->
    <link rel="stylesheet" href="login.css" media="screen" type="text/css" />
    <script type="text/javascript" src="monscript.js"></script>
    <title>Inscription</title>

</head>
<body>
<div id="container">
    <form action="verif2FA.php" method="POST">
        <h1>Code 2FA</h1>
        <input type="text" placeholder="Code google authenticator" name="tfa_code">
        <button type="submit">Valider</button>
    </form>
</body>