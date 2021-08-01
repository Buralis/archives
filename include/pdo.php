<?php

class PdoGsb
{
    private static $serveur = 'mysql:host=mairiesamz1655.mysql.db';
    private static $bdd = 'dbname=mairiesamz1655';
    private static $user = 'mairiesamz1655';
    private static $mdp = 'Xn3Ajyh5vXyn';
    public static $monPdo;
    private static $monPdoGsb = null;

    private function __construct()
    {
        PdoGsb::$monPdo = new PDO(PdoGsb::$serveur . ';' . PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp);
        PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
    }

    public function _destruct()
    {
        PdoGsb::$monPdo = null;
    }

    public static function getPdoGsb()
    {
        if (PdoGsb::$monPdoGsb == null) {
            PdoGsb::$monPdoGsb = new PdoGsb();
        }
        return PdoGsb::$monPdoGsb;
    }

    //recherche(mot,pr case,nb case,choix menu, date début , date fin, tri date , tri titre, type de recherche) les données sont récupérées depuis le controleur c_loading_on
    function recherche($keyword,$menu,$date_debut,$date_fin,$tridate,$triaz,$typerech){//menu = quel journal/quelle page | 
        $keyword = str_replace("'", "\'", $keyword);//permet de prendre en compte les '

        $where = false; //boolean pour remplacer ou non le WHERE de la requete SQL
        $union = false; //boolean jamais utilisé
        $tab = explode(" ", $keyword); //permet d'obtenir tous les keywords
        $req = "SELECT DISTINCT id,titre,dtjournal,codejournal FROM jnl WHERE"; //requete SQL

        if(isset($menu)&$menu!=0){ // Si le journal est défini et n'égal pas à 0 alors on ajoute à la requete
            $where = true;
            $req = $req . " codejournal = " . $menu;
        }

        if(isset($date_debut)){ // Si la date de début est définie alors on ajoute à la requete
            $where = true;
            if(stristr($req, '=')){
                $req = $req . " AND";
            }
            $req = $req ." dtjournal >= '" . $date_debut."'";
        }

        if(isset($date_fin)){ // Si la date de fin est définie alors on ajoute à la requete
            $where = true;
            if(stristr($req, '=')){
                $req = $req." AND";
            }
            $req = $req . "  dtjournal <= '" . $date_fin."'";
        }
        if($typerech == 1){// Si on fait une recherche en "OU"
            if(count($tab)>1){ // Si il y a plus de 1 keyword
                $where = true;
                if(stristr($req, '=')){
                    $req = $req . " AND";
                }
                $reqtempo = $req;
                //$req = $req . " LOCATE('" .' '.$keyword.' '. "',pleintext)"; // On cherche à quelle position dans les documents se trouve le keyword
                //$req = $req . " UNION " . $reqtempo; // On l'ajoute à la requete
                $req = $req . " LOCATE('" . $keyword . "',pleintext)"; // On cherche à quelle position dans les documents se trouve le keyword
                $req = $req . " UNION " . $reqtempo; // On l'ajoute à la requete

                if(count($tab) == 2){ // Si il y a 2 keywords
                    //$req = $req . " LOCATE('" .' '.$tab[1].' '.$tab[0].' '. "',pleintext)"; // On cherche à quelle position dans les documents se trouvent le deux keywords avec des espaces
                    //$req = $req . " UNION " . $reqtempo; // On l'ajoute à la requete
                    $req = $req . " LOCATE('" .$tab[1].' '.$tab[0]. "',pleintext)";// On cherche à quelle position dans les documents se trouvent les deux keywords
                    $req = $req . " UNION " . $reqtempo; // On l'ajoute à la requete
                }
                $premier = true;
                foreach ($tab as $t){ // Pour tous les keywords
                    if($premier){ // Si c'est le premier keyword
                        $req = $req . " LOCATE('" . $t . "',pleintext)"; // On cherche à quelle position dans les documents se trouve le keyword
                        $premier = false;
                    }
                    else{ // Pour les suivants
                        $req = $req . " AND LOCATE('" . $t . "',pleintext)"; // On cherche à quelle position dans les documents se trouve le keyword
                    }
                }

                foreach ($tab as $t){ // Pour tous les keywords
                    $req = $req . " UNION " . $reqtempo . " LOCATE('" . $t . "',pleintext)"; // On l'ajoute à la requête et on cherche tous les documents qui possède le keyword
                }

            }else if (isset($keyword)){ // Si il n'y a qu'un seul keyword
                $where = true;
                if(stristr($req, '=')){
                    $req = $req . " AND";
                }
                $req = /*$req ." LOCATE('" . $keyword.' '. "',pleintext) UNION ".*/$req. " LOCATE('" . $keyword . "',pleintext)";
            }
        }
        else if($typerech == 2){ //Si on fait une recherche en "ET"
            if(count($tab) > 1){
                $reqtempo = $req;
                $premier = true;
                $where = true;
                if(stristr($req, '=')){
                    $req = $req . " AND";
                }
                foreach($tab as $t){
                    if($premier){
                        $req = $req . " LOCATE('" . $t . "',pleintext)";
                        $premier = false;
                    }
                    else{
                        $req = $req . " AND LOCATE('" . $t . "',pleintext)";
                    }
                }
            }
            else if (isset($keyword)){ // Si il n'y a qu'un seul keyword
                $where = true;
                if(stristr($req, '=')){
                    $req = $req . " AND";
                }
                $req = $req ." LOCATE('" . $keyword.' '. "',pleintext) UNION ".$req. " LOCATE('" . $keyword . "',pleintext)";
            }
        }
        if(!$where) { // Si WHERE est false alors on supprime WHERE de la requete
            $req = str_replace("WHERE", "", $req);
        }
        if(isset($triaz)){ // Si le tri par nom est défini on tri par nom
            if($triaz == 0){
                $req = $req . " ORDER BY titre ASC";
            }else{
                $req = $req . " ORDER BY titre DESC";
            }
        }elseif(isset($tridate)){ // Si le tri par date est défini on tri par date
            if($tridate == 2){
                $req = $req . " ORDER BY dtjournal ASC";
            }else if($tridate == 1){
                $req = $req . " ORDER BY dtjournal DESC";
            }
        }
        $rs = PdoGsb::$monPdo->query($req); // Envoi de la requete
        $ligne = $rs->fetchAll(); // Récupération du tableau
        return $ligne;
    }

