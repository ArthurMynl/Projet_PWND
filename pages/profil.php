<?php

include '../includes/core.php';

$request = "SELECT nom FROM Etudiant WHERE id = " . $_GET["id"] . ";";
$result = $mysqli->query($request);


?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="../style/index_style.css">
    <link rel="stylesheet" href="../style/navbar_style.css">
</head>

<body>
    <?php echo "<h1> idEtu : " . $_GET["id"] . "</h1>";
    "<h2> nom : " . $result["id"] . "</h2>";
    ?>
    <section>
        <div id="container">
            <div id="content-wrap">
                <!-- create the navbar -->
                <nav class="navbar">
                    <ul>
                        <li> <img src="../assets/logo.png" class="logo"> </li>
                        <li> <a href="index.php" class="active">Accueil</a> </li>
                        <li> <a href="Etudiants.php">Etudiants</a> </li>
                        <li> <a href="./index.php?logout=1">Deconnexion</a> </li>
                        <li> <a href="profil.php" class = "profil">Profil</a> </li>
                    </ul>
                </nav>
                <div class="corps">
                    <div class="profil">
                        <div class = "informations">
                            <h2> Ici il y aura l'image </h2>
                            <p><hr noshade></p>
                            <form method="post">
                                <div class = "nom_prenom">
                                    <h4> echo "<h1> idEtu : . GET["id"] ."</h1">
                                </div>
                                <p><hr noshade></p>
                                <h4 class = "classe"> Classe, Email, AnneeScolaire</h4>
                            </form>
                        </div>
                        <div class = "infos">
                            <h2> Mes infos </h2>
                            <div class = "biographie">
                                <p> L'amitié c'est comme un fruit ou un légume, tu peux en trouver des pourris de l'intérieur comme de l'exterieur </p>
                                <p><hr noshade></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- create the footer -->
                <footer>
                    <p>Copyright &copy; 2022 - Par Arthur Meyniel - Tous droits réservés</p>
                    <?php $mysqli->close(); ?>
                </footer>
            </div>
        </div>
    <section>
</body>
<!DOCTYPE html>
<html lang="en">
