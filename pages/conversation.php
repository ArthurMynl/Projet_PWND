<?php

include '../includes/core.php';

$_SESSION['etat'] = 0;

// recuperer les conversations de l'étudiant connecté
$convSQL = "SELECT Conversation.nom as nomConv, conversation.idConv as idConv FROM Membre, Conversation WHERE Membre.etudiant = " . $_SESSION["compte"] . " AND membre.conversation = conversation.idConv ";
$resultConv = $mysqli->query($convSQL);

if(isset($_SESSION['idConvCourante'])){
    // récupérer les messages de la conversation
    $messageSQL = "SELECT contenu, Etudiant.nom as nomEmetteur, Etudiant.prenom as prenomEmetteur, emetteur, dateEnvoi FROM Message, Etudiant WHERE Message.emetteur = Etudiant.idEtu AND conversation = " . $_SESSION['idConvCourante'] . " ORDER BY dateEnvoi ASC";
    $resultMessage = $mysqli->query($messageSQL);

    // recuperer les participants de la conversation
    $participantSQL = "SELECT Etudiant.nom as nomEtudiant, Etudiant.prenom as prenomEtudiant FROM Etudiant, Conversation, Membre WHERE Etudiant.idEtu = Membre.etudiant AND Membre.conversation = Conversation.idConv AND Conversation.idConv = " . $_SESSION['idConvCourante'];
    $resultParticipant = $mysqli->query($participantSQL);
}

// envoyer un message
if (isset($_POST['message_submit'])) {
    // incrémenter l'id du message ?
    $sql = "SELECT MAX(idMess) FROM Message";
    $res = $mysqli->query($sql);
    if (!$res) {
        exit($mysqli->error);
    }
    $row = $res->fetch_row();
    $id = $row[0] + 1;

    // ajouter le message à la bdd
    $ajoutMessageSQL = "INSERT INTO Message (idMess,contenu,dateEnvoi,conversation,emetteur) VALUES (" . $id . ",'" . $mysqli->real_escape_string(trim($_POST["message"])) . "',NOW()," . $_SESSION['idConvCourante'] . "," . $_SESSION['compte'] . ")";
    $resultAjoutMessage = $mysqli->query($ajoutMessageSQL);
    if (!$resultAjoutMessage) {
        exit($mysqli->error);
    }

    // récupérer les messages de la conversation
    $messageSQL = "SELECT contenu, Etudiant.nom as nomEmetteur, Etudiant.prenom as prenomEmetteur, emetteur, dateEnvoi FROM Message, Etudiant WHERE Message.emetteur = Etudiant.idEtu AND conversation = " . $_SESSION['idConvCourante'] . " ORDER BY dateEnvoi ASC";
    $resultMessage = $mysqli->query($messageSQL);

    // recuperer les participants de la conversation
    $participantSQL = "SELECT Etudiant.nom as nomEtudiant, Etudiant.prenom as prenomEtudiant FROM Etudiant, Conversation, Membre WHERE Etudiant.idEtu = Membre.etudiant AND Membre.conversation = Conversation.idConv AND Conversation.idConv = " . $_SESSION['idConvCourante'];
    $resultParticipant = $mysqli->query($participantSQL);

    unset($_POST["message"]);
    unset($_POST["message_submit"]);
}

// selectionne la conversation 
if (isset($_POST['conv_courante'])) {
    $_SESSION['idConvCourante'] = $_POST['conv_courante'];
    $_SESSION['nomConvCourante'] = $_POST['nomConv'];
    $messageSQL = "SELECT contenu, Etudiant.nom as nomEmetteur, Etudiant.prenom as prenomEmetteur, emetteur, dateEnvoi FROM Message, Etudiant WHERE Message.emetteur = Etudiant.idEtu AND conversation = " . $_SESSION['idConvCourante'] . " ORDER BY dateEnvoi ASC";
    $resultMessage = $mysqli->query($messageSQL);
    $participantSQL = "SELECT Etudiant.nom as nomEtudiant, Etudiant.prenom as prenomEtudiant FROM Etudiant, Conversation, Membre WHERE Etudiant.idEtu = Membre.etudiant AND Membre.conversation = Conversation.idConv AND Conversation.idConv = " . $_SESSION['idConvCourante'];
    $resultParticipant = $mysqli->query($participantSQL);
    unset($_POST["conv_courante"]);
}

