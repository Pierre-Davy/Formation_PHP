<?php
// on verifie si on a un id
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    //je n'ai pas de id
    header('location: articles.php');
    exit;
}

// je recupere l'id
$id = $_GET["id"];

//on va chercher l'article dans la base
//on se connecte à la base
require_once "includes/connect.php";

//on ecrit la requete
$sql = "SELECT * FROM `articles` WHERE `id`= :id";

//on prepare la requete
$requete = $db->prepare($sql);

//on injecte les parametres
$requete->bindValue(":id", $id, PDO::PARAM_INT);

//on execute la requete
$requete->execute();

//on recupere l'article
$article = $requete->fetch();

// on verifie si l'article est vide
if (!$article) {
    //pas d'article, erreur 404
    http_response_code(404);
    echo "Article inexistant";
    exit;
}

//on a un article
$titre = strip_tags($article["title"]);




//on inclut le header
include "includes/header.php";
//on inclut la navbar
include "includes/navbar.php";
?>


<article>
    <h2><?php echo strip_tags($article["title"]) ?></h2>
    <p>Publié le <?php echo $article["created_at"] ?></p>
    <div><?php echo strip_tags($article["content"]) ?></div>
</article>

<?php
//on inclut le footer
include "includes/footer.php";
