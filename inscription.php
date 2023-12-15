<!DOCTYPE html>
<html>

<head>
    <title>Inscription</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            background-color: blue;
            color: white;
            /* Added to stack elements vertically */
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 300px;
            /* Adjust the width as needed */
        }

        div {
            margin-top: 1%;
            text-align: center;
        }

        h2 {
            text-align: center;
        }

        .error {
            text-align: center;
            color: red;
        }

        a:link {
            color: goldenrod;
        }

        a:visited {
            color: goldenrod;
        }
    </style>
</head>

<body>
    <h2>Inscription</h2>
    <form method="post" action="inscription.php">

        <label for="last-name">Login:</label>
        <input type="text" id="login" name="login" required>

        <label for="first-name">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="last-name">Nom:</label>
        <input type="text" id="nom" name="nom" required>

        <label for="password-register">Mot de passe:</label>
        <input type="password" id="password" name="password" required>

        <!-- Corrected typo in the following two lines -->
        <label for="confirmpassword-register">Confirmation mot de passe:</label>
        <input type="password" id="confirmpassword" name="confirmpassword" required>

        <button type="submit" name="submit">S'Inscrire</button>
    </form>

</body>

</html>


<?php
session_start();

// Function to restart session if a specific cookie is set
function restartSessionIfCookieSet($cookieName)
{
    if (isset($_COOKIE[$cookieName])) {
        // Regenerate the session ID
        session_regenerate_id(true);

        // Update the cookie with the new session ID
        setcookie(session_name(), session_id(), time() + 3600, '/'); // Adjust the expiration time as needed

        // Unset the cookie that triggered the session restart
        setcookie($cookieName, '', time() - 3600, '/'); // Set the expiration time in the past

        // Optionally, you may want to destroy the old session data
        session_unset();
        session_destroy();

        // Restart the session
        session_start();
    }
}

// Restart session if the 'login' cookie is set
restartSessionIfCookieSet('login');

// Insérer le code de connexion à la base de données ici
$connexion = mysqli_connect('localhost', 'root');
mysqli_select_db($connexion, 'moduleconnexion');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit"])) {
        $select = mysqli_query($connexion, "SELECT * FROM utilisateurs WHERE login = '" . $_POST['login'] . "'");
        if (mysqli_num_rows($select)) {
            echo '<p class="error">Ce login est utilisé</p>';
        } else {
            $loginCommand = $_POST['login'];
            $prenomCommand = $_POST['prenom'];
            $nomCommand = $_POST['nom'];
            $passwordCommand = $_POST['password'];
            $confirmPasswordCommand = $_POST['confirmpassword'];
            // Traitement du formulaire d'inscription
            if ($confirmPasswordCommand === $passwordCommand) {
                $command = "INSERT INTO utilisateurs(login, prenom, nom, password) VALUES('$loginCommand', '$prenomCommand', '$nomCommand', '$passwordCommand')";
                $result = mysqli_query($connexion, $command);
                // Insérez les données dans la base de données
                // Redirigez l'utilisateur vers la page de connexion
                header("location: connexion.php");
            } else {
                $error = '<p class="error">Les deux mots de passe ne correspondent pas</p>';
                echo $error;
            }
        }
    }
}
?>

<div><a href="connexion.php">Vous êtes déjà inscrit?</a></div>