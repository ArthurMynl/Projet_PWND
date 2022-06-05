<?php 

include_once "core.php";

$extensionsAutorisees = array("jpeg", "jpg", "gif", "png");

if(isset($_POST['upload'])) {
    $file_name = $_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_extension = pathinfo($file_name)["extension"];
    $folder = '../assets/media/';

    // get the article id from the database
    $sql = "SELECT MAX(idArt) FROM Article";
    $res = $mysqli->query($sql);
    if (!$res) {
        exit($mysqli->error);
    }
    $row = $res->fetch_row();
    $article_id = $row[0] + 1;

    $new_file_name = $_SESSION['compte'] . '-' . $article_id . '.' . $file_extension;

    $final_file = str_replace(' ', '-', $new_file_name);

    if ((in_array($file_extension, $extensionsAutorisees))) {
        move_uploaded_file($file_loc, $folder.$final_file); 
        $_SESSION['media'] = $final_file;
        $_SESSION['ext_valid'] = true;
    } else {
        $_SESSION['ext_valid'] = false;
    }

    $_SESSION['contenu'] = $_POST['contenu'];
    $_SESSION['visibilite'] = $_POST['visibilite'];

    header("Location: ../pages/articles.php");
}
