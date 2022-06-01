<?php
    include 'core.php';

    $_TITRE_PAGE = 'Conversation';
    $_SESSION['etat'] = 0;
    $sql = "SELECT conversation FROM Membre WHERE etudiant = ". $_SESSION["compte"];
    $resultConv = $mysqli->query($sql); 
            
    if (!$resultConv) {
        exit($mysqli->error);
    }

    $nbConv = $resultConv -> num_rows;

    if(isset($_POST['message_submit']) && $_POST['message_submit'] == 1){
        $sql = "SELECT MAX(idMess)  FROM Message";
        $res = $mysqli->query($sql);
        if (!$res) {
            exit($mysqli->error);
        }
        $row=$res->fetch_row();
        $id = $row[0]+1;
        $sql = "INSERT INTO Message (idMess,contenu,dateEnvoi,conversation,emetteur) VALUES (".$id.",'" . trim($_POST["contenu"]) . "',NOW()," . $_SESSION['idConvCourrante'] . "," .$_SESSION['compte'].")"  ;
        $result = $mysqli->query($sql);
        if (!$result) {
            exit($mysqli->error);
        }
        unset($_POST["message_submit"]);
    }
    if(isset($_POST['conv_courrante'])){
        $_SESSION['idConvCourrante'] = $_POST['conv_courrante'];
    }

    if(isset($_POST['creation_submit']) && $_POST['creation_submit'] == 1){
        $_SESSION['etat'] = 1;
    }

    if(isset($_POST['ajout_submit']) && $_POST['ajout_submit'] == 1){
        $_SESSION['etat'] = 2;
    }

    if(isset($_POST['validation_creation']) && $_POST['validation_creation'] == 1){
        $sql = "SELECT MAX(idConv)  FROM Conversation";
        $res = $mysqli->query($sql);
        if (!$res) {
            exit($mysqli->error);
        }
        $row=$res->fetch_row();
        $id = $row[0]+1;

        $sql = "INSERT INTO Conversation (idConv,Nom,dateCreation) VALUES (".$id.",'".trim($_POST["nom"])."',NOW() )";
        $result = $mysqli->query($sql);
        if (!$result) {
            exit($mysqli->error);
        }
        $sql = "INSERT INTO Membre (conversation,etudiant) VALUES (".$id.",".$_SESSION['compte'].")";
        $result = $mysqli->query($sql);
        if (!$result) {
            exit($mysqli->error);
        }
        $sql = "SELECT conversation FROM Membre WHERE etudiant = ". $_SESSION["compte"];
        $resultConv = $mysqli->query($sql); 
                
        if (!$resultConv) {
            exit($mysqli->error);
        }

        $nbConv = $resultConv -> num_rows;
        $_SESSION['etat'] == 0;
    }
    if(isset($_POST['annulation_creation']) && $_POST['annulation_creation'] == 1){
        $_SESSION['etat'] == 0;
    }

    if(isset($_POST['validation_ajout']) && $_POST['validation_ajout'] == 1){
        $mail_escaped = $mysqli->real_escape_string(trim($_POST['mail'])); 
        $sql = "SELECT idEtu
            FROM Etudiant
            WHERE email = '".$mail_escaped."'";
        $result = $mysqli->query($sql); 
                
        if (!$result) {
            exit($mysqli->error);
        }

        $nb = $result->num_rows;
        if ($nb) {
            $row = $result->fetch_assoc();
            echo $sql;
            $sql = "INSERT INTO Membre (conversation,etudiant) VALUES (".$_SESSION['idConvCourrante'].",".$row['idEtu'].")";
            $result= $mysqli->query($sql); 
                
            if (!$result) {
                exit($mysqli->error);
            }
            $_SESSION['etat'] == 0;
        }
    } 
    if(isset($_POST['annulation_ajout']) && $_POST['annulation_ajout'] == 1){
        $_SESSION['etat'] == 0;
    }
?>

