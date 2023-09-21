<?php

//nom du fichier à manipuler
$fichier = "c1dbed61a7c77b53144c2a378e36bb51.png";
$logoImage = "resize-resize-8922.jpg";

$image = __DIR__ . "/uploads/" . $fichier;

//on récupère les infos de l'image
$infos = getimagesize($image);

$largeur = $infos[0];
$hauteur = $infos[1];


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

//on ouvre la deuxieme image
$logo = imagecreatefromjpeg(__DIR__ . "/uploads/" . $logoImage);
$infoLogo = getimagesize(__DIR__ . "/uploads/" . $logoImage);

//on copie toute l'image source dans l'image de destination en la réduisant
imagecopyresampled(
    $imageSource, // image de destination
    $logo, // image de départ
    $infos[0] - $infoLogo[0] - 10, //position en X du coin supérieur gauche dans l'image de destination
    $infos[1] - $infoLogo[1] - 10, //position en Y du coin supérieur gauche dans l'image de destination
    0, //position en X du coin supérieur gauche dans l'image source
    0, //position en Y du coin supérieur gauche dans l'image source
    $infos[0], // largeur dans l'image de destination
    $infos[1], // hauteur dans l'image de destination
    $infos[0], // largeur dans l'image source
    $infos[1], // hauteur dans l'image source
);

//on enregistre l'image sur le serveur
switch ($infos["mime"]) {
    case "image/png":
        //on enregistre l'image
        imagepng($imageSource, __DIR__ . "/uploads/wm-" . $fichier);
        break;
    case "image/jpeg":
        //on enregistre l'image
        imagejpeg($imageSource, __DIR__ . "/uploads/wm-" . $fichier);
        break;
    default:
        die("Une erreur s'est produite");
}

//on détruit les images dans la mémoire
imagedestroy($imageSource);
imagedestroy($logo);
