<?php

include '../includes/core.php';


$articleSQL = "SELECT DISTINCT etudiant.nom as nomEtudiant, prenom, photo, anneeScolaire.nom as nomAnnee, contenu, dateCreation, auteur, media
                FROM etudiant, anneeScolaire, article, amis
                WHERE idAnneeScolaire = anneeScolaire AND (Article.visibilite = 'public' OR (Article.auteur =" . $_SESSION["compte"] . ") OR (Amis.etudiant =" . $_SESSION["compte"] . " AND Amis.amis = Article.auteur) OR (Amis.amis =" . $_SESSION["compte"] . " AND Amis.etudiant = Article.auteur)) AND Article.auteur = Etudiant.idEtu 
                ORDER BY dateCreation DESC";

$result = $mysqli->query($articleSQL);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Accueil</title>
    <link rel="stylesheet" href="../style/navbar_style.css">
    <link rel="stylesheet" href="../style/accueil_style.css">
    <link rel="stylesheet" href="../style/footer_style.css">
</head>


<body>
    <div id="container">
        <div id="content-wrapper">
            <nav class="navbar">
                <ul>
                    <li> <img src="../assets/logo.png" id="logo"> </li>
                    <li> <a href="/pages/index.php" class="active">Accueil</a> </li>
                    <li> <a href="/pages/Etudiants.php">Étudiants</a> </li>
                    <?php if ($_SESSION["compte"]) { ?>
                        <li> <a href=<?php echo "profil.php?id=" . $_SESSION["compte"] ?>>Profil</a> </li>
                        <li> <a href="articles.php">Publier un article</a> </li>
                        <li> <a href="amis.php">Amis</a> </li>
                        <li> <a href='conversation.php'> Conversations </a> </li>
                        <li> <a href="./index.php?logout=1">Déconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>
            <!-- display the articles list -->
            <div class="liste-articles">
                <h1>Derniers articles postés</h1>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="article">
                        <div class='profil'>
                            <img src=<?php echo "../assets/profil/" . $row['photo'] ?>>
                            <h3> <?php echo $row['prenom'] . " " . $row['nomEtudiant'] ?></h3>
                            <h4> <?php echo $row['nomAnnee'] ?> </h4>
                            <?php echo $row['dateCreation'] ?>
                        </div>
                        <div class="contenu">
                            <p> <?php echo $row["contenu"] ?></p>
                            <?php if ($row["media"] != 'NULL') { ?>
                                <img src=<?php echo "../assets/media/" . $row["media"] ?>>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <footer>
            <p>Copyright &copy; 2022 - Par Arthur Meyniel - Tous droits réservés</p>
            <?php $mysqli->close(); ?>
        </footer>
    </div>
</body>