    function getTab($id,$debut,$nb_case,$total){
        if($debut+$nb_case-1<$total){
            for ($i=$debut;$i < $debut+$nb_case;$i++){
                if(isset($info)){
                    $info = $info." UNION SELECT * FROM jnl where id=".$id[$i]['id'];
                }else{
                    $info = "SELECT * FROM jnl where id=".$id[$i]['id'];
                }
            }
        }else{
            $fin = count($id)-$debut;
            $fin = $fin + $debut - 1;
            for($i=$debut;$i<=$fin;$i++){
                if(isset($info)){
                    $info = $info." UNION SELECT * FROM jnl where id=".$id[$i]['id'];
                }else{
                    $info = "SELECT * FROM jnl where id=".$id[$i]['id'];
                }
            }
        }
        $rs = PdoGsb::$monPdo->query($info);
        $getTab = $rs->fetchAll();
        return $getTab;
    }

    function count_menu($tableau,$option){
        foreach ($tableau as $i){
            if(isset($info)){
                $info = $info.",".$i['id'];
            }else{
                $info = $i['id'];
            }
        }

        if(isset($info)){
            $req = "SELECT count(codejournal) as code FROM jnl WHERE id IN(".$info.") AND codejournal=".$option;
            $rs = PdoGsb::$monPdo->query($req);
            $getTab = $rs->fetch();
            return $getTab['code'];
        }
        return 0;
    }

    function modallong($id){
        $req = "SELECT titre,pleintext,fichier FROM jnl WHERE id =".$id;
        $rs = PdoGsb::$monPdo->query($req);
        $getTab = $rs->fetch();
        return $getTab;
    }

    function recherche_manquant(){
        $req = "SELECT id,titre,fichier FROM jnl";
        $rs = PdoGsb::$monPdo->query($req);
        $getTab = $rs->fetchAll();
        return $getTab;
    }
}
