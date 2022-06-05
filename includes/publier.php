<?php 
include_once "core.php";

if (isset($_POST['article_delete'])) {
    unset($_SESSION['media']);
    unset($_SESSION['ext_valid']);
    unset($_SESSION['contenu']);
    unset($_SESSION['visibilite']);
}

else {
    $contenu = $mysqli->real_escape_string(trim($_SESSION['contenu']));

    $sql = "INSERT INTO Article(contenu, media, dateCreation, visibilite, auteur) VALUES ('$contenu', '$_SESSION[media]', '$_SESSION[now]', '$_SESSION[visibilite]', '$_SESSION[compte]')";
    $result = $mysqli->query($sql);
    if (!$result) {
        echo $sql;
        exit($mysqli->error);
    }

    unset($_SESSION["contenu"]);
    unset($_SESSION["media"]);
    unset($_SESSION["visibilite"]);
}

header("Location: ../pages/articles.php");