<?php
// Insérer le code de vérification de session ici

// Insérer le code de connexion à la base de données ici
$connexion = mysqli_connect('localhost', 'root');
mysqli_select_db($connexion, 'moduleconnexion');
// Vérifier si l'utilisateur est l'administrateur
if ($_COOKIE['login'] != 'admin') {
    header("Location: index.php"); // Rediriger l'utilisateur non autorisé
    exit();
}

// Sélectionnez et affichez les informations des utilisateurs de la base de données
?>

<!DOCTYPE html>
<html>
<head>
    <title>Administration</title>
    <style>
        table {
            border: solid black 1px;
        }

        td {
            border: solid black 1px;
        }
    </style>
</head>
<body>
    <h2>Page d'administration</h2>
    <!-- Affichage des informations des utilisateurs -->
</body>
</html>

<?php
if(isset($_COOKIE["login"])){
    echo '<form method="post" action="index.php"><button type="submit" name="submit">Profil</button></form>';
    if(isset($_POST['submit'])){
        header('location: profil.php');
    }

}  
$command = "SELECT * FROM utilisateurs";
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
?>
