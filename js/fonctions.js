function $_GET(param) {
    var vars = {};
    window.location.href.replace(location.hash, '').replace(
        /[?&]+([^=&]+)=?([^&]*)?/gi,
        function(m, key, value) {
            vars[key] = value !== undefined ? value : '';
        }
    );
    if (param) {
        return vars[param] ? vars[param] : null;
    }
    return vars;
}

function getXMLHttpRequest() {
    var xhr = null;
    if (window.XMLHttpRequest || window.ActiveXObject) {
        if (window.ActiveXObject) {
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        } else {
            xhr = new XMLHttpRequest();
        }
    } else {
        alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
        return null;
    }
    return xhr;
}

function includeGET(get) { // Met en forme l'URL pour sa récupération par le PHP
    var n = window.location.search.split('&'); // On sépare la chaine de caractère de l'URL
    var n2, test, test2;
    var get2 = get.split('&'); // On sépare la chaine de caractère de la requete
    n[0] = n[0].substr(1); //enleve ?
    //pour toutes les variables
    for (var y = 0; y < get2.length; y++) { // Pour tous les éléments de la chaine de caractere de la requete
        test = false;
        for (var i = 0; i < n.length; i++) { // pour toutes les variable du lien
            if (n[i].split('=')[0] == get2[y].split('=')[0]) { // si la variable est dans le lien
                n[i] = get2[y]; //alors renplacer la variable
                test = true; // test true
            }
        }
        if (!test) { //si il n'est pas dans le lien
            if (n.length > 0) { //si il y a déja une variable
                n.push(get2[y]);
            } else { //sinon n = variable
                n[0] = get2[y];
            }
        }
    }
    for (var i = 0; i < n.length; i++) { //pour tout les variable du lien
        test2 = false;
        if (n2 == null) {
            n2 = n[i];
            test2 = true;
        } else if (!test2) {
            n2 = n2 + "&" + n[i];
        }
    }
    window.location.search = n2;
}

function menu(nb) {
    switch (nb) {
        case 0:
            includeGET("menu=tout&page=1");
            break;
        case 1:
            includeGET("menu=abeille&page=1");
            break;
        case 2:
            includeGET("menu=delivrance&page=1");
            break;
        case 3:
            includeGET("menu=nouvelle_abeille&page=1");
            break;
    }
}

function recherche() { // Prépare les données pour la fonction includeGET
    var date1 = new Date(document.getElementById('date_debut').value);
    var date2 = new Date(document.getElementById('date_fin').value);

    if (date1 < date2) {
        includeGET(
            'keyword=' + document.getElementById('keyword').value +
            '&date_debut=' + document.getElementById('date_debut').value +
            '&date_fin=' + document.getElementById('date_fin').value +
            '&loading=on' +
            '&type_recherche=' + document.getElementById('type_recherche').value +
            '&recherche=true');
    } else {
        includeGET(
            'keyword=' + document.getElementById('keyword').value +
            '&date_debut=' + "" +
            '&date_fin=' + "" +
            '&loading=on' +
            '&type_recherche=' + document.getElementById('type_recherche').value +
            '&recherche=true');
    }
}

function get_Modallong(id) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200 || xhr.status == 0) {
                if (xhr.responseText == "") {} else {
                    location.href = "#0";
                    $.confirm({
                        columnClass: 'col-md-4 col-md-offset-8 col-xs-4 col-xs-offset-8',
                        containerFluid: true,
                        type: 'dark',
                        title: xhr.responseText.split('*/$~§')[0] + "<br><br><p>Occurence : " + xhr.responseText.split('*/$~§')[1] + "</p>",
                        content: xhr.responseText.split('*/$~§')[2],
                        buttons: {
                            form1: {
                                text: '⬆',
                                action: function() {
                                    var i = location.href;
                                    i = i.split('#')[1];
                                    i--;
                                    if (document.getElementById(i)) {
                                        location.href = "#" + i;
                                    }
                                    return false;
                                }
                            },
                            form2: {
                                text: '⬇',
                                action: function() {
                                    var i = location.href;
                                    i = i.split('#')[1];
                                    i++;
                                    if (document.getElementById(i)) {
                                        location.href = "#" + i;
                                    } else {
                                        location.href = "#0";
                                    }
                                    return false;
                                }
                            },
                            formSubmit: {
                                text: 'PDF',
                                btnClass: 'btn-blue',
                                action: function() {
                                    window.open('http://archives.saint-junien.fr/application/pdf/' + xhr.responseText.split('*/$~§')[3], '_blank');
                                    return false;
                                }
                            },
                            fermer: {
                                btnClass: 'btn-danger',
                                text: 'FERMER',
                                action: function() {}
                            }
                        },
                        onContentReady: function() {
                            // bind to events
                            var jc = this;
                            this.$content.find('form').on('submit', function(e) {
                                e.preventDefault();
                                jc.$$formSubmit.trigger('click');
                            });
                        }
                    });
                }

            }
            if (xhr.status == 404) alert("404");
            if (xhr.status == 500) alert("500");
        }
    }
    xhr.open("GET", "controleurs/c_get-text.php?id=" + id + "&keyword=" + $_GET("keyword"), true);
    xhr.send();
}