<?php

//isset chaque
!isset($_GET['menu']) ? $_GET['menu']="tout" : null;
!isset($_GET['page']) ?  $_GET['page']=1 : null;
!isset($_GET['nb']) ? $_GET['nb']=20 : null ;

if(!isset($_GET['keyword'])){
    echo "<script>includeGET('keyword=')</script>";
}
if(!isset($_GET['journal'])){
    echo "<script>includeGET('journal=')</script>";
}

//recherche(mot,*pr case,*nb case,choix menu,date début ,date fin,tri date default 0,tri titre default 0)

$dd = false;
$df = false;
$jn = false;
$td = false;
$type_recherche = false;

if(isset($_GET['date_debut'])){
    if(!isset($_SESSION['date_debut'])){
        $_SESSION['date_debut'] = "";
    }
    if($_SESSION['date_debut']!=$_GET['date_debut']){
        $dd =true;
    }
}

if(isset($_GET['date_fin'])){
    if(!isset($_SESSION['date_fin'])){
        $_SESSION['date_fin'] = "";
    }
    if($_SESSION['date_fin']!=$_GET['date_fin']){
        $df =true;
    }
}

if(isset($_GET['journal'])){
    if(!isset($_SESSION['journal'])){
        $_SESSION['journal'] = "";
    }
    if($_SESSION['journal']!=$_GET['journal'] & isset($_GET['recherche'])){
        if($_GET['recherche'] == "true"){
            $jn =true;
        }
    }
}

if(isset($_GET['td'])){
    if(!isset($_SESSION['td'])){
        $_SESSION['td'] = "";
    }
    if($_SESSION['td']!=$_GET['td']){
        $td =true;
    }
}

if(isset($_GET['type_recherche'])){
    if(!isset($_SESSION['type_recherche'])){
        $_SESSION['type_recherche'] = "";
    }
    if($_SESSION['type_recherche']!=$_GET['type_recherche']){
        $type_recherche =true;
    }
}

if(!isset($_SESSION['keyword'])|| $_SESSION['keyword']!=$_GET['keyword']|| $dd|| $df || $jn || $td || $type_recherche) { // On vérifie si au moins un élément est défini
    $_SESSION['table'] = $pdo->recherche( // On envoi les données à la fonction Recherche de pdo.php
        isset($_GET['keyword']) && strlen($_GET['keyword']) > 0 ? $_GET['keyword'] : null,
        isset($_GET['journal']) && strlen($_GET['journal']) > 0 ? $_GET['journal'] : null,
        isset($_GET['date_debut']) && strlen($_GET['date_debut']) > 0 ? $_GET['date_debut'] : null,
        isset($_GET['date_fin']) && strlen($_GET['date_fin']) > 0 ? $_GET['date_fin'] : null,
        isset($_GET['td']) && strlen($_GET['td']) > 0 ? $_GET['td'] : null,
        null,
        isset($_GET['type_recherche']) && strlen($_GET['type_recherche']) > 0 ? $_GET['type_recherche'] : null
        );

    isset( $_GET['keyword']) ? $_SESSION['keyword'] = $_GET['keyword'] : null;
    isset( $_GET['journal']) ? $_SESSION['journal'] = $_GET['journal'] : null;
    isset( $_GET['date_debut']) ? $_SESSION['date_debut'] = $_GET['date_debut'] : null;
    isset( $_GET['date_fin']) ? $_SESSION['date_fin'] = $_GET['date_fin'] : null;
    isset( $_GET['td']) ? $_SESSION['td'] = $_GET['td'] : null;
    isset( $_GET['type_recherche']) ? $_SESSION['type_recherche'] = $_GET['type_recherche'] : null;

    if(isset( $_GET['recherche'])){
        echo "<script>includeGET('recherche=false');</script>";
    }
}
?>
<div class="big_container">
    <?php
    include('vues/vue_recherche_bar.php'); ?>
        <div class="recherche_container"
        <?php
        include('vues/vue_taille_page.php')?>
        <?php include('vues/vue_recherche_date.php') ?>
        </div>
    <div class="album py-5" id="content">
        <div class="container">
            <div class="row">
                <?php
                    if(isset($_GET['menu'])){
                        switch($_GET['menu']){
                            case "tout":
                                $tempo = $_SESSION['table'];
                                break;
                            case "abeille":
                                $tempo = menu($_SESSION['table'],1);
                                break;
                            case "delivrance":
                                $tempo = menu($_SESSION['table'],2);
                                break;
                            case "nouvelle_abeille":
                                $tempo = menu($_SESSION['table'],3);
                                break;
                        }
                    }
                    else{
                        $tempo = $_SESSION['table'];
                    }

                    $case = 0;
                    if(!isset($_GET['nb'])){
                        $_GET['nb'] = 20;
                    }else if ($_GET['nb']>80||$_GET['nb']<20){
                        $_GET['nb']=20;
                    }

                    $total = count($tempo);
                    if(isset($_GET['page'])){
                        if($_GET['page']>0&$_GET['page']<= float_page($total/$_GET['nb'])){
                            $case = page($_GET['page'],$_GET['nb'],$total);
                        }else{
                            $_GET['page']=1;
                        }
                    }

                    if(count($tempo)==0){
                        echo "<div class=\"alert alert-danger\" role=\"alert\">Aucune page trouvée</div>";
                    }else{
                        $tab = $pdo->getTab($tempo,$case,$_GET['nb'],$total);
                        for ($i = 0; $i < count($tab) ;$i++){
                            include('vues/vue_affiche.php');
                    }}?>
            </div>
        </div>
    </div>
</div>
