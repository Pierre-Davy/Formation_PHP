<?php
session_start();
//on limite l'accès à cette page aux personnes connectées
if (!isset($_SESSION["user"])) {
    header("location: connexion.php");
    exit;
}
//on supprime une variable
unset($_SESSION["user"]);

header("location: index.php");
