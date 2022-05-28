<?php

include "../includes/core.php";
$_TITRE_PAGE = "Amis RS ESEO";

$sql = "SELECT statut, a.prenom, a.nom
                FROM Amis, Etudiant e, Etudiant a 
                WHERE e.idEtu = Amis.etudiant AND a.idEtu = Amis.amis AND statut = 'valide' AND e.idEtu= '" . $_SESSION["compte"] . "'";

$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste d'amis</title>
    <link rel="stylesheet" href="../style/footer_style.css">
    <link rel="stylesheet" href="../style/amis_style.css">
    <link rel="stylesheet" href="../style/navbar_style.css">
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
                    <li> <a href="amis.php" class="active">Amis</a> </li>
                    <li> <a href="./index.php?logout=1">Déconnexion</a> </li>
                </ul>
            </nav>

            <nav class="small-nav">
                <ul>
                    <li> <a href="./amis.php">Amis</a> </li>
                    <li> <a href="./demande.php">Demandes en cours</a> </li>
                    <li>
                        <form class="recherche" type="search">
                            <input type="search" placeholder="Rechercher un ami">
                            <button type="submit">Valider</button>
                        </form>
                    </li>
                </ul>
            </nav>

            <h1><?php echo "Liste d'amis" ?></h1>
            <p id="afficheAmis">
                <?php
                while ($row = $result->fetch_array()) {
                    echo "<div class='fiche-ami'>";
                        echo "<img src='" . $row["photo"] . "'>";
                        echo "<h3>" . $row["prenom"] . " " . $row["nom"] . "</p>";
                        echo "<h4>" . $row["classe"] . "</h4>";
                        echo "<h4>" . $row["mail"] . "</h4>";
                        echo "<hr>";
                        echo "<p class='description'> . " . $row["description"] . "</p>";
                        echo "<a class='voir-profil' href='./profil?id=" . $row["id"] . "'>Voir profil</a>";
                    echo "</div>";
                }
                ?>
            </p>

        </div>
    </div>
</body>