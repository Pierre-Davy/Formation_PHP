<?php
session_start();

$titre = "Mon profil";



//on inclut le header
include "includes/header.php";

//on inclut la navbar
include "includes/navbar.php";
?>

<h1>Profil de <?= $_SESSION["user"]["pseudo"] ?></h1>

<p>Pseudo : <?= $_SESSION["user"]["pseudo"] ?></p>
<p>Email : <?= $_SESSION["user"]["email"] ?></p>

<?php

//on inclut le footer
include "includes/footer.php";
