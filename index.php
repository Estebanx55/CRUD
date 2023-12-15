<?php
include('header.php'); 
?>
<!DOCTYPE html>
<html>

<head>
    <title>Accueil</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <h2>Bienvenue sur le site de Esteban ☻ </h2>
    <p>Contenu de la page d'accueil. ..</p>
    <?php

    if(isset($_COOKIE["login"])){
        echo '<form method="post" action="index.php"><button type="submit" name="submit">Profil</button></form>';
        if(isset($_POST['submit'])){
            header('location: profil.php');
        }

    }    
    else{
        echo '<a href="inscription.php"><button>Inscription</button></a>';
    }
    ?>
</body>

</html>