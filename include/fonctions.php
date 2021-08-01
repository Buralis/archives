<?php
function page($nb_page,$nb_case,$total_case){
    $case = 0;
    if($nb_page!=0&&$nb_page!=1) {
        $case = $nb_page - 1;
        $case = $nb_case * $case;
        $case = $case + 1;
    }
    if($case == 0){
        return 0;
    }
    if($case <= $total_case){
        return $case-1;
    }
    return null;
}

function float_page($nb){
    if(is_float($nb)){
        return intval($nb)+1;
    }
    return $nb;
}

function menu($tab,$nb){
    $tab2 = array();

    foreach ($tab as $i){
        if($i['codejournal'] == $nb){
            array_push($tab2,$i);
        }
    }
    return $tab2;
}

// "<mark id='1'>" . $item . "</mark>"
function get_Pos_chaine($key,$chaine,$a,$b,$c){
    $table_key = explode(" ", $key);
    $i = 1;
    $newtab = array();
    foreach ($table_key as $i) {
        $taille = 0;
        $choix = "";
        $verif = false;
        foreach ($table_key as $item) {
            if (strlen($item) > $taille) {
                $taille = strlen($item);
                $choix = $item;
                $verif = true;
            }
        }
        if ($verif & $choix != "~§" & $choix != "|§" & $choix != "~" & $choix != "|" & $choix != "§" & $choix != "null") {
            array_push($newtab, $choix);
            unset($table_key[array_search($choix, $table_key)]);
        }
    }
    foreach ($newtab as $item) {
        $chaine = str_replace(strtolower($item), "~§".$item ."|§", strtolower ($chaine));
    }

    $chaine = str_replace("~§", "<mark>", $chaine);
    $chaine = str_replace("|§", "</mark>", $chaine);
    $i=0;
    $verif = true;
    do {
        if(strpos($chaine,"<mark>") !== false){
            $i++;
            $pos = strpos($chaine,"<mark>");
            $chaine = substr_replace($chaine,"<mark id=".$i.">",$pos,6);
        }else{
            $verif = false;
        }
    }while ($verif);
    return $i."*/$~§<a id='0'></a>".$chaine;
}

function tri_date($table,$tri){
    $newtable = array();
    foreach ($table as $i) {
        $verif = false;
        $dtjournal = "0000-00-00";
        $dtjournal2 = date("Y-m-j");
        foreach ($table as $i2){
            if(explode("-",$i2['dtjournal'])[0] > explode("-",$dtjournal)[0] & $tri == 0){
                $dtjournal = $i2['dtjournal'];
                $ligne = $i2;
                $verif = true ;
            }else if (explode("-",$i2['dtjournal'])[0] == explode("-",$dtjournal)[0] & (explode("-",$i2['dtjournal'])[1] > explode("-",$dtjournal)[1] & $tri == 0)){
                $dtjournal = $i2['dtjournal'];
                $ligne = $i2;
                $verif = true ;
            }else if (explode("-",$i2['dtjournal'])[0] == explode("-",$dtjournal)[0] & explode("-",$i2['dtjournal'])[1] == explode("-",$dtjournal)[1] & (explode("-",$i2['dtjournal'])[2] > explode("-",$dtjournal)[2] & $tri == 0)){
                $dtjournal = $i2['dtjournal'];
                $ligne = $i2;
                $verif = true ;
            }
            else if(explode("-",$i2['dtjournal'])[0] < explode("-",$dtjournal2)[0] & $tri == 1){
                $dtjournal = $i2['dtjournal'];
                $ligne = $i2;
                $verif = true ;
            }elseif (explode("-",$i2['dtjournal'])[0] == explode("-",$dtjournal2)[0] & (explode("-",$i2['dtjournal'])[1] < explode("-",$dtjournal2)[1] & $tri == 1)){
                $dtjournal = $i2['dtjournal'];
                $ligne = $i2;
                $verif = true ;
            }elseif (explode("-",$i2['dtjournal'])[0] == explode("-",$dtjournal2)[0] & explode("-",$i2['dtjournal'])[1] == explode("-",$dtjournal2)[1] & (explode("-",$i2['dtjournal'])[2] < explode("-",$dtjournal2)[2] & $tri == 1)){
                $dtjournal = $i2['dtjournal'];
                $ligne = $i2;
                $verif = true ;
            }
        }
        if($verif){
            array_push($newtable,$ligne);
            unset($table[array_search($ligne, $table)]);
        }
    }
    return $newtable;
}
