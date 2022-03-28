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
<form method="POST" action="register.php">
<h1>Inscription</h1>
        <input type="email" placeholder="Email" name="email"><br>
        <input type="password" placeholder="Mot de passe" name="password"><br>
        <input type="text" placeholder="Nom" name="nom"><br>
        <input type="text" placeholder="Prénom" name="prenom"><br>
        <button type="submit">Inscription</button>
    </form>
</div>
</body>
</html>