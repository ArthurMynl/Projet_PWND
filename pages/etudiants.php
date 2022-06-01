<?php

session_start();
include '../includes/core.php'

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Etudiants</title>
    <link rel="stylesheet" href="../style/etudiants_style.css">
    <link rel="stylesheet" href="../style/navbar_style.css">
    <link rel="stylesheet" href="../style/footer_style.css">
</head>

<div class="container">
    <div id="content-wrap">
        <!-- create the navbar -->
        <nav class="navbar">
            <ul>
                <li> <img src="../assets/logo.png" id="logo"> </li>
                <li> <a href="/pages/index.php">Accueil</a> </li>
                <li> <a href="./etudiants.php" class="active">Étudiants</a> </li>
                <?php if ($_SESSION["compte"]) { ?>
                    <?php
                    echo "<li> <a href='profil.php?id=" . $_SESSION["compte"] . "'>Profil</a> </li>";
                    echo "<li><a href='edit_profil.php?id=".$_SESSION["compte"]."'>Mettre à jour le profil</a></li>";
                    echo "<li> <a href='articles.php?id=".$_SESSION["compte"]."'>Publier un article</a> </li>";
                    ?>
                    <li> <a href="./index.php?logout=1">Déconnexion</a> </li>
                <?php } ?>
            </ul>
        </nav>

        <h1>Liste des étudiants</h1>

        <!-- display the names and the photo of the students -->
        <div class="liste-etudiants">
            <?php

            $sql = "SELECT Etudiant.nom as nomEtudiant, prenom, email, photo, idEtu, AnneeScolaire.nom as nomAnnee FROM etudiant, AnneeScolaire WHERE idAnneeScolaire = anneeScolaire AND idEtu > '7'";
            $result = $mysqli->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='info-etudiant'>";
                    echo "<img class='photo' src='../assets/" . $row["photo"] . "'>";
                    echo "<h2 class='nom'>" . $row["prenom"] . " " . $row["nomEtudiant"] . "</h2>";
                    echo "<p class='mail'>" . $row["email"] . "</p>";
                    echo "<p class='annee'>" . $row["nomAnnee"] . "</p>";
                    echo "<a href='profil.php?id=" . $row["idEtu"] . "' class='voir-profil' >Voir profil</a>";
                    echo "</div>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>
    <footer>
        <p>Copyright &copy; 2022 - Par Le Groupe - Tous droits réservés</p>
        <?php $mysqli->close(); ?>
    </footer>
</div>