<?php

include "../includes/core.php";
$_TITRE_PAGE = "Amis RS ESEO";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste d'amis</title>
    <link rel="stylesheet" href="../style/index_style.css">
</head>

<body>
    <div id="container">
        <div id="content-wrap">
            <!-- create the navbar -->
            <nav class="navbar">
                <ul>
                    <li> <img src="../assets/logo.png" class="logo"> </li>
                    <li> <a href="index.php">Accueil</a> </li>
                    <li> <a href="Etudiants.php">Etudiants</a> </li>
                    <li> <a href="Amis.php" class="active" >Amis</a> </li>
                    <li> <a href="./index.php?logout=1">Deconnexion</a> </li>
                </ul>
            </nav>

            <h1><?php echo "Liste d'amis" ?></h1>
            <nav class="navbar justify-content-between">
                <ul>
                    <li> <a href="Amis.php" class="active">Amis </a> </li>
                    <li> <a href="Demande.php">Demande en cours</a> </li>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Rechercher un ami" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" values = 1 name= "rechercher_amis_submit" type="submit">Valider</button>
                     </form>                
                </ul>
            </nav>
            <p id="afficheAmis">
                <?php 
                $mysqli = new mysqli($infoBdd["server"], $infoBdd["login"], $infoBdd["password"], $infoBdd["db_name"]);

                if ($mysqli->connect_errno) { exit("Problème de connexion à la BDD");}
                
                $sql = "SELECT statut, e.prenom, a.prenom 
                FROM Amis, Etudiant e, Etudiant a 
                WHERE e.idEtu = Amis.etudiant AND a.idEtu = Amis.amis AND statut = 'valide' AND e.idEtu= '".$_SESSION["compte"]."'";
                
                $result = $mysqli->query($sql);
                if (!$result) { exit($mysqli->error); }
                while ($row=$result -> fetch_array()){
                    echo $row["prenom"]." ";
                    echo $row["photo"]." ";
                    echo $row["statut"];
                    echo "<br>";
                }
                ?>
            </p>

        </div>
    </div>
</body>