// selectionne le mode
if (isset($_POST['etat'])) {
    $_SESSION['etat'] = $_POST['etat'];
    $messageSQL = "SELECT contenu, Etudiant.nom as nomEmetteur, Etudiant.prenom as prenomEmetteur, emetteur, dateEnvoi FROM Message, Etudiant WHERE Message.emetteur = Etudiant.idEtu AND conversation = " . $_SESSION['idConvCourante'] . " ORDER BY dateEnvoi ASC";
    $resultMessage = $mysqli->query($messageSQL);
    $participantSQL = "SELECT Etudiant.nom as nomEtudiant, Etudiant.prenom as prenomEtudiant FROM Etudiant, Conversation, Membre WHERE Etudiant.idEtu = Membre.etudiant AND Membre.conversation = Conversation.idConv AND Conversation.idConv = " . $_SESSION['idConvCourante'];
    $resultParticipant = $mysqli->query($participantSQL);
}

// créer la conversation
if (isset($_POST['creation_submit']) && $_POST['creation_submit'] == 1) {
    $_SESSION['etat'] = 1;
    $messageSQL = "SELECT contenu, Etudiant.nom as nomEmetteur, Etudiant.prenom as prenomEmetteur, emetteur, dateEnvoi FROM Message, Etudiant WHERE Message.emetteur = Etudiant.idEtu AND conversation = " . $_SESSION['idConvCourante'] . " ORDER BY dateEnvoi ASC";
    $resultMessage = $mysqli->query($messageSQL);
    $participantSQL = "SELECT Etudiant.nom as nomEtudiant, Etudiant.prenom as prenomEtudiant FROM Etudiant, Conversation, Membre WHERE Etudiant.idEtu = Membre.etudiant AND Membre.conversation = Conversation.idConv AND Conversation.idConv = " . $_SESSION['idConvCourante'];
    $resultParticipant = $mysqli->query($participantSQL);
    unset($_POST["creation_submit"]);
}

// ajouter des personnes
if (isset($_POST['ajout_submit']) && $_POST['ajout_submit'] == 1) {
    $_SESSION['etat'] = 2;
    $messageSQL = "SELECT contenu, Etudiant.nom as nomEmetteur, Etudiant.prenom as prenomEmetteur, emetteur, dateEnvoi FROM Message, Etudiant WHERE Message.emetteur = Etudiant.idEtu AND conversation = " . $_SESSION['idConvCourante'] . " ORDER BY dateEnvoi ASC";
    $resultMessage = $mysqli->query($messageSQL);
    $participantSQL = "SELECT Etudiant.nom as nomEtudiant, Etudiant.prenom as prenomEtudiant FROM Etudiant, Conversation, Membre WHERE Etudiant.idEtu = Membre.etudiant AND Membre.conversation = Conversation.idConv AND Conversation.idConv = " . $_SESSION['idConvCourante'];
    $resultParticipant = $mysqli->query($participantSQL);
    unset($_POST["creation_submit"]);
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

    $sql = "INSERT INTO Conversation (idConv,Nom,dateCreation) VALUES (" . $id . ",'" . $mysqli->real_escape_string(trim($_POST["nom_conv"])) . "',NOW() )";
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

    // récuperer les conversations de l'étudiant connecté
    $convSQL = "SELECT Conversation.nom as nomConv, conversation.idConv as idConv FROM Membre, Conversation WHERE Membre.etudiant = " . $_SESSION["compte"] . " AND membre.conversation = conversation.idConv ";
    $resultConv = $mysqli->query($convSQL);

    $participantSQL = "SELECT Etudiant.nom as nomEtudiant, Etudiant.prenom as prenomEtudiant FROM Etudiant, Conversation, Membre WHERE Etudiant.idEtu = Membre.etudiant AND Membre.conversation = Conversation.idConv AND Conversation.idConv = " . $_SESSION['idConvCourante'];
    $resultParticipant = $mysqli->query($participantSQL);

    if (!$resultConv) {
        exit($mysqli->error);
    }


    $_SESSION['idConvCourante'] = $id;
    $_SESSION['etat'] = 0;
    unset($_POST["validation_creation"]);
}

