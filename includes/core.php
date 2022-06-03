<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$infoBdd = [
    "server" => "localhost",
    "login" => "root",
    "password" => "root",
    "db_name" => "projet"
];

$mysqli = new mysqli($infoBdd["server"], $infoBdd["login"], $infoBdd["password"], $infoBdd["db_name"]);

if ($mysqli->connect_errno) {
    exit("Problème de connexion à la BDD");
}

session_start();
