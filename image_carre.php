<?php

//nom du fichier à manipuler
$fichier = "c1dbed61a7c77b53144c2a378e36bb51.png";

$image = __DIR__ . "/uploads/" . $fichier;

//on récupère les infos de l'image
$infos = getimagesize($image);

$largeur = $infos[0];
$hauteur = $infos[1];

//on doit vérifier si l'image est en portrait, paysage ou carre
switch ($largeur <=> $hauteur) {
    case -1:
        //largeur < hauteur -> portrait
        $tailleCarre = $largeur;
        $src_x = 0;
        $src_y = ($hauteur - $tailleCarre) / 2;
        break;
    case 0:
        //largeur = hauteur -> carre
        $tailleCarre = $largeur;
        $src_x = 0;
        $src_y = 0;
        break;
    case 1:
        //largeur > hauteur -> paysage
        $tailleCarre = $hauteur;
        $src_x = ($largeur - $tailleCarre) / 2;
        $src_y = 0;
        break;
    default:
        die("Image non valide");
}


//on crée une nouvelle image vierge
$nouvelleImage = imagecreatetruecolor(200, 200);

switch ($infos["mime"]) {
    case "image/png":
        //on ouvre l'image png
        $imageSource = imagecreatefrompng($image);
        break;
    case "image/jpeg":
        //on ouvre l'image jpeg
        $imageSource = imagecreatefromjpeg($image);
        break;
    default:
        die("Format d'image incorrect");
}

//on copie toute l'image source dans l'image de destination en la réduisant
imagecopyresampled(
    $nouvelleImage, // image de destination
    $imageSource, // image de départ
    0, //position en X du coin supérieur gauche dans l'image de destination
    0, //position en Y du coin supérieur gauche dans l'image de destination
    $src_x, //position en X du coin supérieur gauche dans l'image source
    $src_y, //position en Y du coin supérieur gauche dans l'image source
    200, // largeur dans l'image de destination
    200, // hauteur dans l'image de destination
    $tailleCarre, // largeur dans l'image source
    $tailleCarre, // hauteur dans l'image source
);

//on enregistre l'image sur le serveur
switch ($infos["mime"]) {
    case "image/png":
        //on enregistre l'image
        imagepng($nouvelleImage, __DIR__ . "/uploads/carre-" . $fichier);
        break;
    case "image/jpeg":
        //on enregistre l'image
        imagejpeg($nouvelleImage, __DIR__ . "/uploads/carre-" . $fichier);
        break;
    default:
        die("Une erreur s'est produite");
}

//on détruit les images dans la mémoire
imagedestroy($imageSource);
imagedestroy($nouvelleImage);
