// fonctions pour gérer les cookies de thème
function setCookie(name, value, days) {
    let expires = "";

    // si une durée est spécifiée, on calcule la date d'expiration
    if (days) {
        const date = new Date();
        // on ajoute le nombre de jours à la date actuelle en millisecondes
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        //format cookie avec la date d'expiration
        expires = "; expires=" + date.toUTCString();
    }
    // on crée le cookie avec le nom, la valeur, la date d'expiration et le chemin
    document.cookie = name + "=" + value + expires + "; path=/";
}

// fonction pour récupérer la valeur d'un cookie par son nom
function getCookie(name) {
    const nameEQ = name + "=";
    //on stocke tous les cookies dans un tableau en les séparant par le point-virgule
    const cookies = document.cookie.split(';');

    // on parcourt le tableau de cookies pour trouver celui qui correspond au nom recherché
    for (let i = 0; i < cookies.length; i++) {
        let c = cookies[i];

        // on enlève les espaces au début du cookie
        while (c.charAt(0) === ' ') {
            c = c.substring(1, c.length);
        }

        //si c'est le cookie recherché, on retourne sa valeur
        if (c.indexOf(nameEQ) === 0) {
            return c.substring(nameEQ.length, c.length);
        }
    }
    // si aucun cookie trouvé, on retourne null
    return null;
}

//fonction pour basculer entre les thèmes clair et sombre
function toggleTheme() {
    // on récupère l'élément link qui contient la feuille de style du thème
    const theme = document.getElementById("theme-style");
    // on vérifie si le thème actuel est le thème clair
    if (theme.getAttribute("href") === "css/style.css") {

        theme.setAttribute("href", "css/dark.css");
        // on sauvegarde le choix du thème sombre dans un cookie qui expire dans 30 jours
        setCookie("theme", "dark", 30);
    } else {
        // sinon, on bascule vers le thème clair
        theme.setAttribute("href", "css/style.css");
        // on sauvegarde le choix du thème clair dans un cookie qui expire dans 30 jours
        setCookie("theme", "light", 30);
    }
}

// Vérifie le cookie au chargement 
window.onload = function () {
    const savedTheme = getCookie("theme");

    // si le thème sauvegardé est sombre, on applique la feuille de style du thème sombre
    if (savedTheme === "dark") {
        document
            .getElementById("theme-style")
            .setAttribute("href", "css/dark.css");
    }
}