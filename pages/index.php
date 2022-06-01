<?php

include "../includes/core.php";
$_TITRE_PAGE = "Accueil projet RS ESEO";

if (isset($_POST["connexion_submit"]) && $_POST["connexion_submit"] == 1) {

    $sql = "SELECT idEtu FROM Etudiant WHERE email = '" . trim($_POST['mail']) . "' AND motDePasse = '" . trim($_POST["password"]) . "'";

    $result = $mysqli->query($sql);
    if (!$result) {
        exit($mysqli->error);
    }

    $mail_escaped = $mysqli->real_escape_string(trim($_POST["mail"]));
    $password_escaped = $mysqli->real_escape_string(trim($_POST["password"]));

    $nb = $result->num_rows;

    if ($nb) {
        //récupération de l’id de l’étudiant
        $row = $result->fetch_assoc();
        $_SESSION["compte"] = $row["idEtu"];
    }
}

if (isset($_POST["inscription_submit"]) && $_POST["inscription_submit"] == 1) {
    if ($_POST['password'] == $_POST['password_confirm']) {
        $mysqli = new mysqli($infoBdd["server"], $infoBdd["login"], $infoBdd["password"], $infoBdd["db_name"]);

        if ($mysqli->connect_errno) {
            exit("Problème de connexion à la BDD");
        }

        $sql = "INSERT INTO Etudiant (nom, prenom, anneeScolaire, email, motDePasse, photo) VALUES ('" . trim($_POST["nom"]) . "', '" . trim($_POST["prenom"]) . "', '" . trim($_POST["annees"]) . "', '" . trim($_POST["login"]) . "', '" . trim($_POST["password"]) . "', 'unknown.jpeg')";

        $result = $mysqli->query($sql);
        if (!$result) {
            exit($mysqli->error);
        }

        $sql = "SELECT idEtu FROM Etudiant WHERE email = '" . trim($_POST['login']) . "' AND motDePasse = '" . trim($_POST["password"]) . "'";

        $result = $mysqli->query($sql);
        if (!$result) {
            exit($mysqli->error);
        }

        $mail_escaped = $mysqli->real_escape_string(trim($_POST['login']));
        $password_escaped = $mysqli->real_escape_string(trim($_POST['password']));

        $nb = $result->num_rows;

        if ($nb) {
            //récupération de l’id de l’étudiant
            $row = $result->fetch_assoc();
            $_SESSION["compte"] = $row["idEtu"];
        }
    }
}


if ($_GET["logout"] == 1) {
    unset($_SESSION["compte"]);
    header('Location: ./index.php');
}

if (isset($_SESSION["compte"])) {
    header('Location: ./accueil.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="../style/navbar_style.css">
    <link rel="stylesheet" href="../style/index_style.css">
    <link rel="stylesheet" href="../style/footer_style.css">
</head>

<body>
    <div id="container">
        <div id="content-wrap">
            <!-- create the navbar -->
            <nav class="navbar">
                <ul>
                    <li> <img src="../assets/logo.png" id="logo"> </li>
                    <li> <a href="/pages/index.php" class="active">Accueil</a> </li>
                    <li> <a href="/pages/etudiants.php">Étudiants</a> </li>
                    <?php if ($_SESSION["compte"]) { ?>
                        <?php
                        echo "<li> <a href='profil.php?id=" . $_SESSION["compte"] . "'>Profil</a> </li>";
                        echo "<li><a href='edit_profil.php?id=" . $_SESSION["compte"] . "'>Mettre à jour le profil</a></li>";
                        echo "<li> <a href='articles.php?id=" . $_SESSION["compte"] . "'>Publier un article</a> </li>";
                        ?>
                        <li> <a href="./index.php?logout=1">Déconnexion</a> </li>

                    <?php } ?>
                </ul>
            </nav>

            <h1><?php echo $_TITRE_PAGE ?></h1>
            <div class="corps">
                <?php if (empty($_SESSION["compte"])) { ?>
                    <div class="connexion">
                        <h2> Connexion </h2>
                        <form method="post">
                            <input type="email" name="mail" id="mail" placeholder=" Email">
                            <input type="password" name="password" id="password" placeholder="Mot de passe">
                            <button type="submit" value="1" name="connexion_submit"> CONNEXION </button>
                            <div class="mdp-perdu">
                                <img src="../assets/clef.png">
                                <a href="ratio.php"> Mot de passe perdu </a>
                            </div>
                        </form>
                    </div>

                    <div class="inscription">
                        <h2> Inscription </h2>
                        <form method="post">
                            <input type="text" name="nom" id="nom" placeholder="Nom">
                            <input type="text" name="prenom" id="prenom" placeholder="Prénom">
                            <div class="selecteur">
                                <label class="etiquette-annee"> Année Scolaire </label>
                                <select name="annees" id="annees">
                                    <option value="" disabled selected>-- Choisissez --</option>
                                    <option value="1"> E1</option>
                                    <option value="2"> E2</option>
                                    <option value="3"> E3e</option>
                                    <option value="4"> E4e</option>
                                    <option value="5"> E5e</option>
                                    <option value="6"> E3a</option>
                                    <option value="7"> E4a</option>
                                    <option value="8"> E5a</option>
                                    <option value="9"> B1</option>
                                    <option value="10"> B2</option>
                                    <option value="11"> B3</option>
                                </select>
                            </div>
                            <input type="email" name="login" id="login" placeholder="Email">
                            <input type="password" name="password" id="password" placeholder="Mot de passe">
                            <input type="password" name="password_confirm" id="password_confirm" placeholder="Confirmez votre mot de passe">
                            <button type="submit" value="1" name="inscription_submit"> INSCRIPTION </button>
                        </form>
                    </div>
                <?php } else { ?>
                    <div>
                        <?php echo "<h3> Vous etes connecté </h3>" ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- create the footer -->
        <footer>
            <p>Copyright &copy; 2022 - Par Le Groupe - Tous droits réservés</p>
            <?php $mysqli->close();
            unset($_SESSION['idConvCourrante']);
            unset($_SESSION['etat']); ?>
        </footer>
    </div>
</body>