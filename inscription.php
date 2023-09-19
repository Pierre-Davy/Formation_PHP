<?php
//on demarre la session php
session_start();
//on limite l'accès à cette page aux personnes non connectées
if (isset($_SESSION["user"])) {
    header("location: index.php");
    exit;
}

$titre = "Inscription";

//on vérifie si le formulaire a été envoyé
if (!empty($_POST)) {
    //le formulaire a ete envoyé
    //on verifie que les champs requis soit complet
    if (isset($_POST["nickname"], $_POST["email"], $_POST["password"]) && !empty($_POST["nickname"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
        //le formulaire est complet
        //on récupère les données en les protégeant
        $pseudo = strip_tags($_POST["nickname"]);

        //on vérifie si le mail est valide
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            die("L'adresse email est incorrecte");
        } else {
            $email = strip_tags($_POST["email"]);
        }

        //on va hasher le mot de passe
        $pass = password_hash($_POST["password"], PASSWORD_ARGON2ID);

        //on ajoute les controles de securité


        //on enregistre en base de donnée
        require_once "includes/connect.php";

        $sql = "INSERT INTO `utilisateurs` (`username`, `email`,`password`,`role`) VALUES (:pseudo, :email, '$pass', '[\"ROLE_USER\"]')";

        $query = $db->prepare($sql);
        $query->bindValue(":pseudo", $pseudo, PDO::PARAM_STR);
        $query->bindValue(":email", $email, PDO::PARAM_STR);

        $query->execute();

        //onrecupere l'id du nouvel user
        $id = $db->lastInsertId();


        //on stocke dans la session les informations de l'utilisateur
        $_SESSION["user"] = [
            "id" => $id,
            "pseudo" => $pseudo,
            "email" => $_POST["email"],
            "roles" => $user["ROLE_USER"]
        ];

        //on redirige vers la page de profil
        header("location: profil.php");


        echo "Vous etes enregistré";
    } else {
        die("Le formulaire n'est pas complet");
    }
}



//on inclut le header
include "includes/header.php";
//on inclut la navbar
include "includes/navbar.php";
?>

<h1>Inscription</h1>

<form method="post">
    <div>
        <label for="pseudo">Pseudo</label>
        <input type="text" name="nickname" id="pseudo">
    </div>
    <div>
        <label for="email">Email</label>
        <input type="text" name="email" id="email">
    </div>
    <div>
        <label for="pass">Mot de passe</label>
        <input type="password" name="password" id="pass">
    </div>
    <button type="submit">Enregistrer</button>
</form>

<?php
//connection à la base de données
require_once "includes/connect.php";




//on inclut le footer
include "includes/footer.php";
