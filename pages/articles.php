<?php

include '../includes/core.php';

if (isset($_POST['close'])) {
    unset($_SESSION['media']);
    unset($_SESSION['ext_valid']);
}

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
            <?php } ?>
            <!-- create the navbar -->
            <nav class="navbar">
                <ul>
                    <li> <img src="../assets/logo.png" id="logo"> </li>
                    <li> <a href="./index.php?logout=1">Déconnexion</a> </li>
                    <li> <a href="index.php">Accueil</a> </li>
                    <li> <a href="etudiants.php">Étudiants</a> </li>
                    <?php if ($_SESSION["compte"]) {
                        echo "<li> <a href='profil.php?id=" . $_SESSION["compte"] . "'>Profil</a> </li>"; ?>
                        <li> <a href="edit_profil.php">Mettre à jour le profil</a> </li>
                        <li> <a href="articles.php" class="active">Publier un article</a> </li>
                        <li> <a href="./index.php?logout=1" class="deconnexion">Déconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>


            <h1><?php echo "Publier un article" ?></h1>
            <div class="corps">
                <div class="article">
                    <h2> Publication Article </h2>
                    <form enctype="multipart/form-data" action="../includes/upload.php" method="post">
                        <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
                        <input type="file" name="file">
                        <input type="text" name="contenu" placeholder="Contenu">
                        <label class="etiquette-visibilite"> Visibilité </label>
                        <select name="visibilite" id="visibilite">
                            <option value="" disabled selected>-- Choisissez --</option>
                            <option value="public"> public </option>
                            <option value="amis"> amis </option>
                        </select>
                        <button class='btn-article' type="submit" name="upload"> PREVIEW ARTICLE </button>
                    </form>
                </div>
                <div class="apercu">
                    <h2> Aperçu dernier article </h2>
                    <form method="post" action="../includes/publier.php">
                        <h4> <?php echo $_SESSION["contenu"] ?></h4>
                        <h4> <?php echo $_SESSION["visibilite"] ?></h4>
                        <img src=<?php echo "/assets/media/" . $_SESSION["media"] ?>>
                        <?php
                        ini_set('date.timezone', 'Europe/Paris');
                        $_SESSION['now'] = date_create()->format('Y-m-d H:i:s');
                        echo $_SESSION['now'];
                        ?>
                        <button type="reset" value="1" name="article_modify" class="btn-article"> MODIFIER ARTICLE </button>
                        <button type="submit" value="1" name="article_submit" class="btn-article"> PUBLIER ARTICLE </button>
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