<?php

//nom du fichier à manipuler
$fichier = "resize-8922.jpg";

$image = __DIR__ . "/uploads/" . $fichier;

//on récupère les infos de l'image
$infos = getimagesize($image);

$largeur = $infos[0];
$hauteur = $infos[1];

//on crée une nouvelle image vierge

$nouvelleImage = imagecreatetruecolor($largeur / 8, $hauteur / 8);

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
    0, //position en X du coin supérieur gauche dans l'image source
    0, //position en Y du coin supérieur gauche dans l'image source
    $largeur / 8, // largeur dans l'image de destination
    $hauteur / 8, // hauteur dans l'image de destination
    $largeur, // largeur dans l'image source
    $hauteur, // hauteur dans l'image source
);

//on enregistre l'image sur le serveur
switch ($infos["mime"]) {
    case "image/png":
        //on enregistre l'image
        imagepng($nouvelleImage, __DIR__ . "/uploads/resize-" . $fichier);
        break;
    case "image/jpeg":
        //on enregistre l'image
        imagejpeg($nouvelleImage, __DIR__ . "/uploads/resize-" . $fichier);
        break;
    default:
        die("Une erreur s'est produite");
}

//on détruit les images dans la mémoire
imagedestroy($imageSource);
imagedestroy($nouvelleImage);
