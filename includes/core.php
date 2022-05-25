<?php

$infoBdd = [
    "server" => "localhost",
    "login" => "pwnd",
    "password" => "network",
    "db_name" => "projet"
];

$mysqli = new mysqli($infoBdd["server"], $infoBdd["login"], $infoBdd["password"], $infoBdd["db_name"]);

if ($mysqli->connect_errno) {
    exit("Problème de connexion à la BDD");
}

session_start();
