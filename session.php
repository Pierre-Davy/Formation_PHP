<?php
session_start();
var_dump($_SESSION);

$_SESSION["panier"] = [
    "produit" => [
        "brouette", "chaise", "table"
    ]
];
