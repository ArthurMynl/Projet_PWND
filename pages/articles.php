<?php

include '../includes/core.php';

ini_set("post_max_size", "100000M");
ini_set("upload_max_filesize", "100000M");
ini_set("memory_limit", -1);

$nomOrigine = $_POST['file'];
$extensionFichier = pathinfo($nomOrigine, PATHINFO_EXTENSION);
$extensionsAutorisees = array("jpeg", "jpg", "gif", "png");

if (!(in_array($extensionFichier, $extensionsAutorisees))) {
    $valid = false;
} else {
    $valid = true;
}

if(isset($_POST["close"])) {
    unset($valid);
}

echo $valid;

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
            <?php
            if (isset($valid) && $valid) {
                echo "<form class='valid' method='post'>";
                echo "<h2>Le fichier a correctement été upload</h2>";
                echo "<button type='submit' name='close' class='close'>X</button>";
                echo "</form>";
            }
            elseif (isset($valid) && !$valid) {
                echo "<form class='error' method='post'>";
                echo "<h2>Le fichier n'a pas l'extension attendue</h2>";
                echo "<button type='submit' name='close' class='close'>X</button>";
                echo "</form>";
            }
            ?>
            <!-- create the navbar -->
            <nav class="navbar">
                <ul>
                    <li> <img src="../assets/logo.png" id="logo"> </li>
                    <li> <a href="/pages/index.php">Accueil</a> </li>
                    <li> <a href="/pages/etudiants.php">Étudiants</a> </li>
                    <?php if ($_SESSION["compte"]) { ?>
                        <?php
                        echo "<li><a href='profil.php?id=" . $_SESSION["compte"] . "'>Profil</a> </li>";
                        echo "<li><a href='edit_profil.php?id=" . $_SESSION["compte"] . "'>Mettre à jour le profil</a></li>";
                        echo "<li><a href='articles.php?id=" . $_SESSION["compte"] . "' class='active'>Publier un article</a> </li>";
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
                        <div class="visibilite">
                            <label class="etiquette-visibilite"> Visibilité </label>
                            <select name="visibilite" id="visibilite">
                                <option value="" disabled selected>-- Choisissez --</option>
                                <option value="public"> public </option>
                                <option value="amis"> amis </option>
                            </select>
                        </div>
                        <form enctype="multipart/form-data" action="fileupload.php" method="post">
                            <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
                            Média <input type="file" name="file" />
                            <button type="submit" value="1" name="article_preview"> PREVIEW ARTICLE </button>
                        </form>
                    </form>
                </div>
                <div class="apercu">
                    <h2> Aperçu dernier article </h2>
                    <form method="post">
                        <h4> <?php echo $_POST["contenu"] ?></h4>
                        <h4> <?php echo $_POST["file"] ?></h4>
                        <h4> <?php echo $_POST["visibilite"] ?></h4>
                        <?php
                        ini_set('date.timezone', 'Europe/Paris');
                        $now = date_create()->format('Y-m-d H:i:s');
                        echo $now;

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