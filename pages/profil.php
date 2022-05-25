<?php

include '../includes/core.php';

$request = "SELECT etudiant.nom as nomEtudiant, prenom, email, photo, description, anneeScolaire.nom as nomAnnee FROM etudiant, anneeScolaire WHERE idAnneeScolaire = anneeScolaire AND idEtu =" . $_GET['id'];
$result = $mysqli->query($request);

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
                    <li> <a href="index.php">Accueil</a> </li>
                    <li> <a href="Etudiants.php">Etudiants</a> </li>
                    <?php if ($_SESSION["compte"]) { ?>
                        <?php
                        echo "<li> <a href='profil.php?id=" . $_SESSION["compte"] . "' class='active'>Profil</a> </li>";
                        ?>
                        <li> <a href="edit_profil.php">Editer profil</a> </li>
                        <li> <a href="edit_profil.php">Publier un article</a> </li>
                        <li> <a href="./index.php?logout=1">Deconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>
            <div class="corps">
                <div class="profil">
                    <div class="informations">
                        <?php
                        $row = $result->fetch_assoc();
                        echo "<h2><img src='../assets/" . $row["photo"] . "'alt='profil' class='photo'></h2>";
                        echo "<p><hr noshade></p>";
                        echo "<div class='form'>";
                        echo "<div class='nom_prenom'>";
                        echo "<h4>" . $row["nomEtudiant"] . " " . $row["prenom"] . "</h4>";
                        echo "</div>";
                        echo "<p><hr noshade></p>";
                        echo "<h4 class='classe'>" . $row["email"] . " " . $row["nomAnnee"] . "</h4>";
                        echo "</div>";
                        ?>
                    </div>
                    <div class="infos">
                        <h2> Mes infos </h2>
                        <div class="biographie">
                            <?php
                            echo "<p>" . $row["description"] . "</p>";
                            ?>
                            <p>
                                <hr noshade>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- create the footer -->
        <footer>
            <p>Copyright &copy; 2022 - Par Arthur Meyniel - Tous droits réservés</p>
            <?php $mysqli->close(); ?>
        </footer>
    </div>
</body>
