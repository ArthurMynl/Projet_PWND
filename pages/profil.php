<?php

include '../includes/core.php';

$request = "SELECT idEtu, Etudiant.nom as nomEtudiant, prenom, email, photo, description, AnneeScolaire.nom as nomAnnee FROM Etudiant, AnneeScolaire WHERE idAnneeScolaire = anneeScolaire AND idEtu =" . $_GET['id'];
$result = $mysqli->query($request);
$row = $result->fetch_assoc();


$articleSQL = "SELECT DISTINCT etudiant.nom as nomEtudiant, prenom, photo, anneeScolaire.nom as nomAnnee, contenu, dateCreation, auteur, media
                FROM etudiant, anneeScolaire, article, amis
                WHERE idAnneeScolaire = anneeScolaire AND (Article.visibilite = 'public' OR (Article.auteur =" . $_SESSION["compte"] . ") OR (Amis.etudiant =" . $_SESSION["compte"] . " AND Amis.amis =" . $_GET['id'] . ") OR (Amis.amis =" . $_SESSION["compte"] . " AND Amis.etudiant =" . $_GET['id'] . ")) AND Article.auteur = Etudiant.idEtu AND Article.auteur =" . $_GET['id'] . "
                ORDER BY dateCreation DESC";

$articleResult = $mysqli->query($articleSQL);

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
                    <?php if ($_SESSION["compte"]) { ?>
                        <li> <a href=<?php echo "profil.php?id=" . $_SESSION["compte"] ?> class="active">Profil</a> </li>
                        <li> <a href="articles.php">Publier un article</a> </li>
                        <li> <a href="amis.php">Amis</a> </li>
                        <li> <a href='conversation.php'> Conversations </a> </li>
                        <li> <a href="./index.php?logout=1">Déconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>
            <div class="profil">
                <div class="informations">
                    <h2><img src=<?php echo "../assets/profil/" . $row["photo"] ?> class='photo'></h2>
                    <div class='donnees'>
                        <h4 class='nom'><?php echo $row["nomEtudiant"] . " " . $row["prenom"] ?></h4>
                        <h4 class='classe'><?php echo $row["nomAnnee"] ?></h4>
                        <h4 class='mail'><?php echo $row["email"] ?></h4>
                    </div>
                    <hr>
                    <h4 class='description'><?php echo $row["description"] ?></h4>
                    <?php if (isset($_SESSION["compte"]) && $row["idEtu"] == $_SESSION["compte"]) { ?>
                        <a class='bouton' href='edit_profil.php'>Modifier le profil</a>
                    <?php } ?>
                </div>
                <div class="liste-articles">
                    <h2>Derniers articles postés</h2>
                    <?php while ($row2 = $articleResult->fetch_assoc()) { ?>
                        <div class="article">
                            <div class='profil'>
                                <img src=<?php echo "../assets/profil/" . $row2['photo'] ?>>
                                <h3> <?php echo $row2['prenom'] . " " . $row2['nomEtudiant'] ?></h3>
                                <h4> <?php echo $row2['nomAnnee'] ?> </h4>
                                <?php echo $row2['dateCreation'] ?>
                            </div>
                            <div class="contenu">
                                <p> <?php echo $row2["contenu"] ?></p>
                                <?php if ($row2["media"] != 'NULL') { ?>
                                    <img src=<?php echo "../assets/media/" . $row2["media"] ?>>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- create the footer -->
        <footer>
            <p>Copyright &copy; 2022 - Par Mathieu Menard - Tous droits réservés</p>
            <?php $mysqli->close(); ?>
        </footer>
    </div>
</body>