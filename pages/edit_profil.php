<?php

$_TITRE_PAGE = "Mettre à jour le profil";

include '../includes/core.php';

$request = "SELECT etudiant.nom as nomEtudiant, prenom, email, photo, description, anneeScolaire.nom as nomAnnee FROM etudiant, anneeScolaire WHERE idAnneeScolaire = anneeScolaire AND idEtu =" . $_GET['id'];
$result = $mysqli->query($request);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_TITRE_PAGE?></title>
    <link rel="stylesheet" href="../style/navbar_style.css">
    <link rel="stylesheet" href="../style/edit_profil_style.css">
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
                        echo "<li><a href='edit_profil.php?id=".$_SESSION["compte"]."' class='active'>Mettre à jour le profil</a></li>";
                        echo "<li> <a href='articles.php?id=".$_SESSION["compte"]."'>Publier un article</a> </li>";
                        ?>
                        <li> <a href="./index.php?logout=1">Déconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>

            <div class="corps">
                <div class="editionProfil">
                    <?php $row = $result->fetch_assoc();?>
                    <h2>Mise à jour du profil</h2>
                    <form method="post">
                        <label>Nom</label>
                        <?php echo "<input type='text' name='nom' id='nom' placeholder='".$row["nomEtudiant"]."'>"; ?>
                        <label>Prénom</label>
                        <?php echo "<input type='text' name='prenom' id='prenom' placeholder='".$row["prenom"]."'>"; ?>
                        <div class="selecteur">
                            <label>Année Scolaire</label>
                            <select name='annees' id='annees'>
                                <?php echo "<option value='" .idAnneeScolaire. "'disabled selected>".$row["nomAnnee"]."</option>";?>
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
                        <label>Email</label>
                        <?php echo "<input type='email' name='login' id='login' placeholder='".$row["email"]."'>"; ?>
                        <label>Ancien mot de passe</label>
                        <input type='password' name='old_password' id='old_password'>
                        <label>Nouveau mot de passe</label>
                        <input type='password' name='password' id='password'>
                        <label>Confirmez le nouveau mot de passe</label>
                        <input type='password' name='password_confirm' id='password_confirm'>
                        <button type="submit" value="1" name="edit_profil_submit">ENREGISTRER LES MODIFICATIONS</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>Copyright &copy; 2022 - Par Arthur Meyniel - Tous droits réservés</p>
        <?php $mysqli->close(); ?>
    </footer>

</body>
