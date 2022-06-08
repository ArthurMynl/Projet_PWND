<?php

include "../includes/core.php";
$_TITRE_PAGE = "Amis RS ESEO";

if (isset($_POST["rechercher_amis_submit"]) && $_POST["rechercher_amis_submit"] == 1) {
    header("Location: recherche_amis.php?nom=" . $_POST["amis"]);
}
 

$demandesSQL = "SELECT Etudiant.idEtu, Etudiant.description, Etudiant.nom, Etudiant.prenom, Etudiant.photo, Etudiant.email, AnneeScolaire.nom as nomAnnee 
FROM Amis, Etudiant, AnneeScolaire 
WHERE (idAnneeScolaire = Etudiant.anneeScolaire AND Amis.statut = 'en attente' AND Amis.amis = Etudiant.idEtu AND Amis.etudiant = " . $_SESSION['compte'] . ")
OR (idAnneeScolaire = Etudiant.anneeScolaire AND Amis.statut = 'en attente' AND Amis.etudiant = Etudiant.idEtu AND Amis.amis = " . $_SESSION['compte'] . ")";
$liste_demandes = $mysqli->query($demandesSQL);
if (!$liste_demandes) {
    exit($mysqli->error);
}


$nbDemandesSQL = "SELECT COUNT(statut) as nbDemandes FROM Amis, Etudiant WHERE Amis.statut = 'en attente' AND Amis.amis = Etudiant.idEtu AND Amis.etudiant = '" . $_SESSION['compte'] . "'";
$nbDemandesResult = $mysqli->query($nbDemandesSQL);

if ($nbDemandesResult->num_rows > 0) {
    $row = $nbDemandesResult->fetch_array();
    $nbDemandes = $row["nbDemandes"];
} else {
    $nbDemandes = 0;
}


if (isset($_POST['Accepter']) && $_POST['Accepter'] == 'Accepter') {
    $sql = "UPDATE Amis SET statut = 'valide' WHERE amis = " . $_POST['idAmis'] . " AND etudiant = " . $_SESSION['compte'];
    $mysqli->query($sql);
    header("Location: Demandes.php");
}

if (isset($_POST['Refuser']) && $_POST['Refuser'] == 'Refuser') {
    $sql = "UPDATE Amis SET statut = 'refuse' WHERE amis = " . $_POST['idAmis'] . " AND etudiant = " . $_SESSION['compte'];
    $mysqli->query($sql);
    header("Location: Demandes.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Demande d'ami</title>
    <link rel="stylesheet" href="../style/navbar_style.css">
    <link rel="stylesheet" href="../style/demandes_style.css">
    <link rel="stylesheet" href="../style/footer_style.css">
</head>

<body>
    <div id="container">
        <div id="content-wrap">
            <!-- create the navbar -->
            <nav class="navbar">
                <ul>
                    <li> <img src="../assets/logo.png" id="logo"> </li>
                    <li> <a href="./accueil.php">Accueil</a> </li>
                    <li> <a href="./etudiants.php">Étudiants</a> </li>
                    <?php if ($_SESSION["compte"]) { ?>
                        <li> <a href=<?php echo "profil.php?id=" . $_SESSION["compte"] ?>>Profil</a> </li>
                        <li> <a href="articles.php">Publier un article</a> </li>
                        <li> <a href="amis.php" class="active">Amis</a> </li>
                        <li> <a href='conversation.php'> Conversations </a> </li>
                        <li> <a href="./index.php?logout=1">Déconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>
            <nav class="small-nav">
                <ul>
                    <li> <a href="./amis.php" class="active">Amis </a> </li>
                    <li> <a href="./demandes.php">Nombre de demandes : <?php echo $nbDemandes; ?> </a> </li>
                    <form method="post">
                        <input name="amis" type="search" placeholder="Rechercher un ami" aria-label="Search">
                        <button value=1 name="rechercher_amis_submit" type="submit">Valider</button>
                    </form>
                </ul>
            </nav>

            <h1>Demandes en attente</h1>
            <div class="liste-demandes">
                <?php while ($row = $liste_demandes->fetch_array()) { ?>
                    <div class="demande">
                        <img src=<?php echo '../assets/profil/' . $row["photo"] ?>>
                        <h3> <?php echo $row["prenom"] . " " . $row["nom"] ?> </h3>
                        <h4> <?php echo $row["nomAnnee"] ?></h4>
                        <h4> <?php echo $row["email"] ?></h4>
                        <hr>
                        <p class='description'> <?php echo $row["description"] ?></p>
                        <div class="boutons">
                            <form method="post">
                                <input type="hidden" name="idAmis" value="<?php echo $row['idEtu']; ?>">
                                <input type="submit" name="Accepter" value="Accepter">
                                <a class='voir-profil' href=<?php echo './profil.php?id=' . $row["idEtu"] ?>>Voir profil</a>
                                <input type="submit" name="Refuser" value="Refuser">
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <footer>
            <p>&copy; Copyright 2022 - Par Maxime Lelant - Amis RS ESEO</p>
            <?php $mysqli->close(); ?>
        </footer>
    </div>
</body>