<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="conversation.css">
        <title><?php echo $_TITRE_PAGE ?></title>
    </head>
    <body>
    <nav class="navbar">
                <ul>
                    <li> <img src="../assets/logo.png" id="logo"> </li>
                    <li> <a href="/pages/index.php" class="active">Accueil</a> </li>
                    <li> <a href="/pages/etudiants.php">Étudiants</a> </li>
                    <?php if ($_SESSION["compte"]) { ?>
                        <?php
                        echo "<li> <a href='profil.php?id=" . $_SESSION["compte"] . "'>Profil</a> </li>";
                        echo "<li><a href='edit_profil.php?id=".$_SESSION["compte"]."'>Mettre à jour le profil</a></li>";
                        echo "<li> <a href='articles.php?id=".$_SESSION["compte"]."'>Publier un article</a> </li>";
                        ?>
                        <li> <a href="./index.php?logout=1">Déconnexion</a> </li>

                    <?php } ?>
                </ul>
            </nav>
            <form method=post >
            <button name="creation_submit" value="1" type="submit" class="creation">Nouvelle conversation</button>
            
            
            <?php 
            if ( $_SESSION['etat'] == 0){
                if ($nbConv>0  ){
                    while($row = mysqli_fetch_assoc($resultConv)) {
                        $sql = "SELECT nom FROM Conversation WHERE idConv =". $row["conversation"];
                        $res = $mysqli->query($sql); 
                                
                        if (!$res) {
                            exit($mysqli->error);
                        }
                        
                        $rowNom=$res->fetch_row();
                        $nom=$rowNom[0];
                        $idConv = $row["conversation"];
                        ?>
                        <div>
                        <button name="conv_courrante" value=<?php echo $idConv?> type="submit" class="select_conv"><h4><?php echo $nom ?></h4></button>
                    </div>
                    <?php }
            
                    ?> </div>
        </form>              
            
                    <?php if  (isset($_SESSION['idConvCourrante'])) {
                            ?><button name="ajout_submit" value="1" type="submit" class="ajout">Ajouter Membre</button>
                            <h3><?php
                            $sql = "SELECT nom FROM Conversation WHERE idConv =". $_SESSION["idConvCourrante"];
                            
                            $res = $mysqli->query($sql); 
                                    
                            if (!$res) {
                                exit($mysqli->error);
                            }
                            
                            $rowNom=$res->fetch_row();
                            $nom=$rowNom[0];
                            echo $nom;
                            ?></h3><div class="message">
                                <?php
                            $sql = "SELECT idMess FROM Message WHERE conversation = ". $_SESSION["idConvCourrante"];
                            $resultMess = $mysqli->query($sql); 
                                    
                            if (!$resultMess) {
                                exit($mysqli->error);
                            }
                        
                            $nbMess = $resultMess -> num_rows;
                            while($row = mysqli_fetch_assoc($resultMess)) {
                                
                                $sql = "SELECT contenu,emetteur FROM Message WHERE idMess =". $row["idMess"];
                                $res = $mysqli->query($sql); 
                                        
                                if (!$res) {
                                    exit($mysqli->error);
                                }
                                
                                $rowContenu=$res->fetch_row();
                                $contenu=$rowContenu[0];
                                $emetteur = $rowContenu[1];
                                if ($emetteur == $_SESSION['compte']){ ?>
                <div class="message_envoyer">
                                        <?php echo $contenu;?>
                </div>
                                <?php } else { ?>
                <div class="message_recu">
                                    <?php 
                                        $sql = "SELECT prenom FROM Etudiant WHERE idEtu =". $emetteur;
                                        $res = $mysqli->query($sql); 
                                        if (!$res) {
                                            exit($mysqli->error);
                                        }
                                        $rowNom=$res->fetch_row();
                                        $nomEmetteur = $rowNom[0];
                                        echo $nomEmetteur. " : <br>";
                                        echo $contenu;
                                        ?>
                </div>
                                <?php }       
                            }
                         ?>
            <form method = post>
                        <input type="text" name="contenu" placeholder="Ecrire un message">
                        <button name="message_submit" value="1" type="submit" class="envoi_message">Envoyer</button>
            </form>
        <div>
          
        
                <?php   } 
                    
                }else{
                    echo "Pas de Conversation";
                }
                }else if ($_SESSION['etat'] == 1){
                    echo "Création d'une conversation";
                    ?>
                <form method = post>
                    <input type="text" name="nom" placeholder="Nom de la conversation ">
                    <button name="validation_creation" value="1" type="submit">Creer</button>
                    <button name="annulation_creation" value="1" type="submit">Annuler</button>
                </form>
                    <?php
               }else if ($_SESSION['etat'] == 2){
                   ?>
                   <form method = post>
                    <input type="text" name="mail" placeholder="Email du membre">
                    <button name="validation_ajout" value="1" type="submit">Ajouter</button>
                    <button name="annulation_ajout" value="1" type="submit">Annuler</button>
                </form>
                <?php
               }
        ?>
        </div>

    </body>
</html>

