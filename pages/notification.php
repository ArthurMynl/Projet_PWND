<?php
include '../includes/core.php';

//Lecture d'une notifiaction
if (isset($_POST['lecture'])) {
    $sql = "UPDATE Notification SET statutLecture = 'oui' WHERE Notification.idNotification = " . $_POST['lecture'];
    $result = $mysqli->query($sql);

    if (!$result) {
        exit($mysqli->error);
    }
    unset($_POST['lecture']);
}

//Supression d'un notifiaction
if (isset($_POST['supression'])) {
    $sql = "UPDATE Notification SET statutSupression = 'oui' WHERE Notification.idNotification = " . $_POST['supression'];
    $result = $mysqli->query($sql);
    if (!$result) {
        exit($mysqli->error);
    }
    unset($_POST['supression']);
}

// recupere les notification de l'étudiant connecté
$notifSQL = "SELECT DISTINCT Notification.*, Etudiant.nom as nomEmetteur,Etudiant.prenom as prenomEmetteur FROM Notification left outer join Etudiant on Notification.idEmetteur = Etudiant.idEtu WHERE idEtudiant = " . $_SESSION["compte"];
$resultNotif = $mysqli->query($notifSQL);

if (!$resultNotif) {
    exit($mysqli->error);
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notification</title>
    <link rel="stylesheet" href="../style/navbar_style.css">
    <link rel="stylesheet" href="../style/notifiaction_style.css">
    <link rel="stylesheet" href="../style/footer_style.css">
</head>

<body>
    <div id="container">
        <div id="content-wrap">
            <nav class="navbar">
                <ul>
                    <li> <img src="../assets/logo.png" id="logo"> </li>
                    <li> <a href="/pages/index.php">Accueil</a> </li>
                    <li> <a href="/pages/Etudiants.php">Étudiants</a> </li>
                    <?php if ($_SESSION["compte"]) { ?>
                        <?php
                        echo "<li> <a href='profil.php?id=" . $_SESSION["compte"] . "'>Profil</a> </li>";
                        ?>
                        <li> <a href="edit_profil.php">Editer profil</a> </li>
                        <li> <a href="articles.php">Publier un article</a> </li>
                        <li> <a href="amis.php">Amis</a> </li>
                        <li> <a href="conversation.php"> Conversation </a> </li>
                        <li> <a href="notification.php" class='active'> Notification </a> </li>
                        <li> <a href="./index.php?logout=1">Déconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>

            <div>
                <?php while ($notif = $resultNotif->fetch_assoc()) { ?>

                    <?php if ($notif['statutSupression'] == 'non') {
                        if ($notif['statutLecture'] == 'non') { ?>
                            <div id='non_lu'>
                                <form method='post'>
                                    <?php if ($notif['nomEmetteur'] == 'NULL') { ?>
                                        <button type='submit' name="lecture" value=<?php echo $notif['idNotification'] ?>><?php echo $notif['type'] ?></button>
                                    <?php } else { ?>
                                        <button type='submit' name="lecture" value=<?php echo $notif['idNotification'] ?>> <?php echo $notif['type'] . " " . $notif['nomEmetteur'] . " " . $notif['prenomEmetteur'] ?></button>
                                    <?php }
                                    ?>
                                    <button type='submit' name="supression" value=<?php echo $notif['idNotification'] ?>> Supprimer </button>
                                </form>
                            </div>
                        <?php } else { ?>
                            <div id='lu'>
                                <form method='post'>
                                    <?php if ($notif['nomEmetteur'] == 'NULL') { ?>
                                        <button type='submit' name="lecture" value=<?php echo $notif['idNotification'] ?>><?php echo $notif['type'] ?></button>
                                    <?php } else { ?>
                                        <button type='submit' name="lecture" value=<?php echo $notif['idNotification'] ?>> <?php echo $notif['type'] . " " . $notif['nomEmetteur'] . " " . $notif['prenomEmetteur'] ?></button>
                                    <?php }
                                    ?>
                                    <button type='submit' name="supression" value=<?php echo $notif['idNotification'] ?>> Supprimer </button>
                                </form>
                            </div>
                    <?php }
                    } ?>

                <?php } ?>
            </div>

        </div>
        <footer>
            <p>Copyright &copy; 2022 - Par Arthur Meyniel - Tous droits réservés</p>
            <?php $mysqli->close(); ?>
        </footer>
    </div>
</body>

</html>