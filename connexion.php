<?php
//on demarre la session php
session_start();
//on limite l'accès à cette page aux personnes non connectées
if (isset($_SESSION["user"])) {
    header("location: index.php");
    exit;
}

$titre = "Connexion";

//on vérifie si le formulaire a été envoyé
if (!empty($_POST)) {
    //le formulaire a ete envoyé
    //on verifie que les champs requis soit complet
    if (isset($_POST["nickname"]) && isset($_POST["password"]) && !empty($_POST["nickname"]) && !empty($_POST["password"])) {

        // on se connecte à la bdd
        require_once "includes/connect.php";

        //on verifie que le pseudo est connu de la bdd
        $sql = "SELECT * FROM `utilisateurs` WHERE `username`=:pseudo";

        $query = $db->prepare($sql);
        $query->bindValue(":pseudo", $_POST["nickname"], PDO::PARAM_STR);
        $query->execute();

        $user = $query->fetch();

        if (!$user) {
            die("L'utilisateur et/ou le mot de passe est incorrect");
        }

        //ici on a un user existant, o peut verifier le mot de passe
        if (!password_verify($_POST["password"], $user["password"])) {
            die("L'utilisateur et/ou le mot de passe est incorrect");
        }

        // ici, l'utilisateur et le mot de passe sont correct
        //on va pouvoir connecter l'utilisateur


        //on stocke dans la session les informations de l'utilisateur
        $_SESSION["user"] = [
            "id" => $user["id"],
            "pseudo" => $user["username"],
            "email" => $user["email"],
            "roles" => $user["role"]
        ];

        //on redirige vers la page de profil
        header("location: profil.php");
    }
}

//on inclut le header
include "includes/header.php";

//on inclut la navbar
include "includes/navbar.php";
?>

<h1>Connexion</h1>

<form method="post">
    <div>
        <label for="pseudo">Pseudo</label>
        <input type="text" name="nickname" id="pseudo">
    </div>
    <div>
        <label for="pass">Mot de passe</label>
        <input type="password" name="password" id="pass">
    </div>
    <button type="submit">Se connecter</button>
</form>

<?php

//on inclut le footer
include "includes/footer.php";