// annuler nouvelle conversation
if (isset($_POST['annulation_creation']) && $_POST['annulation_creation'] == 1) {
    $_SESSION['etat'] = 0;
    $messageSQL = "SELECT contenu, Etudiant.nom as nomEmetteur, Etudiant.prenom as prenomEmetteur, emetteur, dateEnvoi FROM Message, Etudiant WHERE Message.emetteur = Etudiant.idEtu AND conversation = " . $_SESSION['idConvCourante'] . " ORDER BY dateEnvoi ASC";
    $resultMessage = $mysqli->query($messageSQL);
    $participantSQL = "SELECT Etudiant.nom as nomEtudiant, Etudiant.prenom as prenomEtudiant FROM Etudiant, Conversation, Membre WHERE Etudiant.idEtu = Membre.etudiant AND Membre.conversation = Conversation.idConv AND Conversation.idConv = " . $_SESSION['idConvCourante'];
    $resultParticipant = $mysqli->query($participantSQL);
    unset($_POST["annulation_creation"]);
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
    }
    $_SESSION['etat'] = 0;
    $messageSQL = "SELECT contenu, Etudiant.nom as nomEmetteur, Etudiant.prenom as prenomEmetteur, emetteur, dateEnvoi FROM Message, Etudiant WHERE Message.emetteur = Etudiant.idEtu AND conversation = " . $_SESSION['idConvCourante'] . " ORDER BY dateEnvoi ASC";
    $resultMessage = $mysqli->query($messageSQL);
    $participantSQL = "SELECT Etudiant.nom as nomEtudiant, Etudiant.prenom as prenomEtudiant FROM Etudiant, Conversation, Membre WHERE Etudiant.idEtu = Membre.etudiant AND Membre.conversation = Conversation.idConv AND Conversation.idConv = " . $_SESSION['idConvCourante'];
    $resultParticipant = $mysqli->query($participantSQL);
    unset($_POST["validation_ajout"]);
}

