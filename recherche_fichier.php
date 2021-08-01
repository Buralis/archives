<?php
require_once("include/pdo.php");
require_once("include/fonctions.php");
$pdo = PdoGsb::getPdoGsb();

$lien_img = "application/jpg/";
$lien_pdf = "application/pdf/";

foreach ($pdo->recherche_manquant() as $item){
    if (!file_exists($lien_pdf.$item['fichier']) && !file_exists($lien_img.str_replace(".pdf", ".jpg", $item['fichier']))){
        echo "id : ".$item['id']." titre : ".$item['titre']." nom fichier : ".str_replace(".pdf", "", $item['fichier'])." pdf x, jpg x <br><br>";
    }
    else if (!file_exists($lien_pdf.$item['fichier']) && file_exists($lien_img.str_replace(".pdf", ".jpg", $item['fichier']))) {
        echo "id : ".$item['id']." titre : ".$item['titre']." nom fichier : ".str_replace(".pdf", "", $item['fichier'])." pdf x, jpg v <br><br>";
    }
    else if (!file_exists($lien_img.str_replace(".pdf", ".jpg", $item['fichier']))){
        echo "id : ".$item['id']." titre : ".$item['titre']." nom fichier : ".str_replace(".pdf", "", $item['fichier'])." pdf v, jpg x <br><br>";
    }
}
