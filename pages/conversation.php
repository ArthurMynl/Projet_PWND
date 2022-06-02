<?php

$_SESSION['etat'] = 0;

// recuperer les conversations de l'étudiant connecté
$convSQL = "SELECT Conversation.nom as nomConv FROM Membre, Conversation WHERE Membre.etudiant = " . $_SESSION["compte"] . " AND membre.conversation = conversation.idConv ";
$resultConv = $mysqli->query($convSQL);


// envoyer un message
if (isset($_POST['message_submit']) && $_POST['message_submit'] == 1) {
    // incrémenter l'id du message ?
    $sql = "SELECT MAX(idMess) FROM Message";
    $res = $mysqli->query($sql);
    if (!$res) {
        exit($mysqli->error);
    }
    $row = $res->fetch_row();
    $id = $row[0] + 1;

    // ajouter le message à la bdd
    $sql = "INSERT INTO Message (idMess,contenu,dateEnvoi,conversation,emetteur) VALUES (" . $id . ",'" . trim($_POST["contenu"]) . "',NOW()," . $_SESSION['idConvCourante'] . "," . $_SESSION['compte'] . ")";
    $result = $mysqli->query($sql);
    if (!$result) {
        exit($mysqli->error);
    }
    unset($_POST["message_submit"]);
}

// selectionne la conversation 
if (isset($_POST['conv_courante'])) {
    $_SESSION['idConvCourante'] = $_POST['conv_courante'];
    $messageSQL = "SELECT contenu,emetteur,dateEnvoi FROM Message WHERE idMess =" . $row["idMess"];
    $resultMessage = $mysqli->query($messageSQL);
}

// créer la conversation
if (isset($_POST['creation_submit']) && $_POST['creation_submit'] == 1) {
    $_SESSION['etat'] = 1;
}

// ajouter des personnes
if (isset($_POST['ajout_submit']) && $_POST['ajout_submit'] == 1) {
    $_SESSION['etat'] = 2;
}

// valider la creation de la conversation
if (isset($_POST['validation_creation']) && $_POST['validation_creation'] == 1) {
    // incrémenter l'id de la conversation
    $sql = "SELECT MAX(idConv)  FROM Conversation";
    $res = $mysqli->query($sql);
    if (!$res) {
        exit($mysqli->error);
    }
    $row = $res->fetch_row();
    $id = $row[0] + 1;


    // ajouter la conversation à la bdd
    $sql = "INSERT INTO Conversation (idConv,Nom,dateCreation) VALUES (" . $id . ",'" . trim($_POST["nom"]) . "',NOW() )";
    $result = $mysqli->query($sql);
    if (!$result) {
        exit($mysqli->error);
    }

    // associer la conversation à l'étudiant connecté
    $sql = "INSERT INTO Membre (conversation,etudiant) VALUES (" . $id . "," . $_SESSION['compte'] . ")";
    $result = $mysqli->query($sql);
    if (!$result) {
        exit($mysqli->error);
    }

    // recuperer les conversations de l'étudiant connecté
    $convSQL = "SELECT conversation FROM Membre WHERE etudiant = " . $_SESSION["compte"];
    $resultConv = $mysqli->query($convSQL);

    if (!$resultConv) {
        exit($mysqli->error);
    }

    $_SESSION['etat'] == 0;
}

// annuler nouvelle conversation
if (isset($_POST['annulation_creation']) && $_POST['annulation_creation'] == 1) {
    $_SESSION['etat'] == 0;
}

// ajouter des personnes 
if (isset($_POST['validation_ajout']) && $_POST['validation_ajout'] == 1) {
    // recuperer le mail de l'étudiant
    $mail_escaped = $mysqli->real_escape_string(trim($_POST['mail']));

    // à partir du mail, on recupere l'id de l'étudiant
    $sql = "SELECT idEtu
            FROM Etudiant
            WHERE email = '" . $mail_escaped . "'";
    $result = $mysqli->query($sql);

    if (!$result) {
        exit($mysqli->error);
    }

    $nb = $result->num_rows;
    if ($nb) {
        $row = $result->fetch_assoc();
        // ajouter le membre à la bdd
        $sql = "INSERT INTO Membre (conversation,etudiant) VALUES (" . $_SESSION['idConvCourante'] . "," . $row['idEtu'] . ")";
        $result = $mysqli->query($sql);

        if (!$result) {
            exit($mysqli->error);
        }
        $_SESSION['etat'] == 0;
    }
}

// annuler ajouter une personne
if (isset($_POST['annulation_ajout']) && $_POST['annulation_ajout'] == 1) {
    $_SESSION['etat'] == 0;
}

?>

<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../style/navbar_style.css">
    <link rel="stylesheet" href="../style/conversation_style.css">
    <link rel="stylesheet" href="../style/footer_style.css">
    <title><?php echo $_TITRE_PAGE ?></title>
</head>

<body>
    <div id="container">
        <div id="content-wrap">
            <nav class="navbar">
                <ul>
                    <li> <img src="../assets/logo.png" id="logo"> </li>
                    <li> <a href="/pages/index.php" class="active">Accueil</a> </li>
                    <li> <a href="/pages/Etudiants.php">Étudiants</a> </li>
                    <?php if ($_SESSION["compte"]) { ?>
                        <?php
                        echo "<li> <a href='profil.php?id=" . $_SESSION["compte"] . "'>Profil</a> </li>";
                        ?>
                        <li> <a href="edit_profil.php">Editer profil</a> </li>
                        <li> <a href="articles.php">Publier un article</a> </li>
                        <li> <a href="amis.php">Amis</a> </li>
                        <?php
                        echo "<li> <a href='liste_conversation.php?id=" . $_SESSION["compte"] . "'> Conversation </a> </li>"; ?>
                        <li> <a href="./index.php?logout=1">Déconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>

            <nav class="small-nav">
                <form method="post">
                    <ul>
                        <li> <input class="small-nav-btn">Mes conversations</input></li>
                        <li> <input class="small-nav-btn">Créer une Conversation</input></li>
                        <li> <input class="small-nav-btn">Ajouter des personnes à cette conversation</input></li>
                    </ul>
                </form>
            </nav>

            <?php if ($_SESSION["etat"] == 0) { ?>

                <h1><?php echo $_SESSION["etat"] ?></h1>
                <div id="liste-conversations">
                    <?php while ($conversation = $resultConv->fetch_assoc()) { ?>
                        <div class="appercu-conversation">
                            <?php echo $conversation['nomConv'] ?>
                            <form method='post'>
                                    <input type='submit'>voir conversation</input>
                            </form>
                        </div>
                    <?php } ?>
                </div>
                <?php if (isset($convCourante)) { ?>
                    <div class="conversation">
                        <div class="messages">
                            <?php while ($message = $resultMessage->fetch_assoc()) { 
                                if($message['emetteur'] == $_SESSION['compte']){ ?>
                                    <div class="message-sortant">
                                        <h3 class="message-emetteur"><?php echo $message['emetteur'] ?></h3>
                                        <p class="message-sortant"> <?php echo $message['contenu'] ?> </p>
                                        <h6> <?php echo $message['date'] ?> </h6>
                                    </div>
                                <?php } else { ?>
                                    <div class="message-entrant">
                                        <h3 class="message-emetteur"><?php echo $message['emetteur'] ?></h3>
                                        <p> <?php echo $message['contenu'] ?> </p>
                                        <h6> <?php echo $message['date'] ?> </h6>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <form class="envoi-message">
                            <input type="text" name="message" placeholder="Votre message">
                            <input type="submit" value="Envoyer">
                        </form>
                    </div>
                <?php } ?>
            <?php } ?>