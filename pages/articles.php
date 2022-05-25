<?php

include '../includes/core.php';

/*
$request = "SELECT e.photo, e.nom, e.prenom, asco.nom, FROM Etudiant as e, AnneeScolaire as asco WHERE idAnneeScolaire = anneeScolaire AND idEtu =" . $_GET['id'];
$result = $mysqli->query($request);
*/

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Publication d'un article</title>
    <link rel="stylesheet" href="../style/articles_style.css">
    <link rel="stylesheet" href="../style/navbar_style.css">
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
                        echo "<li> <a href='profil.php?id=" . $_SESSION["compte"] . "'>Profil</a> </li>";
                        echo "<li><a href='edit_profil.php?id=".$_SESSION["compte"]."'>Mettre à jour le profil</a></li>";
                        echo "<li> <a href='articles.php?id=".$_SESSION["compte"]."' class='active'>Publier un article</a> </li>";
                        ?>
                        <li> <a href="./index.php?logout=1">Déconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>

            <h1><?php echo "Publier un article" ?></h1>
            <div class="corps">
                <div class="article">
                    <h2> Publication Article </h2>
                    <form method="post">
                        <input type="contenu" name="contenu" id="contenu" placeholder="Contenu">
                        <input type="media" name="media" id="media" placeholder="Media">
                        <div class="visibilite">
                            <label class="etiquette-visibilite"> Visibilité </label>
                            <select name="visibilite" id="visibilite">
                                <option value="1"> Public </option>
                                <option value="2"> Amis </option>
                            </select>
                        </div>
                        <button type="submit" value="1" name="article_preview"> PREVIEW ARTICLE </button>
                    </form>
                </div>
                <div class="apercu">
                    <h2> Aperçu dernier article </h2>
                    <form method="post">
                        <h4> <?php echo $_POST["contenu"] ?></h4>
                        <h4> <?php echo $_POST["media"] ?></h4>
                        <button type="reset" value="1" name="article_modify"> MODIFIER ARTICLE </button>
                        <button type="submit" value="1" name="article_submit"> PUBLIER ARTICLE </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- create the footer -->
        <footer>
            <p>Copyright &copy; 2022 - Par Le groupe - Tous droits réservés</p>
            <?php $mysqli->close(); ?>
        </footer>
    </div>
</body>
