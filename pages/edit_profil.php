<?php

include '../includes/core.php';

$request = "SELECT etudiant.nom as nomEtudiant, prenom, email, photo, description, anneeScolaire.nom as nomAnnee FROM etudiant, anneeScolaire WHERE idAnneeScolaire = anneeScolaire AND idEtu =" . $_SESSION['compte'];
$result = $mysqli->query($request);

$request2 = "SELECT etudiant.motDePasse FROM Etudiant WHERE idEtu = '" . $_SESSION['compte'] . "'";
$result2 = $mysqli->query($request2);

if (isset($_POST["edit_profil_submit"]) && $_POST["edit_profil_submit"] == 1) {

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $anneeScolaire = $_POST['annees'];
    $login = $_POST['login'];
    $old_pwd = $_POST['old_password'];
    $password = $_POST['password'];
    $pwd_confirm = $_POST['password_confirm'];

    if(isset($nom) && trim($nom) != '') {
        $requestNom = "UPDATE Etudiant SET nom = '" . $nom . "' WHERE idEtu = '" . $_SESSION['compte'] . "'";
        $resultNom = $mysqli->query($requestNom);
    }

    if(isset($prenom) && trim($prenom) != '') {
        $requestPrenom = "UPDATE Etudiant SET prenom = '" . $prenom . "' WHERE idEtu = '" . $_SESSION['compte'] . "'";
        $resultPrenom = $mysqli->query($requestPrenom);
    }

    if(isset($anneeScolaire) && trim($anneeScolaire) != '') {
        $requestAS = "UPDATE Etudiant SET anneeScolaire = '" . $anneeScolaire . "' WHERE idEtu = '" . $_SESSION['compte'] . "'";
        $resultAS = $mysqli->query($requestAS);
    }

    if(isset($login) && trim($login) != '') {
        $requestLogin = "UPDATE Etudiant SET email = '" . $login . "' WHERE idEtu = '" . $_SESSION['compte'] . "'";
        $resultLogin = $mysqli->query($requestLogin);
    }

    if(isset($old_pwd) && trim($old_pwd) != '' && isset($password) && trim($password) != '' && isset($pwd_confirm) && trim($pwd_confirm) != '' && $result2 == $old_pwd && $password == $pwd_confirm) {
        $requestPwd= "UPDATE Etudiant SET motDePasse = '" . $password . "' WHERE idEtu = '" . $_SESSION['compte'] . "'";
        $resultPwd = $mysqli->query($requestPwd);
    }

    $requestRefresh = "SELECT etudiant.nom as nomEtudiant, prenom, email, photo, description, anneeScolaire.nom as nomAnnee FROM etudiant, anneeScolaire WHERE idAnneeScolaire = anneeScolaire AND idEtu =" . $_SESSION["compte"];
    $resultRefresh = $mysqli->query($requestRefresh);

}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mise à jour du profil</title>
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
                    <li> <a href="index.php">Accueil</a> </li>
                    <li> <a href="etudiants.php">Étudiants</a> </li>
                    <?php if ($_SESSION["compte"]) {
                        echo "<li> <a href='profil.php?id=" . $_SESSION["compte"] . "'>Profil</a> </li>"; ?>
                    <li> <a href="edit_profil.php" class="active">Mettre à jour le profil</a> </li>
                    <li> <a href="articles.php">Publier un article</a> </li>
                    <li> <a href="./index.php?logout=1" class="deconnexion">Déconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>

            <div class="corps">
                <div class="editionProfil">
                    <?php $row = $result->fetch_assoc(); ?>
                    <h2>Mise à jour du profil</h2>
                    <form method="post">
                        <label>Nom</label>
                        <?php echo "<input type='text' name='nom' id='nom' placeholder='".$row["nomEtudiant"]."'>"; ?>
                        <label>Prénom</label>
                        <?php echo "<input type='text' name='prenom' id='prenom' placeholder='".$row["prenom"]."'>"; ?>
                        <div class="selecteur">
                            <label>Année Scolaire</label>
                            <select name='annees' id='annees'>
                                <?php echo "<option value='" . $row['idAnneeScolaire']. "'disabled selected>".$row["nomAnnee"]."</option>";?>
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