<?php 

include_once "core.php";

if(isset($_POST['upload'])) {
    $file_name = $_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_extension = pathinfo($file_name)["extension"];
    $folder = '../assets/media/';

    // get the article id from the database
    $sql = "SELECT MAX(idArt) FROM articles WHERE auteur =" . $_SESSION['compte'];
    $result = $mysqli->query($sql);
    if($result) {
        if ($result->num_rows > 0) {
        $result->fetch_assoc();
            $article_id = $row['MAX(id)'];
        }
    } else {
        $article_id = 1;
    }

    $new_file_name = $_SESSION['compte'] . '-' . $article_id . '.' . $file_extension;

    $final_file = str_replace(' ', '-', $new_file_name);

    move_uploaded_file($file_loc, $folder.$final_file); 

    $sql = "INSERT INTO Article (media) VALUES ($final_file)";
    $result = $mysqli->query($sql);

    if($result) {
        $valid = true;
    } else {
        $valid = false;
    }

    header("Location: ../pages/articles.php");
}
