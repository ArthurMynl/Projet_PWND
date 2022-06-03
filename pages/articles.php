<?php

include '../includes/core.php';

ini_set("post_max_size", "100000M");
ini_set("upload_max_filesize", "100000M");
ini_set("memory_limit", -1);

$nomOrigine = $_POST['file'];
$directionFichier = pathinfo($nomOrigine, PATHINFO_DIRNAME);
$extensionFichier = pathinfo($nomOrigine, PATHINFO_EXTENSION);
$extensionsAutorisees = array("jpeg", "jpg", "gif", "png");

if (!(in_array($extensionFichier, $extensionsAutorisees))) {
    $valid = false;
} else {
    $valid = true;



    // $uploaddir = '/var/www/assets/';
    // $uploadfile = $uploaddir . basename($_POST['file']['name']);

    // echo '<pre>';
    // if (move_uploaded_file($_POST['userfile']['tmp_name'], $uploadfile)) {
    //     echo "Le fichier est valide, et a été téléchargé
    //         avec succès. Voici plus d'informations :\n";
    // } else {
    //     echo "Attaque potentielle par téléchargement de fichiers.
    //         Voici plus d'informations :\n";
    // }

    // echo 'Voici quelques informations de débogage :';
    // print_r($_FILES);

    // echo '</pre>';


    $repertoirePhoto = dirname(__FILE__) . "/";
    $nomDestination = "file_" . date("YmdHis") . "." . $extensionFichier;

    // on récupère les infos du fichier à uploader
    $file_temp = $_POST['file']['tmp_name'];
    $file_name = $_POST['file']['name'];

    // on renomme le fichier
    $file_date = date("ymdhis");
    $file_n_nom = $file_date . "." . $extensionFichier;

    if (move_uploaded_file(
        $_POST["file"]["tmp_name"],
        $repertoirePhoto . $file_n_nom
    )) {
        // echo "Le fichier temporaire " . $_POST["file"]["tmp_name"] .
        //     " a été déplacé vers " . $repertoireDestination . $file_n_nom;
        echo "" . $repertoirePhoto;
    } else {
        // echo "Le fichier n'a pas été uploadé (trop gros ?) ou " .
        //     "Le déplacement du fichier temporaire a échoué" .
        //     " vérifiez l'existence du répertoire " . $repertoireDestination . $file_n_nom;
        echo "" . $nomOrigine;
    }
}

$media = $_POST['file'];
$requestMedia = "UPDATE Article SET media = '" . $media . "'";



if (isset($_POST["close"])) {
    unset($valid);
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
            <?php
            if (isset($valid) && $valid) {
                echo "<form class='valid' method='post'>";
                echo "<h2>Le fichier a correctement été upload</h2>";
                echo "<button type='submit' name='close' class='close'>X</button>";
                echo "</form>";
            } elseif (isset($valid) && !$valid) {
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
                            <button class='btn-article' type="submit" value="1" name="article_preview"> PREVIEW ARTICLE </button>
                        </form>
                    </form>
                </div>
                <div class="apercu">
                    <h2> Aperçu dernier article </h2>
                    <form method="post">
                        <h4> <?php echo $_POST["contenu"] ?></h4>
                        <?php echo '<img src="' . $_FILES['file'] . '">'; ?>
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