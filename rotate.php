<?php

//nom du fichier à manipuler
$fichier = "c1dbed61a7c77b53144c2a378e36bb51.png";

$image = __DIR__ . "/uploads/" . $fichier;

//on récupère les infos de l'image
$infos = getimagesize($image);

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

// on tourne l'image
$nouvelleImage = imagerotate($imageSource, 45, 0);

//on enregistre l'image sur le serveur
switch ($infos["mime"]) {
    case "image/png":
        //on enregistre l'image
        imagepng($nouvelleImage, __DIR__ . "/uploads/rotate-" . $fichier);
        break;
    case "image/jpeg":
        //on enregistre l'image
        imagejpeg($nouvelleImage, __DIR__ . "/uploads/rotate-" . $fichier);
        break;
    default:
        die("Une erreur s'est produite");
}

//on détruit les images dans la mémoire
imagedestroy($imageSource);
imagedestroy($nouvelleImage);
