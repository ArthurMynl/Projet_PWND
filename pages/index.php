<?php

include "../includes/core.php";
$_TITRE_PAGE = "Accueil projet RS ESEO";

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
                        <h3>Vous êtes connecté !</h3>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- create the footer -->
        <footer>
            <p>Copyright &copy; 2022 - Par Arthur Meyniel - Tous droits réservés</p>
            <?php $mysqli->close(); ?>
        </footer>
    </div>
</body>