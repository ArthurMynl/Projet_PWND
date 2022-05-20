<?php

$infoBdd = [
    "server" => "localhost",
    "login" => "root",
    "password" => "root",
    "db_name" => "projet"
];

session_start();

if (isset($_POST["connexion_submit"]) && $_POST["connexion_submit"] == 1) {

    $mysqli = new mysqli($infoBdd["server"], $infoBdd["login"], $infoBdd["password"], $infoBdd["db_name"]);

    if ($mysqli->connect_errno) {
        exit("Problème de connexion à la BDD");
    }

    $sql = "SELECT idEtu FROM Etudiant WHERE email = '" . trim($_POST['mail']) . "' AND motDePasse = '" . trim($_POST["password"]) . "'";

    $result = $mysqli->query($sql);
    if (!$result) {
        exit($mysqli->error);
    }

    $mail_escaped = $mysqli->real_escape_string(trim($_POST["mail"]));
    $password_escaped = $mysqli->real_escape_string(trim($_POST["password"]));

    $nb = $result->num_rows;

    if ($nb) {
        //récupération de l’id de l’étudiant
        $row = $result->fetch_assoc();
        $_SESSION["compte"] = $row["idEtu"];
    }
}

if (isset($_POST["inscription_submit"]) && $_POST["inscription_submit"] == 1) {
    if($_POST['password'] == $_POST['password_confirm']) {
        $mysqli = new mysqli($infoBdd["server"], $infoBdd["login"], $infoBdd["password"], $infoBdd["db_name"]);

        if ($mysqli->connect_errno) {
            exit("Problème de connexion à la BDD");
        }

        $sql = "INSERT INTO Etudiant (nom, prenom, anneeScolaire, email, motDePasse) VALUES ('" . trim($_POST["nom"]) . "', '" . trim($_POST["prenom"]) . "', '" . trim($_POST["annees"]) . "', '" . trim($_POST["login"]) . "', '" . trim($_POST["password"]) . "')";

        $result = $mysqli->query($sql);
        if (!$result) {
            exit($mysqli->error);
        }

        $sql = "SELECT idEtu FROM Etudiant WHERE email = '" . trim($_POST['login']) . "' AND motDePasse = '" . trim($_POST["password"]) . "'";

        $result = $mysqli->query($sql);
        if (!$result) {
            exit($mysqli->error);
        }

        $mail_escaped = $mysqli->real_escape_string(trim($_POST['login']));
        $password_escaped = $mysqli->real_escape_string(trim($_POST['password']));

        $nb = $result->num_rows;

        if ($nb) {
            //récupération de l’id de l’étudiant
            $row = $result->fetch_assoc();
            $_SESSION["compte"] = $row["idEtu"];
        }
    }
}


if ($_GET["logout"] == 1) {
    unset($_SESSION["compte"]);
    header('Location: ./index.php');
}

