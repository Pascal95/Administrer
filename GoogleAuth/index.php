<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- importer le fichier de style -->
    <link rel="stylesheet" href="login.css" media="screen" type="text/css" />
    <script type="text/javascript" src="monscript.js"></script>
    <title>Login</title>

</head>

<body>
    <div id="container">
            <!-- zone de connexion -->

            <form method="POST" action="login.php">
                <h1>Connexion</h1>


                <input id="mdp" type="email" placeholder="Email" name="email" required>


                <input id="mdp" type="password" placeholder="Mot de passe" name="password" required>

                <button type="submit">Connexion</button>
            
                <a href="http://localhost:8888/MSPRWEB/GoogleAuth/inscription.php">s'inscrire</a>
            </form>
    </div>
</body>

</html>