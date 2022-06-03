<?php

include '../includes/core.php';

$request = "SELECT Etudiant.nom as nomEtudiant, prenom, email, photo, description, AnneeScolaire.nom as nomAnnee FROM Etudiant, AnneeScolaire WHERE idAnneeScolaire = anneeScolaire AND idEtu =" . $_GET['id'];
$result = $mysqli->query($request);
$row = $result->fetch_assoc();

$request2 = "SELECT Article.contenu, Article.media, TIME(Article.dateCreation) as heure,
DATE(Article.dateCreation) as ladate FROM Etudiant, Article WHERE Article.auteur =" . $_GET['id'] . " AND Article.auteur = Etudiant.idEtu ORDER BY DATE(Article.dateCreation) ASC" ;
$result2 = $mysqli->query($request2);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil</title>
    <link rel="stylesheet" href="../style/index_style.css">
    <link rel="stylesheet" href="../style/navbar_style.css">
    <link rel="stylesheet" href="../style/footer_style.css">
    <link rel="stylesheet" href="../style/profil_style.css">
</head>

<body>
    <div id="container">
        <div id="content-wrap">
            <!-- create the navbar -->
            <nav class="navbar">
                <ul>
                    <li> <img src="../assets/logo.png" id="logo"> </li>

                    <li> <a href="index.php">Accueil</a> </li>
                    <li> <a href="etudiants.php">Étudiants</a> </li>
                    <?php if ($_SESSION["compte"]) {
                        echo "<li> <a href='profil.php?id=".$_SESSION["compte"]."' class='active'>Profil</a> </li>"; ?>
                    <li> <a href="edit_profil.php">Mettre à jour le profil</a> </li>
                    <li> <a href="articles.php">Publier un article</a> </li>
                    <li> <a href="./index.php?logout=1" class="deconnexion">Déconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>
            <div class="profil">
                <div class="informations">
                    <?php
                    echo "<h2><img src='../assets/Unknown.jpeg" . $row["photo"] . "class='photo'></h2>";
                    echo "<div class='form'>";
                    echo "<div class='nom_prenom'>";
                    echo "<h4>" . $row["nomEtudiant"] . " " . $row["prenom"] . "</h4>";
                    echo "</div>";
                    echo "<div class='classe'>";
                    echo "<div class='anneeScolaire'>";
                    echo "<h4>" . $row["nomAnnee"] . "</h4>";
                    echo "</div>";
                    echo "<div class='email'>";
                    echo "<h4>" . $row["email"] . "</h4>";
                    echo "</div>";
                    echo "</div>";
                    echo "<p><hr noshade></p>";
                    echo "<div class='description'>";
                    echo "<h4>" . $row["description"] . "</h4>";
                    echo "</div>";
                    echo "</div>";
                    ?>
                </div>
                <div class="liste-articles">
                <?php
                    while($row2 = $result2->fetch_assoc()){
                        echo "<div class='article'>";
                        echo "<div class='media_date'>";
                        echo "<div class='date_heure'>";
                        echo "<p> Le " . $row2["ladate"] . " à " . $row2["heure"] . "</p>";
                        echo "</div>";
                        // echo "<img src='../assets/Unknown.jpeg" . $row["photo"] . ">";
                        // echo "<div class='media'>";
                        // echo "</div>";
                        echo "</div>";
                        echo "<div class='contenu'>";
                        echo "<p>" . $row2["contenu"] . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                ?> 
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