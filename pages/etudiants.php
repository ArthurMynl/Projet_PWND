<?php

include '../includes/core.php';

$sql = "SELECT Etudiant.nom as nomEtudiant, prenom, description, email, photo, idEtu, AnneeScolaire.nom as nomAnnee FROM etudiant, AnneeScolaire WHERE idAnneeScolaire = anneeScolaire";
$result = $mysqli->query($sql);

if (isset($_POST["rechercher_etudiant_submit"]) && $_POST["rechercher_etudiant_submit"] == 1) {
    header("Location: recherche_etudiant.php?nom=" . $_POST["etudiant"]);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des étudiants</title>
    <link rel="stylesheet" href="../style/etudiants_style.css">
    <link rel="stylesheet" href="../style/navbar_style.css">
    <link rel="stylesheet" href="../style/footer_style.css">
</head>

<div class="container">
    <div id="content-wrap">
        <!-- create the navbar -->
        <nav class="navbar">
            <ul>
                <li> <img src="../assets/logo.png" id="logo"> </li>
                <li> <a href="index.php">Accueil</a> </li>
                <li> <a href="etudiants.php" class="active">Étudiants</a> </li>
                <?php if ($_SESSION["compte"]) { ?>
                    <li> <a href=<?php echo "profil.php?id=" . $_SESSION["compte"] ?>>Profil</a> </li>
                    <li> <a href="articles.php">Publier un article</a> </li>
                    <li> <a href="amis.php">Amis</a> </li>
                    <li> <a href='conversation.php'> Conversations </a> </li>
                    <li> <a href="./index.php?logout=1" class="deconnexion">Déconnexion</a> </li>
                <?php } ?>
            </ul>
        </nav>

        <h1>Liste des étudiants</h1>
        <form method="post" class="recherche-etudiant">
            <input name="etudiant" type="search" placeholder="Rechercher un étudiant" aria-label="Search">
            <button value=1 name="rechercher_etudiant_submit" type="submit">Valider</button>
        </form>

        <!-- display the names and the photo of the students -->
        <div id="liste-etudiants">
            <?php while ($row = $result->fetch_array()) { ?>
                <div class='etudiant'>
                    <img src=<?php echo '../assets/profil/' . $row["photo"] ?>>
                    <h3> <?php echo $row["prenom"] . " " . $row["nomEtudiant"] ?> </p>
                    <h4> <?php echo $row["nomAnnee"] ?></h4>
                    <h4> <?php echo $row["email"] ?></h4>
                    <hr>
                    <p class='description'> <?php echo $row["description"] ?></p>
                    <a class='voir-profil' href=<?php echo './profil.php?id=' . $row["idEtu"] ?>>Voir profil</a>
                </div>
            <?php } ?>
        </div>
    </div>
    <footer>
        <p>Copyright &copy; 2022 - Par Arthur Meyniel - Tous droits réservés</p>
        <?php $mysqli->close(); ?>
    </footer>
</div>