<link href="../css/awesome.css" rel="stylesheet">
<script defer src="../js/awesome.js"></script>
<a class="btn_retour" href="https://archives.saint-junien.fr/archives/archives-municipales/">Retour au site</a>
<div class="float-left">
    <a class="navbar-brand color-menu" href="http://archives.mairie-saint-junien.fr/">Journaux <br>Numérisés</a>
    <label for="jn" class="color-menu">trier par date</label>
        <?php
        if(isset($_GET['td'])){
            switch($_GET['td']){
                case '1':
                    echo "<button type=\"button\" class=\"btn btn-sj3 dropdown-toggle\"><img src=\"./icon/sort3.svg\" alt=\"\" width=\"21\" height=\"21\" title=\"Bootstrap\" onclick=\"includeGET('td=2&loading=on')\"></button>";
                    break;
                case '2':
                    echo "<button type=\"button\" class=\"btn btn-sj3 dropdown-toggle\"><img src=\"./icon/sort1.svg\" alt=\"\" width=\"21\" height=\"21\" title=\"Bootstrap\" onclick=\"includeGET('td=&loading=on')\"></button>";
                    break;
                default:
                    echo "<button type=\"button\" class=\"btn btn-sj3 dropdown-toggle\"><img src=\"./icon/sort2.svg\" alt=\"\" width=\"21\" height=\"21\" title=\"Bootstrap\" onclick=\"includeGET('td=1&loading=on')\"></button>";
            }
        }else{
            echo "<button type=\"button\" class=\"btn btn-sj3 dropdown-toggle\"><img src=\"./icon/sort2.svg\" alt=\"\" width=\"21\" height=\"21\" title=\"Bootstrap\" onclick=\"includeGET('td=1&loading=on')\"></button>";
        }?>

    <div>
        <label for="jn" class="color-menu"><?php echo $titrev_1; ?></label>
        <div class="btn-group align-items-center">
            <button type="button" class="btn btn-sj3 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="nj">
                <?php
                if($_GET['nb']==20|$_GET['nb']==40|$_GET['nb']==60|$_GET['nb']==90){
                    echo $_GET['nb'];
                }else{
                    echo "20";
                }
                ?>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" onclick="includeGET('nb=20')">20</a>
                <a class="dropdown-item" onclick="includeGET('nb=40')">40</a>
                <a class="dropdown-item" onclick="includeGET('nb=60')">60</a>
            </div>
        </div>
    </div>
</div>