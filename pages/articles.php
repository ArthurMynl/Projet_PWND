<?php
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="../style/index_style.css">
</head>

<body>
    <div id="container">
        <div id="content-wrap">
            <!-- create the navbar -->
            <nav class="navbar">
                <ul>
                    <li> <img src="../assets/logo.png" class="logo"> </li>
                    <li> <a href="index.php" class="active">Accueil</a> </li>
                    <li> <a href="Etudiants.php">Etudiants</a> </li>
                    <?php if ($_SESSION["compte"]) { ?>
                        <li> <a href="./index.php?logout=1">Deconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>

            <h1><?php echo $_TITRE_PAGE ?></h1>
            <div class="corps">
                <div class="article">
                    <h2> Publication Article </h2>
                    <form method="post">
                        <input type="contenu" name="contenu" id="contenu" placeholder="Contenu">
                        <input type="media" name="media" id="media" placeholder="Media">
                        <div class="visibilite">
                            <label class="etiquette-visibilite"> Visibilité </label>
                            <datalist name="visibilite" id="visibilite">
                                <option value="public">
                                <option value="amis">
                            </datalist>
                        </div>
                        <button type="submit" value="1" name="article_submit"> PUBLIER ARTICLE </button>
                    </form>
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