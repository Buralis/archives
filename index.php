<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <! -- bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <! -- addon bootstrap -->
    <link rel="stylesheet" href="css/bootstrap_addon.css">
    <! -- js bootstrap -->
    <script src="js/jquery-3.4.1.slim.min.js" ></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <! -- fonctions -->
    <script src="js/fonctions.js"></script>
    <! -- plugin jquery-confirm -->
    <link rel="stylesheet" href="css/jquery-confirm.css">
    <script src="js/jquery-confirm.min.js"></script>
    <link rel="icon" type="image/png" href="icon/favicon.png" />
    <link rel="stylesheet" href="css/style.css">
    <title>Archives Municipales - Mairie de Saint-Junien</title>
    <!-- Licence clique -->
    <script src="js/clique.js"></script>
</head>
<body>

<?php
session_start();
date_default_timezone_set('Europe/Paris');
require_once ("options.php");
require_once("include/pdo.php");//méthode pdo (fonction)
require_once ("include/fonctions.php");
$pdo = PdoGsb::getPdoGsb();

if(isset($_GET['loading']) && $_GET['loading'] == "on") include("vues/vue_loading.php");//page de chargement

else if(!isset($_GET['loading'])||$_GET['loading']=="off"){
    include("controleurs/c_loading_on.php");//interface globale
    include ("vues/vue_pied_menu_pages.php");//menu pour changer de page
    include("vues/licence_clique.php");
}?>

<footer class="footer">
	<div class="container">
        <span class="text-muted">Tous droits réservés - Reproduction interdite</span>
	</div>
</footer>
</body>
</html>
