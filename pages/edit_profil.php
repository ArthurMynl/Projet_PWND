<?php

$_TITRE_PAGE = "Mettre à jour le profil";

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_TITRE_PAGE?></title>
    <link rel="stylesheet" href="../style/edit_profil_style.css">
</head>

<body>

    <div id="container">
        <div id="content-wrap">
            <!-- create the navbar -->
            <nav class="navbar">
                <ul>
                    <li> <img src="../assets/logo.png" class="logo"> </li>
                    <li> <a href="./index.php">Accueil</a> </li>
                    <li> <a href="./profil.php">Profil</a> </li>
                    <li> <a href="edit_profil.php" class="active">Mettre à jour le profil</a> </li>
                    <li> <a href="articles.php">Publier un article</a> </li>
                    <li> <a href="etudiants.php">Étudiants</a> </li>
                    <?php if ($_SESSION["compte"]) { ?>
                        <li> <a href="./index.php?logout=1">Deconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </div>

    <div class="editionProfil">
        <h2>Mise à jour du profil</h2>
        <form mothod="post">
            <h4>Nom</h4>
            <input type="text" name="nom" id="nom" placeholder="Modifiez votre nom">
            <input type="text" name="prenom" id="prenom" placeholder="Modifiez votre prénom">
            <div class="selecteur">
                <label class="etiquette-annee">Modifiez votre année scolaire</label>
                <select name="annees" id="annees">
                    


</body>
