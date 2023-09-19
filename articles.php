<?php
//on demarre la session php
session_start();

//on va chercher les articles dans la base
//on se connecte à la base

require_once "includes/connect.php";

//on ecrit la requete
$sql = "SELECT * FROM `articles` ORDER BY `created_at` DESC";

//on execute la requete
$requete = $db->query($sql);

//on recupere les données
$articles = $requete->fetchall();

$titre = "liste des articles";
//on inclut le header
include "includes/header.php";
//on inclut la navbar
include "includes/navbar.php";
?>

<h1>Liste des articles</h1>

<section>
    <?php foreach ($articles as $article) : ?>
        <article>
            <h2><a href="article.php?id=<?= $article["id"] ?>"><?php echo strip_tags($article["title"]) ?></a></h2>
            <p>Publié le <?php echo $article["created_at"] ?></p>
            <div><?php echo strip_tags($article["content"]) ?></div>
        </article>


    <?php
    endforeach; ?>
</section>
<?php
//on inclut le footer
include "includes/footer.php";
