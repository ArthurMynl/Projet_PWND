<?php

include "../includes/core.php";
$_TITRE_PAGE = "Amis RS ESEO";


if (isset($_POST["rechercher_amis_submit"]) && $_POST["rechercher_amis_submit"] == 1) {
    $sql = "SELECT a.nom,a.prenom FROM Amis,Etudiant e, Etudiant a 
	WHERE e.idEtu = '" . $SESSION['compte'] . " AND Amis.etudiant = e.idEtu
    AND Amis.amis = a.idEtu 
    AND a.prenom = '" . trim($_POST['amis']) . " AND a.nom = '" . trim($_POST['amis']) . "";

    $result = $mysqli->query($sql);
    if (!$result) {
        exit($mysqli->error);
    }
    while ($row = $result->fetch_array()) {
        echo $row["prenom"] . " ";
        echo $row["nom"];
        echo "<br>";
    }
}

$sql = "SELECT statut, a.prenom, a.nom, a.photo, a.email, a.idEtu, AnneeScolaire.nom as nomAnnee, a.description
                FROM Amis, Etudiant e, Etudiant a, AnneeScolaire
                WHERE e.idEtu = Amis.etudiant AND a.idEtu = Amis.amis AND statut = 'valide' AND idAnneeScolaire = a.anneeScolaire AND e.idEtu= '" . $_SESSION["compte"] . "'";


$sql2 = "SELECT COUNT(statut) as nbDemandes
        FROM Amis, Etudiant e, Etudiant a,
        WHERE e.idEtu = Amis.etudiant AND a.idEtu = Amis.amis AND statut = 'en attente' AND e.idEtu= '" . $_SESSION["compte"] . "'";

$result = $mysqli->query($sql);
$result2 = $mysqli->query($sql2);

if ($result2->num_rows > 0) {
    $row2 = $result2->fetch_array();
    $nbDemandes = $row2["nbDemandes"];
} else {
    $nbDemandes = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste d'amis</title>
    <link rel="stylesheet" href="../style/footer_style.css">
    <link rel="stylesheet" href="../style/amis_style.css">
    <link rel="stylesheet" href="../style/navbar_style.css">
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
                        ?>
                        <li> <a href="edit_profil.php">Editer profil</a> </li>
                        <li> <a href="articles.php">Publier un article</a> </li>
                        <li> <a href="Amis.php">Amis</a> </li>
                        <li> <a href="conversation.php" class='active'> Conversation </a> </li>
                        <li> <a href="notification.php"> Notification </a> </li>
                        <li> <a href="./index.php?logout=1">Déconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>

            <nav class="small-nav">
                <ul>
                    <li> <a href="./Amis.php" class="active">Amis </a> </li>
                    <li> <a href="./Demande.php">Nombre de demandes : <?php echo $nbDemandes; ?> </a> </li>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" name="amis" type="search" placeholder="Rechercher un ami" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" values=1 name="rechercher_amis_submit" type="submit">Valider</button>
                    </form>

                </ul>
            </nav>
            <h1>Vos amis</h1>
            <div id="afficheAmis">
                <?php
                while ($row = $result->fetch_array()) {
                    echo "<div class='fiche-ami'>";
                    echo "<img src='../assets/" . $row["photo"] . "'>";
                    echo "<h3>" . $row["prenom"] . " " . $row["nom"] . "</p>";
                    echo "<h4>" . $row["nomAnnee"] . "</h4>";
                    echo "<h4>" . $row["email"] . "</h4>";
                    echo "<hr>";
                    echo "<p class='description'>" . $row["description"] . "</p>";
                    echo "<a class='voir-profil' href='./profil.php?id=" . $row["idEtu"] . "'>Voir profil</a>";
                    echo "</div>";
                }
                ?>

            </div>
        </div>
        <footer>
            <p>Copyright &copy; 2022 - Par Le Groupe - Tous droits réservés</p>
            <?php $mysqli->close(); ?>
        </footer>
    </div>
</body>