<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
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
            /* Stack elements vertically */
        }

        table {
            border: solid white 1px;
            border-radius: 5px;
            color: white;
            padding: 1px;
            background-color: white;
        }

        td {
            border: solid blue 1px;
            color: blue;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            /* Adjust the margin as needed */
        }

        .ad{
            margin-top: 10%;
        }

        .ad1{
            margin-top: 1%;
        }

        a:hover{
            color: goldenrod;
        }

        a:visited{
            color: goldenrod;
        }

        .error {
            color: red;
        }

        th{
            color:blue;
        }
    </style>
</head>

<body>
    <?php
    session_start();

    if ($_COOKIE["login"] == null) {
        header("location: index.php");
    }

    echo '<h2>Modifier votre profil</h2>';

    $connexion = mysqli_connect('localhost', 'root');
    mysqli_select_db($connexion, 'moduleconnexion');

    $loginCookieValue = isset($_COOKIE['login']) ? $_COOKIE['login'] : null;

    if (isset($_COOKIE["login"])) {
        $command = "SELECT * FROM utilisateurs WHERE login = '$loginCookieValue'";
        $result = mysqli_query($connexion, $command);

        echo "<table>";
        echo "<tr>";
        while ($fieldInfo = mysqli_fetch_field($result)) {
            echo "<th>" . $fieldInfo->name . "</th>";
        }
        echo "</tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["submit"])) {
            // Traitement du formulaire de modification de profil
            if ($_POST["prenom"] == "") {

                // Mettez à jour les informations dans la base de données
                // Réaffichez la page avec les nouvelles informations
            } else {
                $loginCookieValue = isset($_COOKIE['login']) ? $_COOKIE['login'] : null;
                $variablePrenomPost = $_POST["prenom"];
                $commandPrenom = "UPDATE utilisateurs SET prenom ='$variablePrenomPost' WHERE login ='$loginCookieValue'";
                $result = mysqli_query($connexion, $commandPrenom);
                header("location: profil.php");
            }
            if ($_POST["nom"] == "") {

                // Mettez à jour les informations dans la base de données
                // Réaffichez la page avec les nouvelles informations
            } else {
                $loginCookieValue = isset($_COOKIE['login']) ? $_COOKIE['login'] : null;
                $variableNomPost = $_POST["nom"];
                $commandNom = "UPDATE utilisateurs SET nom ='$variableNomPost' WHERE login ='$loginCookieValue'";
                $result = mysqli_query($connexion, $commandNom);
                header("location: profil.php");
            }
            if ($_POST["password"] == "") {

                // Mettez à jour les informations dans la base de données
                // Réaffichez la page avec les nouvelles informations
            } else {
                $passwordCommand = $_POST['password'];
                $confirmPasswordCommand = $_POST['confirmpassword'];
                if ($confirmPasswordCommand === $passwordCommand) {
                    $loginCookieValue = isset($_COOKIE['login']) ? $_COOKIE['login'] : null;
                    $variablePasswordPost = $_POST["password"];
                    $commandPassword = "UPDATE utilisateurs SET password ='$variablePasswordPost' WHERE login ='$loginCookieValue'";
                    $result = mysqli_query($connexion, $commandPassword);
                    header("location: profil.php");

                } else {
                    $error = "<p class='error'>Les deux mots de passe ne correspondent pas</p>";
                    echo $error;
                }
            }
            if ($_POST["login"] == "") {
            } else {
                $select = mysqli_query($connexion, "SELECT * FROM utilisateurs WHERE login = '" . $_POST['login'] . "'");
                if (mysqli_num_rows($select)) {
                    echo "<p class='error'>Ce login est utilisé</p>";
                } else {
                    $loginCookieValue = isset($_COOKIE['login']) ? $_COOKIE['login'] : null;
                    $variableLoginPost = $_POST["login"];
                    $commandLogin = "UPDATE utilisateurs SET login ='$variableLoginPost' WHERE login ='$loginCookieValue'";
                    $result = mysqli_query($connexion, $commandLogin);
                    setcookie("login", "", time() - 3600 * 24, "/");
                    setcookie("login", "$variableLoginPost", time() + 3600 * 24, "/");
                    header("location: profil.php");
                }
            }
        }
    }
    if (isset($_POST["submit"])) {
        if (empty($_POST["login"]) and empty($_POST["prenom"]) and empty($_POST["nom"]) and empty($_POST["password"])) {
            echo '<p class="error">Veillez renseigner un champ</p>';
        }
    }

    if (isset($_POST['deco'])) {
        setcookie('login', '', time() - 3600 * 24, '/');
        header('location: index.php');
        exit;
    }

    if ($loginCookieValue == "admin") {
        echo '<a class="ad1" href="admin.php"><button>Admin</button></a>';
    }
    ?>

    <form method="post" action="">
        <label for="last-name">Login:</label>
        <input type="text" id="login" name="login">

        <label for="first-name">Prénom:</label>
        <input type="text" id="prenom" name="prenom">

        <label for="last-name">Nom:</label>
        <input type="text" id="nom" name="nom">

        <label for="password-register">Mot de passe:</label>
        <input type="password" id="password" name="password">

        <!-- Corrected typo in the following two lines -->
        <label for="confirmpassword-register">Confirmation mot de passe:</label>
        <input type="password" id="confirmpassword" name="confirmpassword">

        <button class="ad" type="submit" name="submit">Modifier</button>

    </form>

    <form method="post">
        <input type="submit" name="deco" value="Deconnexion">
    </form>
</body>

</html>