// annuler ajouter une personne
if (isset($_POST['annulation_ajout']) && $_POST['annulation_ajout'] == 1) {
    $_SESSION['etat'] = 0;
    $messageSQL = "SELECT contenu, Etudiant.nom as nomEmetteur, Etudiant.prenom as prenomEmetteur, emetteur, dateEnvoi FROM Message, Etudiant WHERE Message.emetteur = Etudiant.idEtu AND conversation = " . $_SESSION['idConvCourante'] . " ORDER BY dateEnvoi ASC";
    $resultMessage = $mysqli->query($messageSQL);
    $participantSQL = "SELECT Etudiant.nom as nomEtudiant, Etudiant.prenom as prenomEtudiant FROM Etudiant, Conversation, Membre WHERE Etudiant.idEtu = Membre.etudiant AND Membre.conversation = Conversation.idConv AND Conversation.idConv = " . $_SESSION['idConvCourante'];
    $resultParticipant = $mysqli->query($participantSQL);
    unset($_POST["annulation_ajout"]);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Accueil</title>
    <link rel="stylesheet" href="../style/navbar_style.css">
    <link rel="stylesheet" href="../style/conversation_style.css">
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
                        <li> <a href=<?php echo "profil.php?id=" . $_SESSION["compte"] ?> >Profil</a> </li>
                        <li> <a href="articles.php">Publier un article</a> </li>
                        <li> <a href="amis.php">Amis</a> </li>
                        <li> <a href='conversation.php' class="active"> Conversations </a> </li>
                        <li> <a href="./index.php?logout=1">Déconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>

            <nav class="small-nav">
                <form method="post">
                    <ul>
                        <li> <button class="small-nav-btn" type="submit" name='etat' value="0">Mes conversations</button></li>
                        <li> <button class="small-nav-btn" type="submit" name='etat' value="1">Ajouter des personnes à cette conversation</button></li>
                        <li> <button class="small-nav-btn" type="submit" name='etat' value="2">Créer une Conversation</button></li>
                    </ul>
                </form>
            </nav>


            <?php if ($_SESSION["etat"] == 0) { ?>
                <div id="liste-conversations">
                    <?php while ($conversation = $resultConv->fetch_assoc()) { ?>
                        <form method='post'>
                            <input type='hidden' name='nomConv' value='<?php echo str_replace("'", "‘",$conversation['nomConv']); ?>'>
                            <button type='submit' name="conv_courante" value='<?php echo $conversation['idConv'] ?>'><?php echo $conversation['nomConv'] ?></button>
                        </form>
                    <?php } ?>
                </div>
                <?php if (isset($_SESSION['idConvCourante'])) { ?>
                    <div class="conversation">
                        <div class='page-messages'>
                            <h1><?php echo $_SESSION['nomConvCourante']?></h1>
                            <div class="messages">
                                <?php
                                if (isset($resultMessage)) {
                                    while ($message = $resultMessage->fetch_assoc()) {
                                        if ($message['emetteur'] == $_SESSION['compte']) { ?>
                                            <div class="message-sortant">
                                                <h3 class="message-emetteur"><?php echo $message['prenomEmetteur'] . " " . $message['nomEmetteur'] ?></h3>
                                                <p> <?php echo $message['contenu'] ?> </p>
                                                <h6> <?php echo $message['dateEnvoi'] ?> </h6>
                                            </div>
                                        <?php } else { ?>
                                            <div class="message-entrant">
                                                <h3 class="message-emetteur"><?php echo $message['prenomEmetteur'] . " " . $message['nomEmetteur'] ?></h3>
                                                <p> <?php echo $message['contenu'] ?> </p>
                                                <h6> <?php echo $message['dateEnvoi'] ?> </h6>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <form method='post' class="envoi-message">
                                <input type="text" name="message" id="message" placeholder="Votre message">
                                <input type="submit" value="Envoyer" id="btn-envoyer" name="message_submit">
                            </form>
                        </div>
                        <div class='participants'>
                            <h3>Participants</h3>
                            <?php while ($participant = $resultParticipant->fetch_assoc()) { ?>
                                <div class="participant">
                                    <h4><?php echo $participant['prenomEtudiant'] . " " . $participant['nomEtudiant'] ?></h4>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } else if ($_SESSION['etat'] == 1) { ?>
                <?php if (isset($_SESSION['idConvCourante'])) { ?>
                    <div class="ajout-personne">
                        <h1>Ajouter une personne à la conversation</h1>
                        <form method="post">
                            <input type="text" name="mail" placeholder="Adresse mail de l'étudiant"></input>
                            <div class="boutons">
                                <button name="validation_ajout" value="1" type="submit">Ajouter</button>
                                <button name="annulation_ajout" value="1" type="submit">Annuler</button>
                            </div>
                        </form>
                    </div>
                <?php } ?>
            <?php } else if ($_SESSION['etat'] == 2) { ?>
                <div class="creation-conversation">
                    <h1>Créer une conversation</h1>
                    <form method="post">
                        <input type="text" name="nom_conv" placeholder="Nom de la conversation"></input>
                        <div class="boutons">
                            <button name="validation_creation" value="1" type="submit">Créer</button>
                            <button name="annulation_creation" value="1" type="submit">Annuler</button>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>
        <footer>
            <p>Copyright &copy; 2022 - Par Titouan Martin - Tous droits réservés</p>
            <?php $mysqli->close(); ?>
        </footer>
    </div>
</body>