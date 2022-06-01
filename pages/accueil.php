<?php

include '../includes/core.php';

$sql = "SELECT etudiant.nom as nomEtudiant, prenom, photo, anneeScolaire.nom as nomAnnee, contenu, dateCreation, auteur
        FROM etudiant, anneeScolaire, Article
        WHERE idAnneeScolaire = anneeScolaire AND Article.auteur = etudiant.idEtu";
$result = $mysqli->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="../style/navbar_style.css">
    <link rel="stylesheet" href="../style/footer_style.css">
</head>



<body>
    <div id="container">
        <div id="content-wrapper">
            <nav class="navbar">
                <ul>
                    <li> <img src="../assets/logo.png" id="logo"> </li>
                    <li> <a href="./pages/index.php" class="active">Accueil</a> </li>
                    <li> <a href="./pages/etudiants.php">Etudiants</a> </li>
                    <?php if ($_SESSION["compte"]) { ?>
                        <?php
                        echo "<li> <a href='profil.php?id=" . $_SESSION["compte"] . "'>Profil</a> </li>";
                        ?>
                        <li> <a href="./edit_profil.php">Editer profil</a> </li>
                        <li> <a href="./articles.php">Publier un article</a> </li>
                        <li> <a href="./Amis.php">Amis</a> </li>
                        <li> <a href="./index.php?logout=1">Deconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>
            <!-- display the articles list -->
            <div class="liste-articles">
                <h2>Articles</h2>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='article'>";
                    echo "<div class='informations'>";
                    echo "<img src='../assets/" . $row["photo"] . "' class='photo'>";
                    echo "<h3>" . $row["nomEtudiant"] . " " . $row["prenom"] . " - " . $row["nomAnnee"] . "</h3>";
                    echo "</div>";
                    echo "<div class='contenu'>";
                    echo "<p>" . $row["contenu"] . "</p>";
                    echo "<p>" . $row["dateCreation"] . "</p>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
<footer>
    <p>Copyright &copy; 2022 - Par Arthur Meyniel - Tous droits réservés</p>
    <?php $mysqli->close(); ?>
</footer>