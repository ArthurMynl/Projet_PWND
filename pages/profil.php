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
    "<h2> nom : " . $result["id"] . "</h1>";
    ?>
</body>