window.onload = function() { //Au chargement de la page
    let valeurCookie = false //On définie l'accès comme faux par défaut
    let modalCookie = document.getElementById("section_cookie")
    let accepte = document.getElementById("cookie_accept")
    let refuse = document.getElementById("cookie_refuse")

    function accepteCookie() { //Fonction appellée quand on accepte les conditions
        modalCookie.classList.toggle("active") //On fait disparaitre le modal
        let date = new Date(); //On définit une date
        date.setTime(date.getTime() + (7 * 24 * 60 * 60 * 1000));
        let expires = "expires=" + date.toUTCString();
        document.cookie = "cliqueLicence" + "=" + 0 + ";" + expires + ";path=/;"; //On crée le cookie

        document.location.reload(); //On recharge la page
    }

    function refuseCookie() { //Fonction appellée quand on refuse les conditions
        document.location.reload(); //On recharge la page
    }

    function getCookie() { //Fonction pour récupéré le cookie
        let name = "cliqueLicence" + "="; //On définie le nom du cookie utilisé par le site
        let ca = document.cookie.split(';'); //On sépare les différents cookies du site
        for (let i = 0; i < ca.length; i++) { //On parcours la liste des cookies
            let c = ca[i];
            while (c.charAt(0) == ' ') { //quand il y a un espace
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) { //quand le cookie existe
                valeurCookie = true; //on donne la valeur vraie
            }
        }

        if (valeurCookie == false) { //si la valeur est restée sur false
            modalCookie.classList.toggle("active") //on ouvre le modal
            accepte.addEventListener("click", accepteCookie) //On définie le bouton accepter
            refuse.addEventListener("click", refuseCookie) //On définie le bouton refuser
            window.addEventListener("scroll", function(e) { //On empeche le scroll

                window.scrollTo(0, 0);

            }, false);
        }
    }

    getCookie()
}