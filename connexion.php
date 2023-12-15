<!DOCTYPE html>
<html>

<head>
    <title>Connexion</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            background-color: blue;
            color: white;
        }

        #container {
            text-align: center;
        }

        form {
            display: inline-block;
            text-align: left;
        }

        a:link {
            color: goldenrod;
        }

        a:visited{
            color: goldenrod;
        }

        .error {
            color: red;
        }

        .inscrip{
            margin-top: 1%;
        }
    </style>
</head>

<body>
    <div id="container">
        <h2>Connexion</h2>
        <form method="post" action="connexion.php">
            <!-- Formulaire de connexion avec les champs "login" et "password" -->
            <label for="last-name">Login:</label>
            <input type="text" id="login" name="login" required>

            <label for="password-register">Mot de passe:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="submit">Se connecter</button>
        </form>

        <div class="inscrip"><a href="inscription.php">Pas encore inscrit ? Inscrivez-vous !</a></div>
    </div>
</body>

</html>

<?php


session_start();
// Insérer le code de connexion à la base de données ici
$connexion = mysqli_connect('localhost', 'root');
mysqli_select_db($connexion, 'moduleconnexion');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Traitement du formulaire de connexion
    if (isset($_POST["submit"])) {
        $select = mysqli_query($connexion, "SELECT * FROM utilisateurs WHERE login = '" . $_POST['login'] . "'");

        if (mysqli_num_rows($select)) {

            $select = mysqli_query($connexion, "SELECT * FROM utilisateurs WHERE password = '" . $_POST['password'] . "'");
            if (mysqli_num_rows($select)) {
                $monCookie = $_POST['login'];
                setcookie("login", "$monCookie", time() + 3600 * 24, "/");
                header("location: index.php");
            } else {
                echo "<div id='error'><p class='error'>Le mot de passe est faux</p></div>";
                // Vérifiez les informations de connexion et créez la session si les informations sont correctes
                // Redirigez l'utilisateur vers la page de profil si la connexion réussit
            }
        } else {
            echo "<p class='error'>Le login n'existe pas</p>";
        }

    }
}
?>