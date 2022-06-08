<?php

include '../includes/core.php';

if (isset($_POST['close'])) {
    unset($_SESSION['media']);
    unset($_SESSION['ext_valid']);
}

if (isset($_POST['close_valid'])){
    unset($_SESSION['ext_valid']);
}

$request = "SELECT Etudiant.nom as nomEtudiant, prenom , photo, AnneeScolaire.nom as nomAnnee FROM Etudiant, AnneeScolaire WHERE idAnneeScolaire = anneeScolaire AND idEtu =" . $_SESSION['compte'];
$result = $mysqli->query($request);
$row = $result->fetch_assoc();

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
            <?php if (isset($_SESSION['ext_valid']) && !$_SESSION['ext_valid']) { ?>
                <form class='error' method='post'>
                    <h2>L'extension du fichier n'est pas acceptée</h2>
                    <button type='submit' name='close' class='close'>X</button>
                </form>
            <?php } elseif (isset($_SESSION['ext_valid']) && $_SESSION['ext_valid']) { ?>
                <form class='valid' method='post'>
                <h2>Le fichier a été upload</h2>
                <button type='submit' name='close_valid' class='close'>X</button>
             </form>
            <?php } ?>
            <!-- create the navbar -->
            <nav class="navbar">
                <ul>
                    <li> <img src="../assets/logo.png" id="logo"> </li>
                    <li> <a href="index.php">Accueil</a> </li>
                    <li> <a href="etudiants.php">Étudiants</a> </li>
                    <?php if ($_SESSION["compte"]) { ?>
                        <li> <a href=<?php echo "profil.php?id=" . $_SESSION["compte"] ?>>Profil</a> </li>
                        <li> <a href="articles.php" class='active' >Publier un article</a> </li>
                        <li> <a href="amis.php">Amis</a> </li>
                        <li> <a href='conversation.php'> Conversations </a> </li>
                        <li> <a href="./index.php?logout=1">Déconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>

            <div class="corps">
                <div class="article">
                    <h2> Publication Article </h2>
                    <form enctype="multipart/form-data" action="../includes/upload.php" method="post">
                        <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
                        <input type="file" name="file" class="file">
                        <input type="text" name="contenu" class="contenu" placeholder="Contenu">
                        <div id="visibilité">
                            <label class="etiquette-visibilite"> Visibilité </label>
                            <select name="visibilite">
                                <option value="" disabled selected>-- Choisissez --</option>
                                <option value="public"> public </option>
                                <option value="amis"> amis </option>
                            </select>
                        </div>
                        <button class='btn-article' type="submit" name="upload"> PREVIEW ARTICLE </button>
                    </form>
                </div>
                <div class="apercu">
                    <h2> Aperçu article </h2>
                    <form method="post" action="../includes/publier.php">
                        <div id="article">
                            <div class='profil'>
                                <img src=<?php echo "../assets/profil/" . $row['photo'] ?>>
                                <h3> <?php echo $row['prenom'] . " " . $row['nomEtudiant'] ?></h3>
                                <h4> <?php echo $row['nomAnnee'] ?> </h4>
                                <?php
                                ini_set('date.timezone', 'Europe/Paris');
                                $_SESSION['now'] = date_create()->format('Y-m-d H:i');
                                echo $_SESSION['now'];
                                ?>
                            </div>
                            <div class="contenu">
                                <p> <?php echo $_SESSION["contenu"] ?></p>
                                <?php if ($_SESSION["media"] && $_SESSION["media"] != 'NULL') { ?>
                                    <img src=<?php echo "../assets/media/" . $_SESSION["media"] ?>>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="boutons">
                            <button type="submit" name="article_delete" class="btn-article"> SUPPRIMER ARTICLE </button>
                            <button type="submit" value="1" name="article_submit" class="btn-article"> PUBLIER ARTICLE </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- create the footer -->
        <footer>
            <p>Copyright &copy; 2022 - Par Théo Lurat - Tous droits réservés</p>
            <?php $mysqli->close(); ?>
        </footer>
    </div>
</body>