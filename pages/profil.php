<?php

include '../includes/core.php';

$request = "SELECT Etudiant.nom as nomEtudiant, prenom, email, photo, description, AnneeScolaire.nom as nomAnnee FROM Etudiant, AnneeScolaire WHERE idAnneeScolaire = anneeScolaire AND idEtu =" . $_GET['id'];
$result = $mysqli->query($request);
$row = $result->fetch_assoc();

$request2 = "SELECT Article.auteur, Article.contenu FROM Article, Etudiant WHERE Etudiant.idEtu = Article.auteur AND idEtu =" . $_GET['id'];
$result2 = $mysqli->query($request2);
$row2 = $result2->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="../style/index_style.css">
    <link rel="stylesheet" href="../style/navbar_style.css">
    <link rel="stylesheet" href="../style/profil_style.css">
    <link rel="stylesheet" href="../style/footer_style.css">
</head>

<body>
    <div id="container">
        <div id="content-wrap">
            <!-- create the navbar -->
            <nav class="navbar">
                <ul>
                    <li> <img src="../assets/logo.png" id="logo"> </li>
                    <li> <a href="/pages/index.php">Accueil</a> </li>
                    <li> <a href="/pages/etudiants.php">Étudiants</a> </li>
                    <?php if ($_SESSION["compte"]) { ?>
                        <?php
                        echo "<li> <a href='profil.php?id=" . $_SESSION["compte"] . "' class='active'>Profil</a> </li>";
                        echo "<li><a href='edit_profil.php?id=".$_SESSION["compte"]."'>Mettre à jour le profil</a></li>";
                        echo "<li> <a href='articles.php?id=".$_SESSION["compte"]."'>Publier un article</a> </li>";
                        ?>
                        <li> <a href="./index.php?logout=1">Déconnexion</a> </li>

                    <?php } ?>
                </ul>
            </nav>
            <div class="corps">
                <div class="profil">
                    <div class="informations">
                        <?php
                        echo "<h2><img src='../assets/" . $row["photo"] . "'alt='profil' class='photo'></h2>";
                        echo "<p><hr></p>";
                        echo "<div class='form'>";
                        echo "<div class='nom_prenom'>";
                        echo "<h4>" . $row["nomEtudiant"] . " " . $row["prenom"] . "</h4>";
                        echo "</div>";
                        echo "<p><hr></p>";
                        echo "<div class='classe'>";
                        echo "<h4> Adresse Mail : " . $row["email"] . "</h4>";
                        echo "<div class='anneeScolaire'>";
                        echo "<h4> Année Scolaire : " . $row["nomAnnee"] . "</h4>";
                        echo "</div>";
                        echo "</div>";
                        echo "<p><hr></p>";
                        echo "<div class='description'>";
                        echo "<h4> Description : " . $row["description"] . "</h4>";
                        echo "</div>";
                        echo "</div>";
                        ?>
                    </div>
                    <div class="infos">
                        <?php
                        echo "<div class='news1'>";
                        echo "<h5> Dernières article </h5>";
                        echo "<p> Article : " . $row2["contenu"] . "</p>";
                        echo "</div>";
                        echo "<div class='news2'>";
                        echo "<h5> Avant dernier article </h5>";
                        echo "<p> Article : " . $row2["contenu"] . "</p>";
                        echo "</div>";
                        echo "<div class='news3'>";
                        echo "<h5> Avant avant dernier article </h5>";
                        echo "<p> Article : " . $row2["contenu"] . "</p>";
                        echo "</div>";
                        ?>
                    </div>
                </div>

            </div>
        </div>
        <!-- create the footer -->
        <footer>
            <p>Copyright &copy; 2022 - Par Le Groupe - Tous droits réservés</p>
            <?php $mysqli->close(); ?>
        </footer>
    </div>
</body>