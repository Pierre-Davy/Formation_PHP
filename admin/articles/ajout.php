<?php

//on traite le formulaire
if (!empty($_POST)) {
    //POST n'est pas vide, on vérifie que toutes les données sont présentes
    if (
        isset($_POST["titre"], $_POST["contenu"])
        && !empty($_POST["titre"]) && !empty($_POST["contenu"])
    ) {
        //Le formulaire est complet
        //on récupère les données en les protégeant (faille xss)
        //on retire toutes balises du titre
        $titre = strip_tags($_POST["titre"]);

        //on neutralise toutes balises du contenu
        $contenu = htmlspecialchars($_POST["contenu"]);

        //on enregistre
        //on se connecte
        require_once "../../includes/connect.php";

        //on ecrit la requete
        $sql = "INSERT INTO `articles`(`title`, `content`) VALUES (:title, :content)";

        //on prepare la requete
        $requete = $db->prepare($sql);

        //on injecte les valeurs
        $requete->bindValue(":title", $titre, PDO::PARAM_STR);
        $requete->bindValue(":content", $contenu, PDO::PARAM_STR);

        //on execute la requete
        if (!$requete->execute()) {
            die("Une erreur est survenue");
        }

        //on recupère l'id de l'article
        $id = $db->lastInsertId();

        die("Article ajouté sous le numéro $id");

        //
    } else {
        die("Le formulaire est incomplet");
    }
}

$titre = "Ajouter un article";

//on inclut le header
include_once "../../includes/header.php";

//on inclut la navbar
include_once "../../includes/navbar.php";
?>
<h1>Ajouter un article</h1>

<form method="post">
    <div>
        <label for="titre">Titre</label>
        <input type="text" name="titre" id="titre">
    </div>
    <div>
        <label for="contenu">Contenu</label>
        <textarea name="contenu" id="contenu"></textarea>
    </div>
    <input type="submit" value="Enregistrer">


</form>



<?php
//on inclut le footer
include_once "../../includes/footer.php";
?>