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
                <li> <a href="index.php">Accueil</a> </li>
                <li> <a href="etudiants.php" class="active">Etudiants</a> </li>
                <?php if ($_SESSION["compte"]) { ?>
                    <li> <a href="profil.php">Profil</a> </li>
                    <li> <a href="edit_profil.php">Editer profil</a> </li>
                    <li> <a href="edit_profil.php">Publier un article</a> </li>
                    <li> <a href="./index.php?logout=1">Deconnexion</a> </li>
                <?php } ?>
            </ul>
        </nav>

        <h1>Liste des étudiants</h1>

        <!-- display the names and the photo of the students -->
        <div class="liste-etudiants">
            <?php

            $sql = "SELECT etudiant.nom as nomEtudiant, prenom, email, photo, idEtu, anneeScolaire.nom as nomAnnee FROM etudiant, anneeScolaire WHERE idAnneeScolaire = anneeScolaire AND idEtu > '7'";
            $result = $mysqli->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='info-etudiant'>";
                    echo "<img class='photo' src='../assets/" . $row["photo"] . "'>";
                    echo "<h2 class='nom'>" . $row["prenom"] . " " . $row["nomEtudiant"] . "</h2>";
                    echo "<p class='mail'>" . $row["email"] . "</p>";
                    echo "<p class='annee'>" . $row["nomAnnee"] . "</p>";
                    echo "<button class='voir-profil'><a href='profil.php?id=" . $row["idEtu"] . "'>Voir profil</a></button>";
                    echo "</div>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>
    <footer>
        <p>Copyright &copy; 2022 - Par Arthur Meyniel - Tous droits réservés</p>
        <?php $mysqli->close(); ?>
    </footer>
</div>