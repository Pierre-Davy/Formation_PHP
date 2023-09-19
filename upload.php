<?php
//on vérifie si un fichier a été envoyé
if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
    //on a reçu l'image
    var_dump($_FILES);
    //on procède aux vérifications
    //on vérifie toujours l'extension et le type MIME
    $allowed = [
        "jpg" => "image/jpeg",
        "jpeg" => "image/jpeg",
        "png" => "image/png",
        "pdf" => "application/pdf"
    ];

    $filename = $_FILES["image"]["name"];
    $filetype = $_FILES["image"]["type"];
    $filesize = $_FILES["image"]["size"];

    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    //on vérifie l'absence de l'extension dans les clés ou l'absence de type mime dans les valeurs.
    if (!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)) {
        //ici, soit l'extension, soit le type, sont incorrect
        die("Format de fichier incorrect");
    }

    //ici le type est correct
    // on limite à 1Mo
    if ($filesize > 1024 * 1024) {
        die("Le fichier est trop volumineux");
    }

    //on génere un nom unique
    $newname = md5(uniqid());

    //on indique le chemin d'accès
    $newfilename = __DIR__ . "/uploads/$newname.$extension";

    //on déplace le fichier de tmp à uploads en le renomant
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $newfilename)) {
        die("une erreur s'est produite");
    }

    //on interdit l'exécution du fichier
    chmod($newfilename, 0644);
} else {
    var_dump($_FILES);
    if (!empty($_FILES["image"]["error"])) {
        $i = $_FILES["image"]["error"];
        switch ($i) {
            case 1:
                die("Votre fichier est trop volumineux");
                break;
            case 2:
                die("Votre fichier est trop volumineux");
                break;
            case 3:
                die("Une erreur s'est produite lors de la transmission de votre fichier");
                break;
            case 6:
                die("Une erreur interne s'est produite");
                break;
            case 7:
                die("Une erreur interne s'est produite");
                break;
            case 8:
                die("L'extension de votre fichier n'est pas valide");
                break;
            default:
                die("Une erreur interne s'est produite");
        }
    } else {
        die("Une erreur interne s'est produite");
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Ajout de fichier</h1>
    <form method="post" enctype="multipart/form-data">
        <div>
            <label for="fichier">Mon fichier : </label>
            <input type="file" id="fichier" name="image">
            <button type="submit">Envoyer</button>
        </div>
    </form>

</body>

</html>