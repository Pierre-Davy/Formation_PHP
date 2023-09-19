<?php
//on demarre la session php
session_start();

$titre = "Accueil";

require_once "includes/functions.php";
//on inclut le header
include "includes/header.php";
//on inclut la navbar
include "includes/navbar.php";
?>

<p>Contenu de la page Accueil</p>

<?php
//connection à la base de données
require_once "includes/connect.php";

$username = "Nicolas";
$password = "123456";

$sql = "SELECT * FROM `utilisateurs` WHERE `username`=:username AND `password`=:pass";

//on prepare la requete
$requete = $db->prepare($sql);

// on injecte les valeurs "bindValue"
$requete->bindValue(":username", $username, PDO::PARAM_STR);
$requete->bindValue(":pass", $password, PDO::PARAM_STR);

//on execute
$requete->execute();

$user = $requete->fetchAll(PDO::FETCH_ASSOC);


echo "<pre>";
var_dump($user);
echo "</pre>";

//on inclut le footer
include "includes/footer.php";
