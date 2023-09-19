<?php

// contantes d'environnement
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "");
define("DBNAME", "tuto1");

//dsn de connexion
$dsn = "mysql:dbname=" . DBNAME . ";host=" . DBHOST;

// on se connect à la base

try {
    // on se connecte à la base de données en instanciant PDO
    $db = new PDO($dsn, DBUSER, DBPASS);

    // on defini le charset en utf8
    $db->exec("SET NAMES utf8");

    // on defini la methode de recuperation (fetch) des données
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die($e->getMessage());
}
