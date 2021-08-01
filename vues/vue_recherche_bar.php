<nav class="barre_navigation navbar navbar-expand-md navbar-sj bg-sj">
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav titre_navigation">
            <button id="button1" class="btn btn-sj btn-lg " type="button" onclick="menu(0)" >Tout <span id="span1" class="badge badge-1"><?php echo isset($_SESSION['table']) ? count($_SESSION['table']) : "0"; ?></span></button>
            <button id="button2" class="btn btn-sj btn-lg" type="button" onclick="menu(1)">L'abeille de saint-Junien <span id="span2" class="badge badge-1"><?php echo isset($_SESSION['table']) ? $pdo->count_menu($_SESSION['table'],1) : "0"; ?></span></br>1881-1944</button>
            <button id="button3" class="btn btn-sj btn-lg" type="button" onclick="menu(2)" >La Délivrance <span id="span3" class="badge badge-1"><?php echo isset($_SESSION['table']) ? $pdo->count_menu($_SESSION['table'],2) : "0"; ?></span></br>1944-1988</button>
            <button id="button4" class="btn btn-sj btn-lg" type="button" onclick="menu(3)" >La Nouvelle Abeille <span id="span4" class="badge badge-1"><?php echo isset($_SESSION['table']) ? $pdo->count_menu($_SESSION['table'],3) : "0"; ?></span></br>1989-2017</button>
        </div>
    </div>
</nav>
<script>
    switch($_GET('menu')){
        case 'abeille':
            document.getElementById("button2").className = "btn btn-sj2 btn-lg";
            document.getElementById("span2").className = "badge badge-2";
            break;
        case 'delivrance':
            document.getElementById("button3").className = "btn btn-sj2 btn-lg";
            document.getElementById("span3").className = "badge badge-2";
            break;
        case 'nouvelle_abeille':
            document.getElementById("button4").className = "btn btn-sj2 btn-lg";
            document.getElementById("span4").className = "badge badge-2";
            break;
        default:
            document.getElementById("button1").className = "btn btn-sj2 btn-lg";
            document.getElementById("span1").className = "badge badge-2";
    }
    switch($_GET('journal')){
        case '1':
            document.getElementById("button5").className = "btn btn-sj2 btn-lg btn-block";
            break;
        case '2':
            document.getElementById("button6").className = "btn btn-sj2 btn-lg btn-block";
            break;
        case '3':
            document.getElementById("button7").className = "btn btn-sj2 btn-lg btn-block";
            break;
        default:
            document.getElementById("button8").className = "btn btn-sj2 btn-lg btn-block";
    }
</script>