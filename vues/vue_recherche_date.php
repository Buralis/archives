<link rel="stylesheet" href="css/datepicker.css">
    <div class="float-left">
        <div class="dropdown bd-highlight">
            <label class="color-menu">Choisir un journal</label>
            <button type="button" class="btn btn-sj3 dropdown-toggle" data-toggle="dropdown">
                <?php
                if(isset($_GET['journal'])){
                    switch ($_GET['journal']){
                        case 1:
                            echo "L'abeille de saint-Junien";
                            break;
                        case 2:
                            echo "La Délivrance";
                            break;
                        case 3:
                            echo "La Nouvelle Abeille";
                            break;
                        default:
                            echo "Choisir";
                    }
                }else{
                    echo "Choisir";
                }
                ?>
            </button>
            <div class="dropdown-menu">
                <button id="button8" class="btn btn-sj btn-lg btn-block" type="button" onclick="includeGET('journal=')" >Aucun</button>
                <button id="button5" class="btn btn-sj btn-lg btn-block" type="button" onclick="includeGET('journal=1')">L'abeille de saint-Junien</button>
                <button id="button6" class="btn btn-sj btn-lg btn-block" type="button" onclick="includeGET('journal=2')" >La Délivrance</button>
                <button id="button7" class="btn btn-sj btn-lg btn-block" type="button" onclick="includeGET('journal=3')" >La Nouvelle Abeille</button>
            </div>
        </div>
        <div>
            <label for="date1" class="color-menu"><?php echo $titrev_2;?> </label>
            <input type="date"  id="date_debut"  value="<?php echo isset($_GET['date_debut']) && strlen($_GET['date_debut']) > 0 ? $_GET['date_debut'] : null ;?>">
            <label for="date2" class="color-menu"><?php echo $titrev_3;?></label>
            <input type="date"  id="date_fin"  value="<?php echo isset($_GET['date_fin']) && strlen($_GET['date_fin']) > 0 ? $_GET['date_fin'] : null ;?>">
        </div>
    </div>
    <div class="float-left">
        <label for="jn" class="color-menu">Modifier la recherche</label>
        <?php
        if(isset($_GET['type_recherche'])){
            switch($_GET['type_recherche']){

                case '1':
                    echo "<button id=\"type_recherche\" value=\"2\" type=\"button\" class=\"recherche_btn btn btn-sj3\" onclick=\"includeGET('type_recherche=2&loading=on')\">Un seul critère</button>";
                    break;
                case '2':
                    echo "<button id=\"type_recherche\" value=\"1\" type=\"button\" class=\"recherche_btn btn btn-sj3\" onclick=\"includeGET('type_recherche=1&loading=on')\">Tous les critères</button>";
                    break;
                default:
                    echo "<button id=\"type_recherche\" value=\"2\" type=\"button\" class=\"recherche_btn btn btn-sj3\" onclick=\"includeGET('type_recherche=1&loading=on')\">Tous les critères</button>";        }
        }else{
            echo "<button id=\"type_recherche\" value=\"2\" type=\" button\" class=\"recherche_btn btn btn-sj3\" onclick=\"includeGET('type_recherche=1&loading=on')\">Tous les critères</button>";    }
        ?>
        <input class="form-control mr-sm-2 mgtp" id="keyword" type="search" placeholder="Recherche"
            <?php echo isset($_GET['keyword']) && strlen($_GET['keyword']) > 0 ? 'value="'. str_replace('"', '', $_GET['keyword']).'"' : null;?>
            aria-label="Recherche" onkeydown="if (event.keyCode == 13) document.getElementById('recherche_bar').click()">
        <button id="recherche_bar" class="mgtp recherche_btn btn btn-sj3  my-2 my-sm-0" type="submit" onclick="recherche()">Recherche</button> <!-- envoi les données des formulaires à la fonction recherche présente dans fonctions.js -->
    </div>

    <div class="accordion mb-1" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Numéros manquants
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <p>n°298 du 27 mars 1887</p>
                    <p>n°804 du 20 décembre 1896</p>
                    <p>n°42 du 19 octobre 1912</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Numéros jamais édités
                    </button>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    <p>n°2 du 22 janvier 1921</p>
                    <p>n°18 du 20 août 1921</p>
                    <p>n°22 du 14 octobre 1922</p>
                </div>
            </div>
        </div>
    </div>

